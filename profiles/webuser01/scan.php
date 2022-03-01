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
        // $findHost = array();
        $findMAC = [];
        //loop through file and use regexp to match MACs with their hostnames in clean output results
		$file_lines = file('/var/www/html/profiles/webuser01/storage/SCAN/scanResults.txt');
        foreach ($file_lines as $line) {
            //patern1 is a regexp to match mac addresses
			$pattern1 = "#([0-9A-Fa-f]{2}[:-][0-9A-Fa-f]{2}[:-][0-9A-Fa-f]{2}[:-][0-9A-Fa-f]{2}[:-][0-9A-Fa-f]{2}[:-][0-9A-Fa-f]{2})#";
            //patter2 is a regexp to match hostnames
         //   $pattern2 = "/[^Nmap scan report for]([^\s]+)/";

            //split line on spaces 
            $breakLine = explode(" ", $line);
            //determine if MAC addess exist in current line if true, store index 2 into array MAC should be 3rd entry on the line
            if (preg_match($pattern1, $line)){
                $findMAC[] = $breakLine[2];
                //echo "<br/>";
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
                //combine my mac and host arrays to loop through results
                //$scanResults = array_combine($findHost, $findMAC);

                //foreach($scanResults as $host => $mac) {
                    foreach($findMAC as $mac) {
                echo "<tr>";
            ?>
                <td><?php //echo $host; ?></td>
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