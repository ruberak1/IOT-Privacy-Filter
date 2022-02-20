#!/bin/bash

#Capstone Project IOT Filter
#Client Pi Script
#This Script checks to see if rules have been updated by UI App
#If rules have been updated, this script will apply new rules
#to iptables on the clientpi device

#Connect to AWS and get ruleCheck.txt to determine if filtering is to take place
sftp testuser01@ec2-3-86-210-241.compute-1.amazonaws.com:RULES/ruleCheck.txt ../TEMP/
#Store contents of ruleCheck.txt in var for iptables updates?
ruleUpdateFlag=$(cat ../TEMP/ruleCheck.txt)
#Make changes to iptables firewall rules if ruleUpdateFlag is 1 or exit script if ruleUpdateflag is 0
if [ $ruleUpdateFlag -eq '1' ]; then
	#Connect to AWS and get the latest copy of ruleUpdates.txt for local client pi iptables changes 
	sftp testuser01@ec2-3-86-210-241.compute-1.amazonaws.com:RULES/ruleUpdates.txt ../TEMP/ 
	#read ruleUpdates.txt and loop through each line
	lines=$(cat ../TEMP/ruleUpdates.txt)
	for line in $lines
	do
		#split line into two parts rule toggle and mac address
		activeRule=${line:0:1}
		macAddr=${line:2}
		
		#check activeRule value, 0 rule is remove, 1 rule is added
		if [ $activeRule -eq '1' ]; then
			sudo iptables -A FORWARD -m mac --mac-source $macAddr -i wlan0 -j DROP
		elif [ $activeRule -eq '0' ]; then
			sudo iptables -D FORWARD -m mac --mac-source $macAddr -i wlan0 -j DROP
		else
			echo "Fatal Error"
		fi
	done

	#Update iptables config file with new rules, this is incase power is lost to clientpi
	sudo netfilter-persistent save > /etc/iptables/rules.v4
	#overwrite ruleUpdates.txt to blank file
	ssh testuser01@ec2-3-86-210-241.compute-1.amazonaws.com 'cat /dev/null >| RULES/ruleUpdates.txt'
	#reset ruleUpdateFlag in AWS ruleCheck.txt to zero
	echo 0 | ssh testuser01@ec2-3-86-210-241.compute-1.amazonaws.com 'cat >| RULES/ruleCheck.txt' 
fi
