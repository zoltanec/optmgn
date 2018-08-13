#!/usr/bin/python
# -*- coding: utf-8 -*-

import xmpp,MySQLdb,time,threading,thread,sys,random,os,sys,signal, smtplib,urllib,base64
import hashlib

from optparse import OptionParser
from jsup.helpers import *
from jsup.thsql import ThMysql
import jsup.geoip
class Config:
	db_username = ''
	db_password = ''
	db_name     = ''
	db_prefix   = ''
	realm       = ''
	api         = False
	greetings   = False
	geoip       = False

	@staticmethod
	def init():
		p = OptionParser()
		p.add_option('-u','--username',dest="username",help="database username",metavar="DBUSERNAME",default=False)
		p.add_option('-p','--password',dest="password",help="database password",metavar="DBPASSWORD",default=False)
		p.add_option('-n','--database',dest="database",help="database name",    metavar="DBNAME",default=False)
		p.add_option('--px', dest="prefix",  help="database tables prefix",default=False)
		p.add_option('-r', dest="realm", help="jabber server realm name", default=False)
		p.add_option('-a','--api', dest="api", help="api server", metavar="APIURL", default=False)
		p.add_option('-o','--operators',dest="operators", help="operators list", metavar="OPERATORS", default=False)
		p.add_option('-g','--greetings',dest="greetings", help="file with greetings message", metavar="FILE", default=False)
		p.add_option('-i', '--geoip', dest="geoip", help="GeoIP Lite database file", metavar="FILE",default=False)
		p.add_option('--dict', dest="dictionary", help="Dictionary of short words", metavar="FILE",default=False)

		(options, args) = p.parse_args()


		for opt in ['username','password','database','prefix','realm','operators']:
			if not getattr(options,opt):
				log("""Unseted option: %s""" % ( opt ) )
				sys.exit()

		Config.db_username = options.username
		Config.db_prefix   = options.prefix
		Config.db_password = options.password
		Config.db_name     = options.database
		Config.realm       = options.realm
		Config.api         = options.api
		Config.operators   = options.operators.split(',')
		Config.geoip       = options.geoip

		if options.dictionary:
			CJDicts.getInstance().load_from_file(options.dictionary)

		if os.path.exists( str(options.greetings) ):
			log("""Loaded greetings file: %s""" % ( options.greetings ))
			gr = open( options.greetings, 'r')
			Config.greetings = gr.read()
			gr.close()

class ServerApi:
	lock = False

	@staticmethod
	def call(client, command, query = ''):
		if not Config.api:
			return ''

		ServerApi.lock.acquire()
		data = {'client' : client, 'command' : command, 'query' : query.encode('utf-8')}
		try:
			try:
				params = urllib.urlencode(data)
				url = urllib.urlopen(Config.api, params)
				result = url.read().rstrip()
				log(result)
			except:
				result = ''
			return result
		except:
			log("""Unable to execute web request.""",exc=True)
			return ''
		finally:
			ServerApi.lock.release()
ServerApi.lock = threading.Lock()

class GeoIP:
	_inst = False
	lock  = False
	db    = False

	@staticmethod
	def getInstance():
		if not GeoIP._inst:
			GeoIP._inst = GeoIP()
		return GeoIP._inst
	def __init__(self):
		self.lock = threading.Lock()
		if Config.geoip:
			log("""Opening GeoIP database from %s""" % ( Config.geoip ))
			if not os.path.exists(Config.geoip):
				log("""GeoIP File doesn't exists!!!""")
				return False

			self.db = jsup.geoip.Database(Config.geoip)

	def info(self,ip):
		if not self.db:
			return False
		self.lock.acquire()
		try:
			info = self.db.lookup(ip)
		except:
			info = False
		self.lock.release()
		return info

