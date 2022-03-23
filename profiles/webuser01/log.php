<?php 
//clear log.txt when user clicks the clear log button
include 'loginclude/wipelog.php';
//reads log.txt to store log entires to array to output history to user
include 'loginclude/readlog.php';
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
    <title>User Log</title>
</head>
<body>
<div class="topline">
        <?php echo $piClientStatus; ?>
</div>
<div class="container">
    <h1>&nbsp;-&nbsp;User Log&nbsp;-&nbsp;</h1>
    <table class="zui-table">
        <tr>
            <th>&nbsp;Time&nbsp;of&nbsp;Entry</th>
            <th>Event</th>
        </tr>
        <?php
        //format table line colors for readablity
        $color = 0;
        //loop through array and output all log entries
        foreach($logEntry as $logItem) {
            if ($color == 0) { echo "<tr style=\"background-color: #acdcee;\">"; $color = 1; } else{ echo "<tr style=\"background-color: #f0fbff;\">"; $color = 0; }
            //seperate time stamps and event
            $timeStamp = substr($logItem, 0, 12);
            //find the length of entry to grab just the event
            $stringEnd = strlen($logItem);
            $event = substr($logItem, 13, $stringEnd);
        ?>
        <td><?php echo $timeStamp;?></td>
        <td><?php echo $event;?></td>
        </tr>
    <?php
        }
    ?>
    </table>
<div style="text-align: center;">
    <p>
        <form action="log.php" method="post">
        <input class="button-7" type="submit" name="clearLog" value="Clear Log" />
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