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
//displays status of users hardware filter rasberry pi device
include 'pistatinclude/pistatus.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="10; URL=device.php" />
    <link rel="stylesheet" href="../../css/navBar.css">
    <link rel="stylesheet" href="../../css/titleLine.css">
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="stylesheet" href="../../css/container.css">
    <title>Applying Rules...</title>
</head>
<body>
<div class="topline">
        <?php echo $piClientStatus; ?>
    </div>
    <div class="container">
    <h3>Applying Filter Changes...</h3>
    <img src="..\..\images\loading.gif" alt="loading image" />
</div>
<div class="navarea">
    <div class="navbar">
        <a href="scan.php"><img src="../../images/search.png" alt="search icon" /><br />Scan</a>
        <a href="device.php"><img src="../../images/tablet.png" alt="devices icon" /><br />My Devices</a>
        <a href="log.php"><img src="../../images/notebook.png" alt="log icon" /><br />Log</a>
        <a href=" https://logout@privacyfence.tk/"><img src="../../images/sign-out.png" alt="signout icon" /><br />Sign Out</a>
    </div>
</div>
</body>
</html>