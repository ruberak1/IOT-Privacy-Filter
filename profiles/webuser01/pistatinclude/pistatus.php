<?php
    //read picheck.txt if file contains 1 pi client should be on, if it contains 0 pi client is off
        //create array to store pi status
        $power = [];
        //loop through file to find value
		$file_lines = file('/var/www/html/profiles/webuser01/storage/PISTATUS/pistatus.txt');
        foreach ($file_lines as $line) {
            //store line in array
            $power[] = rtrim($line);
		}
    //store output icon to display on app ui page 
    if ($power[0] == "1"){
        $piClientStatus = "<img src='..\..\..\images\power.png' alt='pipoweredon' />";
    }else{
        $piClientStatus = "<img src='..\..\..\images\poweroff.png' alt='pipoweredoff' />";
    }
 ?>