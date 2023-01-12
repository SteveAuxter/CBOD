<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="mystyle.css">
        <title>Utilities: Empty DB</title>
    </head>
    <body>
        <?php include "utilities_header.php" ?>
        <?php include "variables.php" ?>
        <?php //include "utilities_submenu.php" ?>
        
        <ul class="menu">
            <li><a href="utilities_main.php">Status</a></li>
            <li><a href="utilities_step1.php">(1) GAM to CSV</a></li>
            <li><a href="utilities_step2.php">(2) CSV to MySQL</a></li>
            <li><a class="active" href="utilities_empty.php">Empty MySQL DB</a></li>
            <li><a href="utilities_help.php">Help</a></li>
        </ul>
        <hr>

        <br><br>
        <form method="POST">
            <input type="submit" name="DROPtheDB" id="DROPtheDB" value="Empty MySQL DB" ><br>
        </form>
        <br><br>

        <?php
            if(array_key_exists('DROPtheDB',$_POST)) {

                //Create new connection & check connection
                $conn = new mysqli($DBserver, $DBuser, $DBpass);
                if ($conn->connect_error) {
                    die("Connection Failed: " . $check->connect_error);
                }
                    echo "Connection Success! <hr>";

                $sql = "DROP DATABASE IF EXISTS $DBname";
                
                //Connect to database & drop database
                if ($conn->query($sql) === TRUE) {
                    echo "Database dropped successfully. <br>";
                } else {
                    echo "Error dropping database: " . $conn->error . ".<br>";
                }
            }
            ?>

        <?php include "footer.php" ?>
    </body>
</html>
