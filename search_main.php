<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="mystyle.css">
        <title>Search: Find & Sort</title>
    </head>
    <body>
        <?php include "search_header.php" ?>
        <?php include "variables.php" ?>
        <?php //include "search_submenu.php" ?>
        
        <ul class="menu">
            <li><a class="active" href="search_main.php">Find & Sort</a></li>
            <li><a href="search_help.php">Help</a></li>
        </ul>
        <hr>

        <form name="search" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            Enter full or partial Asset ID, Serial Number, or Note:<br><br>
            <input type="text" name="searchterm">
            <input type="submit" value="Search">
            <br><br>
            Sort by:
            <input type="radio" name="sortby" value="annotatedAssetId" checked />Asset ID
            <input type="radio" name="sortby" value="serialNumber" />Serial Number
            <input type="radio" name="sortby" value="notes" />Notes
        </form>
        <br><br>

        <?php
            //Does the database exist?
            $check = new mysqli($DBserver, $DBuser, $DBpass);
            if ($check->select_db($DBname) === TRUE) {

                //Create new connection & check connection
                $conn = new mysqli($DBserver, $DBuser, $DBpass, $DBname);
                if ($conn->connect_error) {
                    die("Connection Failed: " . $conn->connect_error);
                }

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $starttime = microtime(true);
                    $mysearch = $_POST["searchterm"];
                    $mysort = $_POST["sortby"];
                    
                    $sql = "SELECT * FROM importdata
                    WHERE annotatedAssetId LIKE '%{$mysearch}%'
                    OR serialNumber LIKE '%{$mysearch}%'
                    OR notes LIKE '%{$mysearch}%'
                    ORDER BY $mysort";

                    $result = $conn->query($sql);
                    $counter = 0;

                    if ($result->num_rows > 0) {
                        ?>
                        <!-- Exit PHP and draw HTML table -->
                        <center>
                        <table class="counting">
                            <tr>
                                <th><b>Asset ID</b></th>
                                <th><b>Serial #</b></th>
                                <th><b>Notes</b></th>
                                <th><b>Model</b></th>
                                <th><b>Location</b></th>
                                <th><b>User</b></th>
                                <th><b>OS Version</b></th>
                                <!-- <th><b>Org Unit Path</b></th> -->
                                <!-- <th><b>WiFi MAC</b></th> -->
                                <!-- <th><b>Wired MAC</b></th> -->
                                <th><b>Device ID</b></th>
                            </tr>
                        <?php
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <!-- Exit PHP and populate HTML table -->
                                <tr>
                                    <td><a href="assetid_main.php?searchterm=<?php echo $row["annotatedAssetId"]; ?>" target="_blank"><?php echo $row["annotatedAssetId"]; ?></a></td>
                                    <td><a href="serial_main.php?searchterm=<?php echo $row["serialNumber"]; ?>" target="_blank"><?php echo $row["serialNumber"]; ?></a></td>
                                    <td><?php echo (str_replace(['\\\\n', '\\n'], '<br>', $row["notes"])); ?></td>
                                    <td><?php echo $row["model"]; ?></td>
                                    <td><?php echo $row["annotatedLocation"]; ?></td>
                                    <td><?php echo $row["annotatedUser"]; ?></td>
                                    <td><?php echo $row["osVersion"]; ?></td>
                                    <!-- <td><?php //echo $row["orgUnitPath"]; ?></td> -->
                                    <!-- <td><?php //echo $row["macAddress"]; ?></td> -->
                                    <!-- <td><?php //echo $row["ethernetMacAddress"]; ?></td> -->
                                    <td><a href="https://admin.google.com/ac/chrome/devices/<?php echo $row["deviceId"]; ?>" target="_blank"><?php echo $row["deviceId"]; ?></a></td>
                                </tr>
                                <?php
                                $counter++;
                            }
                            ?>
                            <!-- Exit PHP and finalize HTML table -->
                        </table>
                        </center>
                        <br>
                        <?php
                        echo "<center>Found " . $counter . " result(s).";
                    } else {
                        echo "Found 0 results.";
                    }
                    $conn->close();
                    $endtime = microtime(true);
                    $duration = $endtime - $starttime;
                    //echo "<br><br>";
                    echo " Process took " . number_format((float)$duration, 4) . " seconds.</center>";
                }
            } else {
                echo "No database exists. You should go to UTILITIES > CSV to MySQL and import your collection into the local database";
            }
            ?>
        
        <?php include "footer.php" ?>
    </body>
</html>
