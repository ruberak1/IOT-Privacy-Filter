<?php
    //read contents of log file to output user history
        //create arrays to store log entries
        $logEntry = [];
        //loop through file and use regexp to match MACs with their hostnames in clean output results
		$file_lines = file('/var/www/html/profiles/webuser01/storage/LOG/log.txt');
        foreach ($file_lines as $line) {
            //store line in array, also strip newline character from end of line
            $logEntry[] = rtrim($line, " \n");
		}
?>