class CJDicts:
	instance = False
	lock = False
	dictionary = {}

	@staticmethod
	def getInstance():
		if CJDicts.instance:
			return CJDicts.instance
		CJDicts.instance = CJDicts()
		return CJDicts.instance
	
	def __init__(self):
		self.lock = threading.Lock()
	
	def load_from_file(self, filename):
		if not os.path.exists(filename):
			return False

		log("""Loading additional messages dictionary from file""")

		dict_file = open(filename,'r')
		data = dict_file.readlines()
		dict_file.close()

		for line in data:
			try:
				value, text = line.split(' => ')
				self.setEntry(value.rstrip(), text.rstrip())
			except:
				log("""Unable to parse entry: %s""" % ( line ))
				continue
		return True


	
	def haveEntry(self, value):
		return value in self.dictionary
	
	def getEntry(self, value):
		return self.dictionary[value]

	def setEntry(self, value, text):
		log("""Added new short entry: [%s] to %s""" % ( value, text))
		self.dictionary[value] = text 
	
	def getAll(self):
		return self.dictionary


class CJMonitor(threading.Thread):
	username = 'status'
	password = '123456'

	statuses = {} 
	jid = ''
	lock = False

	instance = False

	def __init__(self):
		threading.Thread.__init__(self)
		self.lock = threading.Lock()
		CJMonitor.instance = self

	def isJidOnline(self, jid):
		self.lock.acquire()
		if jid in self.statuses:
			status = self.statuses[jid]['status']
		else:
			status = False
		self.lock.release()
		return status

	def get_active_operators(self):
		active = []
		for jid in self.statuses.keys():
			if self.statuses[jid]['status']:
				active.append(jid)
		return active

	@staticmethod
	def isOnline(jid):
		return CJMonitor.instance.isJidOnline(jid)
	
	@staticmethod
	def opName(jid):
		return CJMonitor.instance.getOpName(jid)

	@staticmethod
	def fullJid(jid):
		return CJMonitor.instance.getFullJid(jid)
	
	def getFullJid(self, jid):
		self.lock.acquire()
		full_jid = self.statuses[jid]['full']
		self.lock.release()
		return full_jid

	def getOpName(self,jid):
		self.lock.acquire()
		name = self.statuses[jid]['name']
		self.lock.release()
		return name

	def presence(self, conn, event):
		jabber_from = event.getFrom().getStripped()
		jid_full = event.getFrom()

		if jabber_from == self.jid:
			return True
		
		if not jabber_from in self.statuses:
			log("""Ignore status from non-operator %s""" % ( jabber_from ))
			return False

		typ = event.getType()
		if event.getType() == 'subscribe':
			log("""Subscribe event from %s""" % ( jabber_from )) 
			self.c.Roster.Authorize(jabber_from)
			self.c.Roster.Subscribe(jabber_from)
			return True
			
		self.lock.acquire()
		if typ == "unavailable":
			show = typ
		else:
			show = event.getTagData("show")
			if not show:
				show = "available"
