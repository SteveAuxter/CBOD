<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="mystyle.css">
        <title>Counts: Models</title>
    </head>
    <body>
        <?php include "counts_header.php" ?>
        <?php include "variables.php" ?>
        <?php //include "counts_submenu.php" ?>
        
        <ul class="menu">
            <li><a href="counts_main.php">What do I do?</a></li>
            <li><a href="counts_osver.php">OS Version</a></li>
            <li><a href="counts_orgunit.php">Org Units</a></li>
            <li><a class="active" href="counts_model.php">Models</a></li>
            <li><a href="counts_location.php">Location</a></li>            
        </ul>
        <hr>
        
        <?php
            //Does the database exist?
            $check = new mysqli($DBserver, $DBuser, $DBpass);
            if ($check->select_db($DBname) === TRUE) {

                //Create new connection & check connection
                $conn = new mysqli($DBserver, $DBuser, $DBpass, $DBname);
                if ($conn->connect_error) {
                    die("Connection Failed: " . $conn->connect_error);
                }

                $starttime = microtime(true);
                $sql = "SELECT model,COUNT(DISTINCT(deviceId)) FROM importdata GROUP BY model ORDER BY model";
                $result = $conn->query($sql);
                ?>
                <!-- Exit PHP and draw HTML table -->
                <center>
                <table class="counting">
                    <tr>
                        <th><b>Models</b></th>
                        <th><b># of Devices</b></th>
                    </tr>
                <?php
                    $tally = 0;
                    foreach ($result as $row) {
                        ?>
                        <!-- Exit PHP and populate HTML table -->
                        <tr>
                            <td><?php echo $row["model"]; ?></td>
                            <td><?php echo $row["COUNT(DISTINCT(deviceId))"]; ?></td>
                        </tr>
                        <?php
                        $tally = $tally + $row["COUNT(DISTINCT(deviceId))"];
                    }
                    ?>
                    <!-- Exit PHP and finalize HTML table -->
                    <tr>
                        <td><b>TOTAL COUNT</b></td>
                        <td><b><?php echo $tally; ?></b></td>
                    </tr>
                </table>
                </center>
                <?php
                    $conn->close();
                    $endtime = microtime(true);
                    $duration = $endtime - $starttime;
                    echo "<br><br>";
                    echo "Process took " . number_format((float)$duration, 4) . " seconds.";
            } else {
                echo "No database exists. You should go to UTLITIES > CSV to MySQL and import your collection into the local database";
            }
            ?>
       
        <?php include "footer.php" ?>
    </body>
</html>
