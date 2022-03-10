<?php 
//reads devices.txt lines into column arrays to display to the user
include 'deviceinclude/readdevicelist.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../slidercontrol.css">
    <title>My Devices</title>
</head>
<body>
<div>
        <h1>My IoT Devices</h1>
    </div>
    <div>
    <form action="devicesplash.php" method="POST">
        <table>
            <tr>
                <th>Hostname</th>
                <th>MAC</th>
                <th>Filtering?</th>
            </tr>
            <?php
                //counter to use for form fields to be used to write back to device.txt and updateRules.txt
                $deviceCounter = 1;
                //loop through array and output all iot device results
                foreach($findIoTEntry as $iotdevice) {
                    //break array values into seperate fields host, mac, and filter
                    $breakLine = explode(" ", $iotdevice);
                    echo "<tr>";
            ?>
                <td><?php echo $breakLine[1]."<input type='hidden' name='hostEntry".$deviceCounter."' value='".$breakLine[1]."' />"; ?></td>
                <td><?php echo rtrim($breakLine[2])."<input type='hidden' name='macEntry".$deviceCounter."' value='".rtrim($breakLine[2])."' />"; ?></td>
                <td>
                <?php 
                if ($breakLine[0] == "0") {
                    echo 
                    "<label class='switch'>
                    <input type='checkbox' name='filterEntry".$deviceCounter."' value='1'>
                    <span class='slider round'></span>
                    </label>";
                } else {
                    echo 
                    "<label class='switch'>
                    <input type='checkbox' name='filterEntry".$deviceCounter."' value='1' checked>
                    <span class='slider round'></span>
                     </label>";
                }
                ?>
                </td>
                </tr>
            <?php
                $deviceCounter++;
                }
                //subtract one from coutner on last loop through
                $deviceCounter = --$deviceCounter;
                //final counter total for writedevices function in devicessplash.php
                echo "<input type='hidden' name='numEntries' value='".$deviceCounter."' />";
            ?>
        </table>
    </div>
    <div>
        <p>
            
                <input type="submit" name="updateRules" value="Submit Filtering" />
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