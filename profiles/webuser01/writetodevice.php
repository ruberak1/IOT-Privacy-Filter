<?php
    //add device to devices.txt if user clicks add button
    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['addMac']))
    {
        writedevice();
    }
    function writedevice()
    {
        $deviceFile = "/var/www/html/profiles/webuser01/storage/DEVICES/devices.txt";
        $fileContents = file_get_contents($deviceFile);
        $fileContents .="0 ".$_POST['addMac']."\r\n";
        file_put_contents($deviceFile, $fileContents);     
    }
?>