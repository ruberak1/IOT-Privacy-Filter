<?php
    //read contents of scanresult to output found devices
        //create arrays to store MAC and hostnames
        $findHost = [];
        $findMAC = [];
        //loop through file and use regexp to match MACs with their hostnames in clean output results
		$file_lines = file('/var/www/html/profiles/webuser01/storage/SCAN/scanResults.txt');
        foreach ($file_lines as $line) {
            //patern1 is a regexp to match mac addresses
			$pattern1 = "#([0-9A-Fa-f]{2}[:-][0-9A-Fa-f]{2}[:-][0-9A-Fa-f]{2}[:-][0-9A-Fa-f]{2}[:-][0-9A-Fa-f]{2}[:-][0-9A-Fa-f]{2})#";
            //patter2 is a regexp to match hostnames
            $pattern2 = "#Nmap scan report for#";

            //split line on spaces 
            $breakLine = explode(" ", $line);
            //determine if MAC addess exist in current line if true, store index 2 into array MAC should be 3rd entry on the line
            if (preg_match($pattern1, $line)){
                $findMAC[] = $breakLine[2];
            }
            //determine if hostname exist in current line if true, store index 4 into array MAC should be 5th entry on the line if not hostname 5th entry will be IP
            if (preg_match($pattern2, $line)){
                $findHost[] = $breakLine[4];
            }
		}
        //check currnet stored IoT Devices in users devicelist
        $currentDevices = [];
        $file_lines2 = file('/var/www/html/profiles/webuser01/storage/DEVICES/devices.txt');
        foreach ($file_lines2 as $line) {
            $breakLine2 = explode(" ", $line);
            $currentDevices[] = rtrim($breakLine2[1]);
        }
?>