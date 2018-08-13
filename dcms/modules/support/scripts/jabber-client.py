#!/usr/bin/python
# -*- coding: utf-8 -*-

import xmpp,base64,time,threading,thread,sys
from thsql import ThMysql
from optparse import OptionParser
from helpers import *

class Config:
	db_username = ''
	db_password = ''
	db_name     = ''
	db_prefix   = ''
	
	jabber_username = ''
	jabber_password = ''
	jabber_hostname = ''
	jabber_port     = ''

	@staticmethod
	def init():
		p = OptionParser()
		p.add_option('-u','--username',dest="username",help="database username",metavar="DBUSERNAME",default=False)
		p.add_option('-p','--password',dest="password",help="database password",metavar="DBPASSWORD",default=False)
		p.add_option('-n','--database',dest="database",help="database name",    metavar="DBNAME",default=False)
		p.add_option('--px', dest="prefix",  help="database tables prefix",default=False)
		p.add_option('--jabber-username', dest="j_username", help="jabber server username", default=False) 
		p.add_option('--jabber-password', dest="j_password", help="jabber server password", default=False)
		p.add_option('--jabber-hostname', dest="j_hostname", help="jabber server hostname", default=False)
		p.add_option('--jabber-port', dest="j_port", help="jabber server port", default=5223)

		( options, args ) = p.parse_args()

		Config.db_username = options.username
		Config.db_prefix   = options.prefix
		Config.db_password = options.password
		Config.db_name     = options.database

		Config.jabber_username = options.j_username
		Config.jabber_password = options.j_password
		Config.jabber_hostname = options.j_hostname
		Config.jabber_port     = options.j_port



def presence(connection, event):
	if event.getType() == 'subscribe':
		try:
			jid = event.getFrom().getStripped()
			global c
			c.Roster.Authorize(jid)	
			c.Roster.Subscribe(jid)
			log("""Authorized %s""" % ( jid ))
		except:
			log("""Unable to authorize""", exc=True)
	else:
		log("""Unknown event type: %s""" % ( event.getType() ))

def message(connection, event):
	log("""Recieved %s""" % ( event.getType() ))
	global db
	client = event.getFrom().getStripped().lower().replace('@','_AT_')
	msg = event.getBody()

	if msg and event.getType() == 'chat':
#		log("""Recieved %s => %s: %s""" % ( client, event.getType(), msg ))
		db.execute("INSERT INTO #PX#_support_chatmsg (client,stream,msg) VALUES (%s,%s,%s)",(client,'jabber',msg))

Config.init()
jid = xmpp.protocol.JID(Config.jabber_username)
c = xmpp.Client(jid.getDomain(),debug=[])
conn = c.connect(server=(Config.jabber_hostname, Config.jabber_port))
# authorizing 
try:
	auth = c.auth(jid.getNode(), Config.jabber_password, resource=jid.getResource())
	log("""Jabber-notify bot started""")
except:
	log('Cant authorize user ' + Config.jabber_username + '. Caused exception!!')

c.RegisterHandler('message',message)
c.RegisterHandler('presence',presence)
c.sendInitPresence(requestRoster=1)
log("""Starting daemon...""")
db = ThMysql(username=Config.db_username, password=Config.db_password, name=Config.db_name,prefix=Config.db_prefix)

while c.Process(1):
	time.sleep(0.1)
	msgs = db.fetchlines("""SELECT msg,client,msgid FROM #PX#_support_chatmsg WHERE type = 'out' AND stream = 'jabber'""")
	for msg in msgs:
		jid = msg[1].replace('_AT_','@')
		log("""Send message for %s""" % ( jid ))
		c.send(xmpp.protocol.Message(to = jid, body=msg[0], typ='chat'))
		db.execute("DELETE FROM #PX#_support_chatmsg WHERE msgid = %s", ( str(msg[2]) ) )
