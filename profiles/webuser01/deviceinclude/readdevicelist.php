<?php
    //read contents of devices to output users current device list
        //create arrays to store MAC and hostnames
        $findIoTEntry = [];
        //loop through file and use regexp to match MACs with their hostnames in clean output results
		$file_lines = file('/var/www/html/profiles/webuser01/storage/DEVICES/devices.txt');
        foreach ($file_lines as $line) {
            //store line in array, also strip newline character from end of line
            $findIoTEntry[] = rtrim($line, " \n");
		}
?>