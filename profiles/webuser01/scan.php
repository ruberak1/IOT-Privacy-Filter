<?php 
//writes scanned host to devicelist if user click additon button
include 'scaninclude/writetodevice.php';
?>
<?php 
//stores and cleans scannned results to 2 arrays one hostnames the other MAC addresses
//also stores current devicelist entries in an array to compare against scanned items to prevent duplicate clients in device list
include 'scaninclude/readscanresults.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan Network</title>
</head>
<body>
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
                <td>
                    <?php
                    //displays either device in devices list or lets user add a new device to the device list
                    if (in_array($mac, $currentDevices)) {
                        echo "<!--<img src='../../images/' alt='list icon' />-->Already in Devices";
                    } else {
                        echo "<form action='scan.php' method='post'>
                        <input type='hidden' name='addMac' value='". $mac ."' />
                        <input type='hidden' name='addHost' value='". $host ."' />
                        <input type='image' src='../../images/add.png' alt='add icon' name='submit' />
                        </form>";
                    }
                    ?>
                </td>
                </tr>
            <?php
                }
            ?>
        </table>
    </div>
    <div>
        <p>
            <form action="scansplash.php" method="POST">
                <input type="submit" name="scanNetwork" value="Scan Network" />
            </form>        
        </p>
    </div>
    <div>
        <ul>
            <li><a href="scan.php">Scan</a></li>
            <li><a href="device.php">My Devices<a></li>
            <li>Log</li>
        </ul>
    </div>
</body>
</html>