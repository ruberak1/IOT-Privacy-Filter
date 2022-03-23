<?php 
//writes scanned host to devicelist if user click additon button
include 'scaninclude/writetodevice.php';
//stores and cleans scannned results to 2 arrays one hostnames the other MAC addresses
//also stores current devicelist entries in an array to compare against scanned items to prevent duplicate clients in device list
include 'scaninclude/readscanresults.php';
//displays status of users hardware filter rasberry pi device
include 'pistatinclude/pistatus.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/submitButton.css">
    <link rel="stylesheet" href="../../css/navBar.css">
    <link rel="stylesheet" href="../../css/titleLine.css">
    <link rel="stylesheet" href="../../css/table.css">
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="stylesheet" href="../../css/container.css">
    <title>Scan Network</title>
</head>
<body>
    <div class="topline">
        <?php echo $piClientStatus; ?>
    </div>
    <div class="container">
    <h1>&nbsp;-&nbsp;Scan for Devices&nbsp;-&nbsp;</h1>
        <table class="zui-table">
            <tr>
                <th>Hostname</th>
                <th>MAC</th>
                <th>Add&nbsp;Device?</th>
            </tr>
            <?php
                //remove clientpi from findHost array. will be last entry, reason: nmap doesnt supply MAC for device nmap is run on, because of this arrays are uneven
                $killKey = array_key_last($findHost);
                unset($findHost[$killKey]);
                //combine my mac and host arrays together
                $scanResults = array_combine($findHost, $findMAC);
                //format table line colors for readablity
                $color = 0;
                //loop through array and output all results
                foreach($scanResults as $host => $mac) {
                if ($color == 0) { echo "<tr style=\"background-color: #acdcee;\">"; $color = 1; } else{ echo "<tr style=\"background-color: #f0fbff;\">"; $color = 0; }
            ?>
                <td><?php echo $host; ?></td>
                <td><?php echo $mac; ?></td>
                <td>
                    <?php
                    //displays either device in devices list or lets user add a new device to the device list
                    if (in_array($mac, $currentDevices)) {
                        echo "<img src='../../images/checkbox.png' alt='existing device icon' />";
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
    <div style="text-align: center;">
        <p>
            <form action="scansplash.php" method="POST">
                <input class="button-7" type="submit" name="scanNetwork" value="Scan Network" />
            </form>        
        </p>
    </div>
    </div>
    <div class="navarea">
    <div class="navbar">
        <a href="scan.php"><img src="../../images/search.png" alt="search icon" /><br />Scan</a>
        <a href="device.php"><img src="../../images/tablet.png" alt="devices icon" /><br />My Devices</a>
        <a href="log.php"><img src="../../images/notebook.png" alt="log icon" /><br />Log</a>
        <a href=" https://log:out@privacyfence.tk/"><img src="../../images/sign-out.png" alt="signout icon" /><br />Sign Out</a>
    </div>
    </div>
</body>
</html>