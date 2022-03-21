<?php
    //clear log.txt if user clicks add clear log button
    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['clearLog']))
    {
        clearlog();
        writelog();
    }
    function clearlog()
    {
      
        //blank out log.txt
        $logFile = "/var/www/html/profiles/webuser01/storage/LOG/log.txt";
        file_put_contents($logFile, "");     
    }
    function writelog() 
    {
        //write user action to log
        $logFile = "/var/www/html/profiles/webuser01/storage/LOG/log.txt";
        $fileContents = file_get_contents($logFile);
        date_default_timezone_set('America/New_York');
        $logDate = date("M d H:i");
        $fileContents .=$logDate." Log File Cleared"."\r\n";
        file_put_contents($logFile, $fileContents); 
    }
?>