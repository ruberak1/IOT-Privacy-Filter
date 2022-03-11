<?php
    //add device to devices.txt if user clicks add button
    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['submit']))
    {
        writedeviceremove();
    }
    function writedeviceremove()
    {
        $findIoTEntry = [];
        //loop through file and store device entries in array
		$file_lines = file('/var/www/html/profiles/webuser01/storage/DEVICES/devices.txt');
        foreach ($file_lines as $line) {
            //store line in array
            $findIoTEntry[] = $line;
		}
        //search arrary for key of entry we want to delete
        $selectedDevice = $_POST['filterEntry']." ".$_POST['hostEntry']." ".$_POST['macEntry'];
        $deleteKey = array_search($selectedDevice, $findIoTEntry);
        //delete entry
        unset($findIoTEntry[$deleteKey]);
        //loop through array and write device entries to variable buffer
        foreach ($findIoTEntry as $iotdevice) {
            $breakLine = explode(" ", $iotdevice);
            $fileContents .= $breakLine[0]." ".$breakLine[1]." ".$breakLine[2];
        }
        //write devices back to devices.txt
        $deviceFile = "/var/www/html/profiles/webuser01/storage/DEVICES/devices.txt";
        file_put_contents($deviceFile, $fileContents);     
    }
?>