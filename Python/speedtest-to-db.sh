#!/usr/bin/python
import os
import sys
import csv
import datetime
import time
import MySQLdb as mariadb

#run speedtest-cli
#print 'running test'

# Still missing;
# Enable logging and write to file
# Implement 'try' and integrate with logging
# Clean up. Script is messy.

speed = os.popen("/usr/bin/python /usr/bin/speedtest --simple").read()

#print 'done'

#split the 3 line result (ping,down and up)

lines = speed.split('\n')
ts = time.time()
now = time.strftime('%Y-%m-%d %H:%M:%S')

#if speedtest could not connect set the speeds to 0
if "Cannot" in speed:
        p = 0
        d = 0
        u = 0

#extract the values for ping, down and up values
else:
     p = lines[0][6:11]
     d = lines[1][10:16]
     u = lines[2][8:12]

#print now,p, d, u

# Connect to database
connection = mariadb.connect(host='db.grauelmose.home', user='root', password='#Nmwlelqa01#', database='grauelmose')
cursor = connection.cursor()
#print 'connection to db established'

#build SQL statement
sql = "INSERT INTO internet (datetime, ping, download, upload) VALUES (%s,%s,%s,%s)"
val = (now, p, d, u)
cursor.execute(sql,val)
connection.commit()

#print 'Row inserted'
#close connection to database
cursor.close()
connection.close()