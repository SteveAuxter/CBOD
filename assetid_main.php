<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="mystyle.css">
        <title>Asset ID: Device Info</title>
        <style>
            #rowInfoHeader {
                text-align: right;
                font-weight: bold;
            }
            #rowInfoData {
                text-align: left;
            }
        </style>
    </head>
    <body>
        <?php include "assetid_header.php" ?>
        <?php include "variables.php" ?>
        <?php //include "assetid_submenu.php" ?>
        
        <ul class="menu">
            <li><a class="active" href="assetid_main.php">Device Info</a></li>
            <li><a href="assetid_wipeusers.php">Clear Profiles</a></li>
            <li><a href="assetid_powerwash.php">Remote Powerwash</a></li>
            <li><a href="assetid_disable.php">Disable/Enable</a></li>
            <li><a href="assetid_help.php">Help</a></li>
        </ul>
        <hr>
        
        <form name="search" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET">
        Search: <input type="text" name="searchterm">
        <input type="submit" value="Search for single Asset ID">
        </form>
        <br><br>

        <?php
        global $counter;
        global $GAMpath;

        //Does the database exist?
        $check = new mysqli($DBserver, $DBuser, $DBpass);
        if ($check->select_db($DBname) === TRUE) {

            //Create new connection & check connection
            $conn = new mysqli($DBserver, $DBuser, $DBpass, $DBname);
            if ($conn->connect_error) {
                die("Connection Failed: " . $conn->connect_error);
            }

            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                if (isset($_GET['searchterm']) && !empty($_GET['searchterm'])) {
                    $starttime = microtime(true);
                    $mysearch = $_GET["searchterm"];

                    $sql = "SELECT * FROM importdata WHERE annotatedAssetId='{$mysearch}'";
                    
                    $result = $conn->query($sql);
                    $counter = 0;
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            ?>
                            <!-- Exit PHP and draw HTML table -->
                            <center>
                            <table class="counting">
                                <tr>
                                    <th><b>Asset ID</b></th>
                                    <th><b>Serial #</b></th>
                                    <th><b>Notes</b></th>
                                    <th><b>Model</b></th>
                                    <th><b>Status</b></th>
                                    <th><b>Location</b></th>
                                    <th><b>User</b></th>
                                    <th><b>OS Version</b></th>
                                    <!-- <th><b>Org Unit Path</b></th> -->
                                    <!-- <th><b>WiFi MAC</b></th> -->
                                    <!-- <th><b>Wired MAC</b></th> -->
                                    <th><b>Device ID</b></th>
                                </tr>
                                <!-- Exit PHP and populate HTML table -->
                                <tr>
                                    <td><?php echo $row["annotatedAssetId"]; ?></td>
                                    <td><?php echo $row["serialNumber"]; ?></td>
                                    <td><?php echo (str_replace('\\\n', '<br>', $row["notes"])); ?></td>
                                    <td><?php echo $row["model"]; ?></td>
                                    <td><?php echo $row["status"]; ?></td>
                                    <td><?php echo $row["annotatedLocation"]; ?></td>
                                    <td><?php echo $row["annotatedUser"]; ?></td>
                                    <td><?php echo $row["osVersion"]; ?></td>
                                    <!-- <td><?php //echo $row["orgUnitPath"]; ?></td> -->
                                    <!-- <td><?php //echo $row["macAddress"]; ?></td> -->
                                    <!-- <td><?php //echo $row["ethernetMacAddress"]; ?></td> -->
                                    <td><a href="https://admin.google.com/ac/chrome/devices/<?php echo $row["deviceId"]; ?>" target="_blank"><?php echo $row["deviceId"]; ?></a></td>
                                </tr>
                            </table>
                            </center>
                            <br>
                        <?php
                        $counter++;
                        }
                    }
                    echo "Found " . $counter . " result.<br>";
                    $conn->close();
                    $endtime = microtime(true);
                    $duration = $endtime - $starttime;
                    echo "<br>";
                    echo "Process took " . number_format((float)$duration, 4) . " seconds.<hr>";
                } else {
                    echo "<br>";
                }
            }    
            
            if ($counter == 1){
                if ($_SERVER["REQUEST_METHOD"] == "GET") {
                    if (isset($_GET['searchterm']) && !empty($_GET['searchterm'])){
                        
                        $command1 = sprintf("$GAMpath print cros fields annotatedAssetId,annotatedLocation,annotatedUser,bootMode,firmwareVersion,lastEnrollmentTime,lastSync,macAddress,model,notes,orgUnitPath,osVersion,platformVersion,serialNumber,status query asset_id:%s", $mysearch);
                        exec($command1,$infoBasic);

                        $command2 = sprintf("$GAMpath print crosactivity query asset_id:%s users", $mysearch);
                        exec($command2,$crosActivity);

                        echo "<h3>Asking Google about device with Asset ID <font color='#008CBA'>$mysearch</font>. Here's what I found:</h3>";
                        $infoHeader = explode(",", $infoBasic[0]);
                        $infoData = explode(",", $infoBasic[1]);
                        $arrayLength = count($infoHeader);
                        $infoArray = array();
                        for ($x = 0; $x < $arrayLength; $x++) {
                            $infoArray[$infoHeader[$x]] = $infoData[$x];
                        }
                        $syncDate = $infoArray['lastSync'];
                        $syncDateAdj = date('l, F jS, Y \a\t g:i:s a (T)', strtotime($syncDate));
                        $enrollDate = $infoArray['lastEnrollmentTime'];
                        $enrollDateAdj = date('l, F jS, Y \a\t g:i:s a (T)', strtotime($enrollDate));
                        ?>
                        <!-- Exit PHP and draw HTML table -->
                        <table>
                            <tr><td id="rowInfoHeader"><?php echo "Asset ID:"; ?></td><td id="rowInfoData"><?php echo $infoArray['annotatedAssetId']; ?></td></tr>
                            <tr><td id="rowInfoHeader"><?php echo "Serial #:"; ?></td><td id="rowInfoData"><?php echo $infoArray['serialNumber']; ?></td></tr>
                            <tr><td id="rowInfoHeader"><?php echo "Notes:"; ?></td><td id="rowInfoData"><?php echo (str_replace("\\\\n", " | ", $infoArray['notes'])); ?></td></tr>
                            <tr><td id="rowInfoHeader"><?php echo "Model:"; ?></td><td id="rowInfoData"><?php echo $infoArray['model']; ?></td></tr>
                            <?php if ($infoArray['status'] == 'ACTIVE' ) { ?>
                            <tr><td id="rowInfoHeader"><?php echo "Status:"; ?></td><td id="rowInfoData" style="color: green; font-weight: bold"><?php echo $infoArray['status']; ?></td></tr>
                            <?php } ?>
                            <?php if ($infoArray['status'] == 'DISABLED' ) { ?>
                            <tr><td id="rowInfoHeader"><?php echo "Status:"; ?></td><td id="rowInfoData" style="color: red; font-weight: bold"><?php echo $infoArray['status']; ?></td></tr>
                            <?php } ?>
                            <tr><td id="rowInfoHeader"><?php echo "Location:"; ?></td><td id="rowInfoData"><?php echo $infoArray['annotatedLocation']; ?></td></tr>
                            <tr><td id="rowInfoHeader"><?php echo "User:"; ?></td><td id="rowInfoData"><?php echo $infoArray['annotatedUser']; ?></td></tr>
                            <tr><td id="rowInfoHeader"><?php echo "WiFi MAC:"; ?></td><td id="rowInfoData"><?php echo $infoArray['macAddress']; ?></td></tr>
                            <tr><td id="rowInfoHeader"><?php echo "OS Version:"; ?></td><td id="rowInfoData"><?php echo $infoArray['osVersion']; ?></td></tr>
                            <tr><td id="rowInfoHeader"><?php echo "Platform Version:"; ?></td><td id="rowInfoData"><?php echo $infoArray['platformVersion']; ?></td></tr>
                            <tr><td id="rowInfoHeader"><?php echo "Firmware Version:"; ?></td><td id="rowInfoData"><?php echo $infoArray['firmwareVersion']; ?></td></tr>
                            <tr><td id="rowInfoHeader"><?php echo "Org Unit Path:"; ?></td><td id="rowInfoData"><?php echo $infoArray['orgUnitPath']; ?></td></tr>
                            <tr><td id="rowInfoHeader"><?php echo "Device ID:"; ?></td><td id="rowInfoData"><?php echo $infoArray['deviceId']; ?></td></tr>
                            <tr><td id="rowInfoHeader"><?php echo "Last Sync:"; ?></td><td id="rowInfoData"><?php echo $syncDateAdj . "<font color='#008CBA'> [" . $infoArray['lastSync'] . "]</font>"; ?></td></tr>
                            <tr><td id="rowInfoHeader"><?php echo "Last Enrollment:"; ?></td><td id="rowInfoData"><?php echo $enrollDateAdj . "<font color='#008CBA'> [" . $infoArray['lastEnrollmentTime'] . "]</font>"; ?></td></tr>
                            <tr><td id="rowInfoHeader"><?php echo "Boot Mode:"; ?></td><td id="rowInfoData"><?php echo $infoArray['bootMode']; ?></td></tr>
                        </table>
                        <?php

                        echo "<br>";
                        //$crosHeaders = explode(",", $crosActivity[0]);
                        $crosData = explode(",", $crosActivity[1]);
                        echo "<b>USER LIST:</b>";
                        echo "<br>";
                        echo (str_replace(' ', ' <br> ', $crosData[6]));
                        echo "<br>";
                    }
                }
            } elseif ($counter == 0 && !empty($_GET['searchterm'])) {
                echo "<br>If there's no match in the local database, then there's nothing to query in Google. Sorry!";
            } elseif ($counter == 0 && empty($_GET['searchterm'])) {
                echo "<br>You didn't give me anything to search!";
            } else {
                echo "<br>";
            }

        } else {
            echo "No database exists. You should go to UTLITIES > CSV to MySQL and import your collection into the local database";
        }
        ?>
        
        <?php include "footer.php" ?>
    </body>
</html>
