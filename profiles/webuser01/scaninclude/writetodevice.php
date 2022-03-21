<?php
    //add device to devices.txt if user clicks add button
    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['addMac']))
    {
        writedevice();
        writelog();
    }
    function writedevice()
    {
        $deviceFile = "/var/www/html/profiles/webuser01/storage/DEVICES/devices.txt";
        $fileContents = file_get_contents($deviceFile);
        $fileContents .="0 ".$_POST['addHost']." ".$_POST['addMac']."\r\n";
        file_put_contents($deviceFile, $fileContents);     
    }
    function writelog() 
    {
        //write user action to log
        $logFile = "/var/www/html/profiles/webuser01/storage/LOG/log.txt";
        $fileContents = file_get_contents($logFile);
        date_default_timezone_set('America/New_York');
        $logDate = date("M d H:i");
        $fileContents .=$logDate." New Device Added"."\r\n";
        file_put_contents($logFile, $fileContents); 
    }
    
?>