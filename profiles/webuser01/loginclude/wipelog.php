<?php
    //clear log.txt if user clicks add clear log button
    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['clearLog']))
    {
        clearlog();
    }
    function clearlog()
    {
      
        //blank out log.txt
        $logFile = "/var/www/html/profiles/webuser01/storage/LOG/log.txt";
        file_put_contents($logFile, "");     
    }
?>