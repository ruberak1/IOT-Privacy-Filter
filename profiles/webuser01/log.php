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
    <title>User Log</title>
</head>
<body>
<div>
    <?php echo $piClientStatus; ?><h1>User Log</h1>
</div>
<div>
    <table>
        <?php
        //loop through array and output all log entries
        foreach($logEntry as $logItem) {
            echo "<tr>";
        ?>
        <td><?php echo $logItem;?></td>
        </tr>
    <?php
        }
    ?>
    </table>
</div>
<div>
    <p>
        <form action="log.php" method="post">
        <input type="submit" name="clearLog" value="Clear Log" />
        </form>        
    </p>
    </div>
<div>
    <ul>
        <li><a href="scan.php">Scan</a></li>
         <li><a href="device.php">My Devices<a></li>
         <li><a href="log.php">Log<a></li>
    </ul>
</div>
    
</body>
</html>