<?php 
//writes to device list and removes seleced IoT device
include 'deviceinclude/writedeviceremoval.php';
//reads devices.txt lines into column arrays to display to the user
include 'deviceinclude/readdevicelist.php';
//displays status of users hardware filter rasberry pi device
include 'pistatinclude/pistatus.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../slidercontrol.css">
    <link rel="stylesheet" href="../../css/submitButton.css">
    <link rel="stylesheet" href="../../css/navBar.css">
    <link rel="stylesheet" href="../../css/titleLine.css">
    <link rel="stylesheet" href="../../css/table.css">
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="stylesheet" href="../../css/container.css">
    <title>Remove Devices</title>
</head>
<body>
<div class="topline">
        <?php echo $piClientStatus; ?>
    </div>
    <div class="container">
    <h1>&nbsp;-&nbsp;Remove IoT Device&nbsp;-&nbsp;</h1>
        <h3>Please disable filtering on a device to remove it from your device list.</h3>
        <table class="zui-table">
            <tr>
                <th>Hostname</th>
                <th>MAC</th>
                <th>Delete Device?</th>
            </tr>
            <?php
                //format table line colors for readablity
                $color = 0;
                //loop through array and output all iot device results
                foreach($findIoTEntry as $iotdevice) {
                    //break array values into seperate fields host, mac, and filter
                    $breakLine = explode(" ", $iotdevice);
                    if ($color == 0) { echo "<tr style=\"background-color: #acdcee;\">"; $color = 1; } else{ echo "<tr style=\"background-color: #f0fbff;\">"; $color = 0; }
                    //if device is currently being filtered do not display it as an option for deleteion
                    if ($breakLine[0] == "0")
                    {
            ?>
                    <td><?php echo $breakLine[1]; ?></td>
                    <td><?php echo $breakLine[2]; ?></td>
                    <td>
                    <form action="deviceremoval.php" method="post" onsubmit="return confirm('Do you want to delete this device?');">
                        <input type='hidden' name='macEntry' value='<?php echo $breakLine[2];?>' />
                        <input type='hidden' name='hostEntry' value='<?php echo $breakLine[1];?>' />
                        <input type='hidden' name='filterEntry' value='<?php echo $breakLine[0];?>' />
                        <input type='image' src='../../images/cross-circle.png' alt='add icon' name='submit' />
                    </form>
                    </td>
                </tr>
            <?php
                }
            }
            ?>
        </table>
        <p><button class="button-7" onclick="window.location.href='device.php'">Exit Device Removal</button>
        </p>
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