#				message = xmpp.protocol.Message(to=jabber_from,body=", typ='chat')
		status = True if show == 'available' else False
		
		global db
		db.execute("INSERT INTO #PX#_support_chat_status (operator, upd_time, status) VALUES (%s, UNIX_TIMESTAMP(), %s) ON DUPLICATE KEY UPDATE status = VALUES(status), upd_time = VALUES(upd_time)", ( jabber_from, str(int(status)))) 

		log("""Updated status for %s => %s""" % ( jabber_from, str(status) ))
		self.statuses[jabber_from]['status'] = status
		self.statuses[jabber_from]['full'] = jid_full
		self.lock.release()

		return True

	def message(self, conn, event):
		global db
		msg = event.getBody()
		jid_full = event.getFrom()

		jabber_from = event.getFrom().getStripped()
		if msg and event.getType() == 'chat':
			cmd = msg.split(' ')[0].lstrip().rstrip()
			log("""Recieved chat message from %s => %s""" % ( jabber_from, msg ) ) 
			answer = ''
			if cmd == 'who':
				log("Recieved operators list command")
				answer = "Operators statuses:"
				for op in self.statuses.keys():
					answer += """\n [%s] %s is %s""" % ( str(self.statuses[op]['name']), str(self.statuses[op]['full']), str(self.statuses[op]['status'] ))
			
			elif cmd == 'sess':
				answer = "Sessions list:"
				sessions = db.fetchlines("SELECT client,operator,upd_time FROM #PX#_support_chat_session")
				for session in sessions:
					answer += """%s => %s""" % ( session[0], session[1] )
			elif cmd == 'force':
				self.statuses[jabber_from]['full'] = jid_full
				answer = "Main resource updated to " + str(jid_full)
			elif cmd == 'auth':
				answer = "Trying to reauthorize you..."
				self.c.Roster.Authorize(jabber_from)
				self.c.Roster.Subscribe(jabber_from)
			elif cmd == 'sa':
				try:
					splited = msg.split(' ')
					short_msg = splited[1]
					long_msg  = " ".join(splited[2:])
					answer = """Added new short message: %s => %s""" % ( short_msg, long_msg )
					CJDicts.getInstance().setEntry(short_msg, long_msg)
				except:
					debug("""Can't add short message""")
					answer = "Can't add short message"

			elif cmd == 'sl':
				short_msgs = CJDicts.getInstance().getAll()
				answer = "\n"
				for msg in short_msgs:
					answer += """%s => %s\n""" % ( msg, short_msgs[msg] )

			elif cmd == 'name':
				if jabber_from in self.statuses:
					name = " ".join(msg.split(' ')[1:])
					old_name = self.statuses[jabber_from]['name']
					self.statuses[jabber_from]['name'] = name
				answer = """Updated operator name for your account %s => %s""" % ( old_name, name )
			message = xmpp.protocol.Message(to=jid_full, body=answer, typ='chat')
			self.c.send(message)
		return True

	def iq(self, connf, event):
		return True
	
	def connect(self):
		jid = xmpp.protocol.JID( self.jid + '/US')
		self.c = xmpp.Client(jid.getDomain(),debug=[])
		conn = self.c.connect( server = ('127.0.0.1',5222))
		try:
			auth = self.c.auth(jid.getNode(), self.password, resource=jid.getResource())
		except:
			log('Cant authorize user ' + self.username + '. Caused exception!!', exc=True )
		for op in Config.operators:
			self.statuses[op] = {'status': False, 'full': op, 'name' : op.split('@')[0].title()}
		self.c.RegisterHandler('iq', self.iq )
		self.c.RegisterHandler('presence', self.presence )
		self.c.RegisterHandler('message', self.message) 
		self.c.sendInitPresence(requestRoster=1)
		log("Starting monitoring")


	def run(self):
		self.jid = self.username + '@' + Config.realm
		self.connect()

		for op in Config.operators:
			log("""Subscribe for %s""" % ( op ))
			self.c.Roster.Authorize(op)
			self.c.Roster.Subscribe(op)
			self.c.send(xmpp.protocol.Message(to=op,body="Please, authorize this contact and add it to your contact list to allow us monitor your status",typ='chat'))

		log("""Jabber monitoring daemon started""")
		while self.c.Process(1):
			time.sleep(1)
			pass

		log("""Jabber process exited. Restarting it""")



