<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="mystyle.css">
        <title>Utilities: What do I do?</title>
    </head>
    <body>
        <?php include "utilities_header.php" ?>
        <?php include "variables.php" ?>
        <?php //include "utilities_submenu.php" ?>
        
        <ul class="menu">
            <li><a class="active" href="utilities_main.php">Status</a></li>
            <li><a href="utilities_step1.php">(1) GAM to CSV</a></li>
            <li><a href="utilities_step2.php">(2) CSV to MySQL</a></li>
            <li><a href="utilities_empty.php">Empty MySQL DB</a></li>
            <li><a href="utilities_help.php">Help</a></li>
        </ul>
        <hr>
        <br>

        <?php
            if (file_exists("collection.csv") == 1){
                echo "The COLLECTION file exists! <br>";
                $fsBytes = filesize("collection.csv");                
                $fsKBytes = round($fsBytes/1024,0);
                $fsMBytes = round($fsBytes/1048576,2);
                echo "The COLLECTION file is " . number_format($fsBytes) . " bytes large. This is also " . number_format($fsKBytes) . " KB or " . $fsMBytes . " MB. <br>";
                echo "The COLLECTION file last changed on: " . date("F d Y H:i:s.", filemtime("collection.csv")) . "<br>";
                $numlines = count(file("collection.csv"));
                echo "There are " . $numlines . " lines in the COLLECTION. <br>";
                echo "This means there are " . --$numlines . " Active & Disabled devices in your COLLECTION (and 1 header row). <br>";
            } elseif (file_exists("collection.csv") == 0){
                echo "The COLLECTION file does NOT exist! You should go to UTILITIES > GAM to CSV and gather your device collection. <br>";
            } else {
                echo "Something has gone horribly wrong!<br>";
            }
            echo "<br><br>";

            //Does the database exist?
            $check = new mysqli($DBserver, $DBuser, $DBpass);
            if ($check->select_db($DBname) === TRUE) {
            
                //Create new connection & check connection
                $conn = new mysqli($DBserver, $DBuser, $DBpass, $DBname);
                if ($conn->connect_error) {
                    die("Database connection has failed: " . $check->connect_error . "<br>");
                }
                    echo "Database connection success! <br>";
            
            } else {
                echo "No database exists. You should go to UTILITIES > CSV to MySQL and import your collection into the local database <br>";
            }

        ?>

        <?php include "footer.php" ?>
    </body>
</html>
