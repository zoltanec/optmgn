import MySQLdb, threading
from helpers import *

class ThMysql:
	lock = False
	db = False
	prefix = 'nn'
	username = ''
	password = ''
	name = ''

	def __init__(self, prefix = 'nn', username = '', password = '', name = ''):
		self.username = username
		self.password = password
		self.name     = name
		self.lock = threading.Lock()
		self.db =  MySQLdb.connect( user=self.username, passwd=self.password, db=self.name)
		self.prefix = prefix
	
	def ping(self):
		log("""Checking database connection...""")
		res = self.fetchline("SELECT NOW()")

		self.lock.acquire()
		if res == None:
			self.reconnect()
		self.lock.release()
	
	def reconnect(self):
		log("""Database reconnect""")
		self.db = False
		self.db = MySQLdb.connect( user = self.username, passwd = self.password, db = self.name)

	
	def execute(self, query,data=[]):
		self.lock.acquire()
		try:
			cur = self.db.cursor()
			cur.execute(query.replace('#PX#', self.prefix) , data)
			cur.close()
			self.db.commit()
			self.lock.release()
		except:
			self.lock.release()
			log("""Strange happened when trying to exec: %s""" % ( query ), exc = True)
	
	def fetchline(self,query, data = []):
		self.lock.acquire()
		try:	
			cur = self.db.cursor()
			cur.execute(query.replace('#PX#', self.prefix), data)
			data = cur.fetchone()
			self.lock.release()
			return data
		except:
			self.lock.release()
			log("""Unable to execute fetchline for %s""" % ( query ), exc = True)
			return None

	def fetchlines(self,query, data = []):
		self.lock.acquire()
		try:
			cur = self.db.cursor()
			cur.execute(query.replace('#PX#', self.prefix), data)
			result = cur.fetchall()
			self.lock.release()
			return result
		except:
			self.lock.release()
			log("""Unable to execute query %s""" % ( query), exc = True)
