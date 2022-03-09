<?php
    //sets the value in ruleCheck.txt to 1, set devices with toggle settings in devices.txt, set rules in ruleUpdates.txt 
    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['updateRules']))
    {
        writerulecheck();
        writedevices();
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
        $deviceContents = "";
        while($deviceNum <= $_POST['numEntries']) {
            //concat form objects with line index number
            $filterLineItem = "filterEntry".$deviceNum;
            $hostLineItem = "hostEntry".$deviceNum;
            $macLineItem = "macEntry".$deviceNum;
            $deviceContents .= $_POST[$filterLineItem]." ".$_POST[$hostLineItem]." ".$_POST[$macLineItem]."\r\n";
            $deviceNum++;
        }
        file_put_contents($deviceFile, $deviceContents);     
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