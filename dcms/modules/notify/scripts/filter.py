#!/usr/bin/python
import re,sys,os
def error(msg):
	return True
	print msg
try:
	numbers = sys.argv[1]
except:
	print "Usage: filter.py <FILENAME_TO_PARSE>"

if not os.path.exists(numbers):
	print """File %s doesn't exists""" % ( numbers )

x = open(numbers)
data = x.readlines()
parsed = []
for line in data:
	phones = re.sub(r"(\s+)"," ", line.rstrip().lstrip()).split(' ')

	for phone in phones:
		if len(phone) < 10:
			continue;
		phone = phone.rstrip()

		if re.match('^3519', phone) or re.match('^83519', phone) or re.match('^73519', phone):
			error("SKIP " + phone)
			continue
		if phone[0] == '9':
			phone = '8' + phone

		if len(phone) > 11:
			error("SKIP BIG: " + phone)
			continue
		if not phone.isdigit():
			error("NON-NUMBER: " + phone)
			continue

		if phone in parsed:
			error("IN DB: " + phone)
			continue

		if len(phone) != 11:
			error("WRONG SIZE: " + phone)
			continue

		if phone[0] == '8':
			print '7' + phone[1:]

#		print phone
#		parsed.append(phone)
#print new
