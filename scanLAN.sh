#!/bin/bash

#Capstone Project IOT Filter
#Client Pi Script
#This Script checks to see if user requested LAN scan from APP interface

#Connect to AWS and get scancheck for scan execute?
sftp testuser01@ec2-3-86-210-241.compute-1.amazonaws.com:SCAN/scanCheck.txt /home/pi/TEMP/
#Store contents of scancheck.txt in var for scan execute?
scanFlag=$(cat /home/pi/TEMP/scanCheck.txt)
#get date format for log write
timeStamp=$(TZ='America/New_York' date +"%b %d %H:%M")
#Run network scan nmap if scanFlag is 1 or exit script if scanflag is 0
if [ $scanFlag -eq '1' ]; then
	#scan network 
	sudo nmap -sP 192.168.50.1-254 > /home/pi/RESULTS/scanResults.txt 
	#copy results to AWS
	scp /home/pi/RESULTS/scanResults.txt testuser01@ec2-3-86-210-241.compute-1.amazonaws.com:SCAN/
	#reset scanFlag in AWS scancheck.txt to zero
	echo 0 | ssh testuser01@ec2-3-86-210-241.compute-1.amazonaws.com 'cat >| SCAN/scanCheck.txt'
       #write to log that scan has completed
	echo "$timeStamp Scan has Completed" | ssh testuser01@ec2-3-86-210-241.compute-1.amazonaws.com 'cat >> /home/testuser01/LOG/log.txt'
	       
fi
