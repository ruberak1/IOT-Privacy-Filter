#!/bin/bash
#piCheckClinet.sh
#This script checks the last entry of the client pi device connecting to AWS server by analzying auth.log
#It will write to file pistatus.txt a "0" if pi client has not been seen in the last 60 seconds
#This informs the user that the device is offline and intervention is needed by the user

#Determine if pi is still online
#Get Timestamp of last successful connection attempt by the user
checkLog=$(sudo grep "webserver sshd\[[0-9]*]: Accepted publickey for testuser01 from [0-9]*.*ssh2" /var/log/auth.log | tail -1 | cut -d' ' -f1-3)
#If checklog is null device is offline
if [ -z "$checkLog" ]; then
	echo 0 | cat >| /home/testuser01/PISTATUS/pistatus.txt
else
	#perform differnce calculation on current time and timestamp of last connection
	#if outcome is over 10 seconds write zero to file
	echo $checkLog
	logTime=$(date -d "$checkLog" +"%s")
	currentTime=$(date +%s)
	timeDiff=$(( currentTime - $logTime ))
	echo $logTime
	echo $currentTime
	echo $timeDiff
	if [ $timeDiff -gt 60 ]; then
		echo 0 | cat >| /home/testuser01/PISTATUS/pistatus.txt
	else
		echo 1 | cat >| /home/testuser01/PISTATUS/pistatus.txt
	fi
fi
	
