<?php 
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
    <link rel="stylesheet" href="../../css/slidercontrol.css">
    <link rel="stylesheet" href="../../css/submitButton.css">
    <link rel="stylesheet" href="../../css/navBar.css">
    <link rel="stylesheet" href="../../css/titleLine.css">
    <link rel="stylesheet" href="../../css/table.css">
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="stylesheet" href="../../css/container.css">
    <title>My Devices</title>
</head>
<body>
    <div class="topline">
        <?php echo $piClientStatus; ?>
    </div>
    <div class="container">
    <h1>&nbsp;-&nbsp;My IoT Devices&nbsp;-&nbsp;</h1>
    <!--<p style="text-align: left;"><button onclick="window.location.href='deviceremoval.php'">Remove a Device</button>
    </p> -->
    <form action="devicesplash.php" method="POST">
        <table class="zui-table">
            <tr>
                <th>Hostname&nbsp;<a href="deviceremoval.php"><img src="../../images/pencil.png" alt="edit icon" /></a></th>
                <th>MAC</th>
                <th>Filtering?</th>
            </tr>
            <?php
                //counter to use for form fields to be used to write back to device.txt and updateRules.txt
                $deviceCounter = 1;
                //format table line colors for readablity
                $color = 0;
                //loop through array and output all iot device results
                foreach($findIoTEntry as $iotdevice) {
                    //break array values into seperate fields host, mac, and filter
                    $breakLine = explode(" ", $iotdevice);
                    if ($color == 0) { echo "<tr style=\"background-color: #acdcee;\">"; $color = 1; } else{ echo "<tr style=\"background-color: #f0fbff;\">"; $color = 0; }
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
        <div style="text-align: center;">
            <p>
                <input style="text-align: center;" class="button-7" type="submit" name="updateRules" value="Submit Filtering" />
            </p>
        </div>
    </form>       
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