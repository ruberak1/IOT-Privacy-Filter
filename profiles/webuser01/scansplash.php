<?php
    //sets the value in scanCheck.txt to 1 so client know to perfrom networks scan
    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['scanNetwork']))
    {
        writescancheck();
        writelog();
    }
    function writescancheck()
    {
        $scanFile = "/var/www/html/profiles/webuser01/storage/SCAN/scanCheck.txt";
        file_put_contents($scanFile, "1");     
    }
    function writelog() 
    {
        //write user action to log
        $logFile = "/var/www/html/profiles/webuser01/storage/LOG/log.txt";
        $fileContents = file_get_contents($logFile);
        date_default_timezone_set('America/New_York');
        $logDate = date("M d H:i");
        $fileContents .=$logDate." Network Scan Requested"."\r\n";
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
    <link rel="stylesheet" href="../../css/navBar.css">
    <link rel="stylesheet" href="../../css/titleLine.css">
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="stylesheet" href="../../css/container.css">
    <meta http-equiv="refresh" content="10; URL=scan.php" />
    <title>Scaning...</title>
</head>
<body>
<div class="topline">
        <?php echo $piClientStatus; ?>
    </div>
    <div class="container">
    <h3>Scanning Network in Progress...</h3>
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