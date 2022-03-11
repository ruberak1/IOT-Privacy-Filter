<?php 
//writes to device list and removes seleced IoT device
include 'deviceinclude/writedeviceremoval.php';
//reads devices.txt lines into column arrays to display to the user
include 'deviceinclude/readdevicelist.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../slidercontrol.css">
    <title>Remove Devices</title>
</head>
<body>
<div>
        <h1>Remove IoT Device</h1>
    </div>
    <div>
        <p style="textAlign: right;"><button onclick="window.location.href='device.php'">Exit Device Removal</button>
        </p>
        <table>
            <tr>
                <th>Hostname</th>
                <th>MAC</th>
                <th>Delete Device?</th>
            </tr>
            <?php
                print_r($findIoTEntry);
                //loop through array and output all iot device results
                foreach($findIoTEntry as $iotdevice) {
                    //break array values into seperate fields host, mac, and filter
                    $breakLine = explode(" ", $iotdevice);
                    echo "<tr>";
            ?>
                    <td><?php echo $breakLine[1]; ?></td>
                    <td><?php echo $breakLine[2]; ?></td>
                    <td>
                    <form action="deviceremoval.php" method="post" onsubmit="return confirm('Do you want to delete device with MAC address <?php echo $breakLine[2];?>');">
                        <input type='hidden' name='macEntry' value='<?php echo $breakLine[2];?>' />
                        <input type='hidden' name='hostEntry' value='<?php echo $breakLine[1];?>' />
                        <input type='hidden' name='filterEntry' value='<?php echo $breakLine[0];?>' />
                        <!--<input type='image' src='../../images/cross-circle.png' alt='add icon' name='submit' />-->
                        <input type="submit" name="submit" />
                    </form>
                    </td>
                </tr>
            <?php
                }
            ?>
        </table>
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