# chat-jabber-link class
class CJLink(threading.Thread):
	session_started = 0
	session_timeout = 0.5 
	# somebody answered to this link ?
	session_initiated = False
	current_operator = False
	#messages IN/OUT
	messages_in = 0
	messages_out = 0
	# messages pool
	pool_in = list()
	pool_out = list()
	# last message from operator 
	last_op_message = 0
	last_cl_message = ''
	db = False
	username = 'NONAME'
	c = False
	# if this session was holded
	hold = False
	hold_time = 0

	ip = '127.0.0.1'

	stream = ''

	exited = False

	# build MD5 hash
	def md5(self, content):
		hasher = hashlib.md5()
		hasher.update(content)
		return hasher.hexdigest()
	
	# creating new connection
	def __init__(self,client):
		# initializing
		threading.Thread.__init__(self)
		self.client = client
	
	def initiate(self):
		# connecting to MySQL database
		self.last = time.time()
		self.session_started = time.time()
		global db
		self.db = db

		self.db.reconnect()
		
		self.username = self.client
		self.password = '123456'

		data = self.db.fetchline("""SELECT stream,ip FROM #PX#_support_chatmsg WHERE client = %s AND type = 'in' LIMIT 1""", ( self.client ))
		self.stream = data[0]
		self.ip     = data[1]


		if Config.api:
			self.username = ServerApi.call(self.client, 'username')
		else:
			self.username = self.client

		log("""Client IP: %s""" % ( self.ip ))

		# creating JID protocol

		jid = xmpp.protocol.JID( self.username.replace('@' + Config.realm,'').replace('@', '_at_') + '@' + Config.realm + '/US')
		# creating new jabber client
		self.c = xmpp.Client(jid.getDomain(),debug=[])
		conn = self.c.connect( server = ('127.0.0.1',5222))

		# authorizing 
		try:
			auth = self.c.auth(jid.getNode(), self.password, resource='J')
		except:
			log('Cant authorize user ' + self.username + '. Caused exception!!', exc=True )
			return False

		if not auth:
			log('Cant authorize user ' + self.username)
			return False

		log('User ' + self.username + ' authorized')
		self.register_handlers()
		self.c.sendInitPresence(requestRoster=0)

		if Config.greetings:
			self.send_to_client(Config.greetings)

		return True

	def respam_oper(self):
		log("""Respaming operators...""")
		diff = round( ( time.time() - self.session_started) / 60 )
		if diff > 0:
			self.send("""This user is waiting for answer for %d minutes.""" % ( diff ), antirepeat=False)

		# resend initialization statistic
		if diff in [0,30,60]:
			self.resend_stat()

	# resending initiation strings
	def resend_stat(self, msg = False):
		log("""Reinitiating connection for client %s""" % ( self.client ))

		data = """Request from client: %s""" % ( self.client ) 
		data += ServerApi.call(self.client, 'init')
		try:
			message = self.db.fetchline("""SELECT GROUP_CONCAT(CONCAT("\n", msg)) AS msg FROM #PX#_support_chatmsg WHERE client = %s AND type = 'in' ORDER BY msgid ASC LIMIT 1""", ( self.client ))
			data += """\n\nFirst msg: %s""" % ( message[0] )
		except:
			data = "..."
		try:
			geo = GeoIP.getInstance().info(self.ip)
			data += """\n\nCountry: %s\nCity: %s\nRegion: %s\n""" % ( geo.country, geo.city, geo.region )
		except:
			log("""Unable to find info for %s""" % ( self.ip ))

		if msg:
			data += "\n\nResend notice: " + msg
		self.send(data, antirepeat=False)

	# sending XMPP message
	def send(self, msg, in_operator = '', antirepeat=True):
		if antirepeat and self.last_cl_message == self.md5(msg):
			log("""Ignored repeted message: %s""" % ( msg ))
			return True

		self.last_cl_message = self.md5(msg)

		# checking if we need to notify needed operator
		if in_operator != '':
			operator = in_operator
		else:
			operator = self.current_operator

		# messages to user
		self.messages_out = self.messages_out + 1
		self.last = time.time()

		try:
			if operator:
				log('Message: ' + self.username + ' => ' + operator)
				self.c.send(xmpp.protocol.Message(to=CJMonitor.fullJid(operator),body=msg,typ='chat'))
			else:
				log("""Trying to find any free operator...""")
				for op in Config.operators:
					if CJMonitor.isOnline(op):
						full_jid = CJMonitor.fullJid(op)
						log("""Sending to %s ( %s )""" % ( op, str(full_jid) )) 
						self.c.send(xmpp.protocol.Message(to=CJMonitor.fullJid(op),body=msg,typ='chat'))
					else:
						log("""Operator %s is offline, ignoring it""" % ( op ) )

		except:
			log("Unable to send message",exc=True)
			return False

	def exit(self):
		try:
			self.c.disconnect()
		except:
			log("""Disconnected""")
		self.exited = True
		#thread.exit()
		return False

	
	# registering needed handlers
	def register_handlers(self):
		self.c.RegisterHandler('message',self.message)
	
	# get conversation logs from client
	def get_history(self, count):
		messages = self.db.fetchlines("SELECT type,msg FROM #PX#_support_chat_logs WHERE client = %s ORDER BY msgid DESC LIMIT " + str(count), ( self.client ))
		reply = ""
		for msg in messages:
			if msg[0] == 'out':
				suffix = "support"
			else:
				suffix = "client"
			reply = """%s: %s\n""" % ( suffix, msg[1] ) + reply
		self.send(reply)


	# we recieve message,proceed
	def message(self,con,event):
		msg = event.getBody()
		if msg and event.getType() == 'chat':
			jabber_from = event.getFrom().getStripped()

			if msg[:5] == '?OTR:':
				self.c.send(xmpp.protocol.Message(to=jabber_from,body="Recieved OTR message. Ignoring it. Switch off OTR please!", typ='chat'))
				return True

			self.messages_in = self.messages_in + 1
			if not self.current_operator:
				self.current_operator = jabber_from
				log("""Accepted operator %s for user %s.""" % (self.current_operator, self.username ))
				self.send_to_history("""Accepted operator %s""" % (self.current_operator))
				self.send_to_client("""Operator %s connected""" % ( CJMonitor.opName(jabber_from)))
				self.db.execute("INSERT INTO #PX#_support_chat_session (client,operator,upd_time) VALUES (%s,%s,UNIX_TIMESTAMP()) ON DUPLICATE KEY UPDATE operator = VALUES(operator), upd_time = VALUES(upd_time)", ( self.client, jabber_from ) )
				self.session_initiated = time.time()

				for other in CJMonitor.instance.get_active_operators():
					if other == self.current_operator:
						continue
					self.send("""Operator %s answered""" % ( self.current_operator ), other, antirepeat = False)
			
			log('Message: ' + self.current_operator + ' => ' + self.username )

			if CJDicts.getInstance().haveEntry(msg):
				msg = CJDicts.getInstance().getEntry(msg)
				self.send("""Unpacked to %s""" % ( msg ))

			if msg[0] == '!':
				command = msg.split(' ')[0]
				log("""Recieved command %s from operator %s""" % (command, jabber_from  ))
				
				if command == '!forceget':
					self.send("""Operator %s forced...""" % ( jabber_from ), self.current_operator)
					self.send("""Session intercepted from %s ...""" % ( self.current_operator ) , jabber_from )
					self.current_operator = jabber_from 

				elif command == '!hold':
					self.hold = True
					self.hold_time = time.time()

					self.send("""Session will be on hold""")

				elif command == '!l':
					self.send("""Reading history for account""")
					try:
						count = int(msg.split(' ')[1])
					except:
						count = 20
					
					self.get_history(count)

				elif command == '!forceinit':
					self.send("""Force reinitiation started""")
					self.current_operator = False
					if len(msg.split(' ')) > 1:
						self.resend_stat(' '.join( msg.split(' ')[1:] ))
					else:
						self.resend_stat()

				elif command == '!forceexit':
					return self.exit()
				
				# this is some kind of unknown command
				else:
					# data 
					try:
						server = ServerApi.call(self.client, 'command', msg)
						for answer in server.split("\n"):
							try:
								mode, msg_raw = answer.split(':')
								decoded_msg = base64.decodestring(msg_raw)
								if mode == 'client':
									self.send_to_client(decoded_msg)
								else:
									self.send(decoded_msg)
							except:
								log("""Wrong answer format!""", exc=True)
					except:
						log("""Unable to execute unknown API command""", exc=True)

					
			else:
				if self.current_operator != jabber_from:
					self.send("""This session is owned by %s. Use !forceget to intercept it.""" % ( self.current_operator ), jabber_from, antirepeat=False )
				self.send_to_client(msg)

		
	def send_to_history(self, msg, mtype = 'in'):
		self.db.execute("INSERT INTO #PX#_support_chat_logs (client, msg, stream, type, add_time) VALUES (%s, %s, %s, %s, UNIX_TIMESTAMP())", ( self.client, msg, self.stream, mtype))
		return True

	def send_to_client(self, msg):
		self.db.execute("""INSERT INTO #PX#_support_chatmsg (client,type,msg,operator,stream) VALUES (%s,'out',%s, %s, %s)""",(self.client, msg, self.current_operator, self.stream )) 
		self.send_to_history(msg,'out')

	def run(self):
		# starting connection and other stuff
		if not self.initiate():
			return False

		try:
			while not self.exited and ( self.hold or ( self.c.Process(1) and self.last > time.time() - self.session_timeout * 3600 ):
				
				if self.hold and self.hold_time < time.time() - 60 * 15:
					self.send("""This session is waiting on hold. Please react.""")

				# we can process only 
				if self.current_operator:
					# selecting all messages
					msgs = self.db.fetchlines("""SELECT msgid,msg FROM #PX#_support_chatmsg WHERE client = %s AND type = 'in' ORDER BY msgid ASC""",(self.client))
					readed_id = list()
					
					# parsing messages
					for msg in msgs:
						self.send(msg[1])
						self.db.execute("""DELETE FROM #PX#_support_chatmsg WHERE msgid = %s """,(msg[0]))
						readed_id.append(str(msg[0]))
					
					if readed_id:
						self.db.execute("""DELETE FROM #PX#_support_chatmsg WHERE msgid IN ( %s )""",(','.join(readed_id)))
						self.send_to_history(msg[1],'in')
				else:
					# now operator? lets spam user	
					if self.last_op_message < time.time() - 300:
						self.last_op_message = time.time()
						self.respam_oper()
			total_time = round( ( time.time() - self.session_initiated )/60)
			self.send("""Chat session closed. Total chat time: %d min.""" % ( total_time ))
			log("Chat session for user " + self.username + " expired. Exiting...")
			self.db.execute("DELETE FROM #PX#_support_chat_session WHERE client = %s LIMIT 1", ( self.client ))
			# disconnecting our chat client
			return False

		except KeyboardInterrupt:
			pass
		except:
			log("""Bad formated messages. Lets delete them out! Error: %s""" % ( str(sys.exc_info()) ))
			self.db.execute("""DELETE FROM #PX#_support_chatmsg WHERE client = %s""",  self.client ) 

check_single_running()
Config.init()
for op in Config.operators:
	log("""Loaded operator: %s""" % ( op ) )
# connecting to database
db =  ThMysql(prefix=Config.db_prefix, username=Config.db_username, password=Config.db_password, name=Config.db_name)
log("Jabber-Chat program started.")
# thread pool
threads = {}
threads['status'] = CJMonitor()
threads['status'].start()

# starting main loop
while 1:
#	log("Checking for clients messages...")
	# selecting
	clients = db.fetchlines("""SELECT DISTINCT(client) FROM #PX#_support_chatmsg WHERE add_time < UNIX_TIMESTAMP() - 10 AND type = 'in'""")
	# checking if we have this 
	for client_arr in clients:
		client = client_arr[0]
		if client in threads:
			if threads[client].isAlive():
				continue
			else:
				del(threads[client])
		else:
			# creating new thread in pool
			threads[client] = CJLink(client)
			threads[client].start()
	time.sleep(2)
