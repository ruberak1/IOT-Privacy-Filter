<?php
    //sets the value in ruleCheck.txt to 1, set devices with toggle settings in devices.txt, set rules in ruleUpdates.txt 
    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['updateRules']))
    {
        writerulecheck();
        writedevices();
        writeruleupdates();
        writelog();
    }
    function writerulecheck()
    {
        $ruleFile = "/var/www/html/profiles/webuser01/storage/RULES/ruleCheck.txt";
        file_put_contents($ruleFile, "1");     
    }
    function writedevices()
    {
        $deviceFile = "/var/www/html/profiles/webuser01/storage/DEVICES/devices.txt";
        //counter to loop through devices from devices.php form
        $deviceNum = 1;
        while($deviceNum <= $_POST['numEntries']) {
            //concat form objects with line index number
            $filterLineItem = "filterEntry".$deviceNum;
            $hostLineItem = "hostEntry".$deviceNum;
            $macLineItem = "macEntry".$deviceNum;
            //if filter toggle is off no form data is posted for filterEntry checkbox, this means value should be zero
            $filterLineItem = $_POST[$filterLineItem] ?? '0';
            //append entry to devicelist variable buffer, 
            $deviceContents .= $filterLineItem." ".$_POST[$hostLineItem]." ".$_POST[$macLineItem]."\r\n";
            $deviceNum++;
        }
        //write entries to devices.txt
        file_put_contents($deviceFile, $deviceContents);     
    }
    function writeruleupdates()
    {
        $deviceFile = "/var/www/html/profiles/webuser01/storage/RULES/ruleUpdates.txt";
        //counter to loop through devices from devices.php form
        $deviceNum = 1;
        while($deviceNum <= $_POST['numEntries']) {
            //concat form objects with line index number
            $filterLineItem = "filterEntry".$deviceNum;
            $macLineItem = "macEntry".$deviceNum;
            //if filter toggle is off no form data is posted for filterEntry checkbox, this means value should be zero
            $filterLineItem = $_POST[$filterLineItem] ?? '0';
            //append entry to devicelist variable buffer, 
            $deviceContents .= $filterLineItem." ".$_POST[$macLineItem]."\r\n";
            $deviceNum++;
        }
        //write entries to devices.txt
        file_put_contents($deviceFile, $deviceContents);     
    }
    function writelog() 
    {
        //write user action to log
        $logFile = "/var/www/html/profiles/webuser01/storage/LOG/log.txt";
        $fileContents = file_get_contents($logFile);
        date_default_timezone_set('America/New_York');
        $logDate = date("M d H:i");
        $fileContents .=$logDate." Filtering Change Requested"."\r\n";
        file_put_contents($logFile, $fileContents); 
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="10; URL=device.php" />
    <title>Applying Rules...</title>
</head>
<body>
    <img src="..\..\images\loading.gif" alt="loading image" />
</body>
</html>