#!/bin/bash
#piCheckClinet.sh
#This script checks the last entry of the client pi device connecting to AWS server by analzying auth.log
#It will write to file pistatus.txt a "0" if pi client has not been seen in the last 60 seconds
#This informs the user that the device is offline and intervention is needed by the user

#Determine if pi is still online
#Get Timestamp of last successful connection attempt by the user
checkLog=$(sudo grep "webserver sshd\[[0-9]*]: Accepted publickey for testuser01 from [0-9]*.*ssh2" /var/log/auth.log | tail -1 | cut -d' ' -f1-3)
#store value of pistatus.txt, used to determine if log needs to be updated based on condition
logStatus=$(cat /home/testuser01/PISTATUS/pistatus.txt)
timeStamp=$(TZ='America/New_York' date +"%b %d %H:%M")
#If checklog is null device is offline
if [ -z "$checkLog" ]; then
	#If last stauts was online update log that pi is offline
	if [ $logStatus == "1" ]; then
		echo "$timeStamp Client Pi is Offline" | cat >> /home/testuser01/LOG/log.txt
	fi
	echo 0 | cat >| /home/testuser01/PISTATUS/pistatus.txt
else
	#perform differnce calculation on current time and timestamp of last connection
	#if outcome is over 60 seconds write zero to file
	logTime=$(date -d "$checkLog" +"%s")
	currentTime=$(date +%s)
	timeDiff=$(( currentTime - $logTime ))
	if [ $timeDiff -gt 60 ]; then
		#if last status was online update log that pi is offline
		if [ $logStatus == "1" ]; then
			echo "$timeStamp Client Pi is Offline" | cat >> /home/testuser01/LOG/log.txt
		fi
		echo 0 | cat >| /home/testuser01/PISTATUS/pistatus.txt
	else
		#if last status was offline update log that pi is online
		if [ $logStatus == "0" ]; then
			echo "$timeStamp Client Pi is Online" | cat >> /home/testuser01/LOG/log.txt
		fi
		echo 1 | cat >| /home/testuser01/PISTATUS/pistatus.txt
	fi
fi
	
