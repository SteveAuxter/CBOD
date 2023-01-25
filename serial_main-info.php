<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="mystyle.css">
        <title>Serial Number: Device Info</title>
    </head>
    <body>
        <?php include "serial_header.php" ?>
        <?php include "variables.php" ?>
        <?php //include "serial_submenu.php" ?>
        
        <ul class="menu">
            <li><a class="active" href="serial_main.php">Device Info</a></li>
            <li><a href="serial_wipeusers.php">Clear Profiles</a></li>
            <li><a href="serial_powerwash.php">Remote Powerwash</a></li>
            <li><a href="serial_disable.php">Disable/Enable</a></li>
            <li><a href="serial_help.php">Help</a></li>
        </ul>
        <hr>
        
        <form name="search" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET">
        Search: <input type="text" name="searchterm">
        <input type="submit" value="Search for single Serial #">
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

                    $sql = "SELECT * FROM importdata WHERE serialNumber='{$mysearch}'";
                    
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
                        
                        $command1 = sprintf("$GAMpath info cros query id:%s annotatedAssetId annotatedLocation annotatedUser bootMode firmwareVersion lastEnrollmentTime lastSync macAddress model notes orgUnitPath osVersion platformVersion serialNumber status", $mysearch);
                        exec($command1,$infoBasic);

                        $command2 = sprintf("$GAMpath print crosactivity query id:%s users", $mysearch);
                        exec($command2,$crosActivity);

                        echo "<h3>Asking Google about device with Serial Number <font color='#008CBA'>$mysearch</font>. Here's what I found:</h3>";
                        foreach ($infoBasic as $data) {
                            echo (str_replace('\n', ' | ', $data));
                            echo "<br>";
                        }
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
