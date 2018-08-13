#!/usr/bin/python
import MySQLdb,os
db = MySQLdb.connection(user='mmg', passwd='metallurg', db='mmg')
db.query("""SELECT convert_id, input, output FROM mmg_media_files_convert""")
result = db.store_result()
for file in result.fetch_row(1000):
	print("""Converting from %s to %s""" % (file[1],file[2]))
	print("""ffmpeg -i %s -f flv -y -ar 44100 %s""" % (file[1], file[2]))
	os.system("""ffmpeg -i '%s' -bufsize 128000000 -b 700000 -f flv -y -ar 44100 '%s'""" % (file[1], file[2]))
#	os.system("""mencoder %s -ofps 25 -o %s -of lavf -oac mp3lame -lameopts abr:br=64 -srate 22050 -ovc lavc -lavcopts vcodec=flv:keyint=50:vbitrate=300:mbd=2:mv0:trell:v4mv:cbp:last_pred=3 -vf scale=320:240""" % (file[1], file[2]))
	print("""Converted %s""" % (file[1]))
	#db.query("""DELETE FROM mmg_media_files_convert WHERE convert_id = %s""" % (file[0]))
	#os.unlink(file[1])

