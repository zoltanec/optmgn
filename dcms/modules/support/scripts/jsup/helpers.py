# -*- coding: utf-8 -*-
import os, threading, thread, time,sys

def check_single_running():
	pid_file = os.path.dirname(os.path.abspath(__file__)) + "/chat.pid"
	log("""Checking PID file %s""" % ( pid_file ))

	if os.path.exists(pid_file):
		pf = open(pid_file,"r")
		pid = int(pf.readline())
		pf.close()

		#log("""Killing old chat PID: %d""" % ( pid ))
		try:
			os.kill( pid, signal.SIGKILL )
		except:
			pass
			log("""No process killed""")

		# save current pid
	pf = open(pid_file,"w")
	pf.write(str(os.getpid()))
	pf.close()


def log(msg, exc = False):
	print(time.strftime('%Y/%m/%d %H:%M:%S',time.localtime()) + '  ' 
	+ '['+threading.currentThread().getName()+ ' / ' 
	+ str(threading.activeCount()) + '] ' 
	+ msg) 
	if exc:
		print(sys.exc_info())
