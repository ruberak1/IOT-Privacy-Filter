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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="10; URL=scan.php" />
    <title>Scaning...</title>
</head>
<body>
    <img src="..\..\images\loading.gif" alt="loading image" />
</body>
</html>