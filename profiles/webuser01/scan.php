<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan Network</title>
</head>
<body>
    <?php
    //read contents of scanresult to output found devices
        //crate arrays to store MAC and hostnames
        $findHost = [];
        $findMAC = [];
        //loop through file and use regexp to match MACs with their hostnames in clean output results
		$file_lines = file('/var/www/html/profiles/webuser01/storage/SCAN/scanResults.txt');
        foreach ($file_lines as $line) {
            //patern1 is a regexp to match mac addresses
			$pattern1 = "#([0-9A-Fa-f]{2}[:-][0-9A-Fa-f]{2}[:-][0-9A-Fa-f]{2}[:-][0-9A-Fa-f]{2}[:-][0-9A-Fa-f]{2}[:-][0-9A-Fa-f]{2})#";
            //patter2 is a regexp to match hostnames
            $pattern2 = "#Nmap scan report for#";

            //split line on spaces 
            $breakLine = explode(" ", $line);
            //determine if MAC addess exist in current line if true, store index 2 into array MAC should be 3rd entry on the line
            if (preg_match($pattern1, $line)){
                $findMAC[] = $breakLine[2];
            }
            //determine if hostname exist in current line if true, store index 4 into array MAC should be 5th entry on the line if not hostname 5th entry will be IP
            if (preg_match($pattern2, $line)){
                $findHost[] = $breakLine[4];
            }
		}
	    ?>
    <div>
        <h1>Scan For Devices</h1>
    </div>
    <div>
        <table>
            <tr>
                <th>Hostname</th>
                <th>MAC</th>
                <th>Add Device ?</th>
            </tr>
            <?php
                //remove clientpi from findHost array. will be last entry, reason: nmap doesnt supply MAC for device nmap is run on, because of this arrays are uneven
                $killKey = array_key_last($findHost);
                unset($findHost[$killKey]);
                //combine my mac and host arrays together
                $scanResults = array_combine($findHost, $findMAC);
                //loop through array and output all results
                foreach($scanResults as $host => $mac) {
                echo "<tr>";
            ?>
                <td><?php echo $host; ?></td>
                <td><?php echo $mac; ?></td>
                <td>PLACEHOLDER</td>
                </tr>
            <?php
                }
            ?>
        </table>
    </div>
    <div>
        <p>
            SCANBUTTON
        </p>
    </div>
    <div>
        <ul>
            <li>Scan</li>
            <li>My Devices</li>
            <li>Log</li>
        </ul>
    </div>
</body>
</html>