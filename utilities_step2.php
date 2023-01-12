<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="mystyle.css">
        <title>Utilities: Step 2</title>
    </head>
    <body>
        <?php include "utilities_header.php" ?>
        <?php include "variables.php" ?>
        <?php //include "utilities_submenu.php" ?>
        
        <ul class="menu">
            <li><a href="utilities_main.php">Status</a></li>
            <li><a href="utilities_step1.php">(1) GAM to CSV</a></li>
            <li><a class="active" href="utilities_step2.php">(2) CSV to MySQL</a></li>
            <li><a href="utilities_empty.php">Empty MySQL DB</a></li>
            <li><a href="utilities_help.php">Help</a></li>
        </ul>
        <hr>
        
        <br><br>
        <form method="POST">
            <input type="submit" name="CSVtoSQL" id="CSVtoSQL" value="Step 2: Import CSV into MySQL" ><br>
        </form>
        <br><br>

        <?php
            if(array_key_exists('CSVtoSQL',$_POST)) {

                //Create new connection & check connection
                $conn = new mysqli($DBserver, $DBuser, $DBpass);
                if ($conn->connect_error) {
                    die("Connection Failed: " . $check->connect_error);
                }
                    echo "Connection Success! <hr>";

                $sql = "CREATE DATABASE $DBname CHARACTER SET utf8 COLLATE utf8_unicode_ci";
                if ($conn->query($sql) === TRUE) {
                    echo "Database created successfully. <hr>";
                } else {
                    echo "Error creating database: " . $conn->error . ".<hr>";
                }

                $conn = new mysqli($DBserver, $DBuser, $DBpass, $DBname);

                $sql = "CREATE TABLE importdata (
                    deviceId VARCHAR(36) CHARACTER SET utf8 COLLATE utf8_unicode_ci PRIMARY KEY NOT NULL,
                    annotatedAssetId VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
                    annotatedLocation VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
                    annotatedUser VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
                    autoUpdateExpiration VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
                    bootMode VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
                    ethernetMacAddress VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
                    firmwareVersion VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
                    lastEnrollmentTime VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
                    lastSync VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
                    macAddress VARCHAR(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
                    manufactureDate VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
                    model VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
                    notes VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
                    orgUnitPath VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
                    osVersion VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
                    platformVersion VARCHAR(75) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
                    serialNumber VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
                    status VARCHAR(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci
                  )";
                
                if ($conn->query($sql) === TRUE) {
                    echo "Table created successfully. <hr>";
                } else {
                    echo "Error creating table: " . $conn->error . ".<hr>";
                }

                /*
                CREDIT https://dev.to/dudeastronaut/import-a-csv-file-into-a-mysql-database-using-php-pdo-jn1
                */

                $fieldSeparator = ";";
                $fieldEscapedBy = "";
                $fieldEnclosedBy = '"';
                $lineSeparator = "\n";
                $csvfile = "collection.csv";

                if (!file_exists($csvfile)) {
                    error_log('File does NOT exist!');
                    die("File not found. Make sure you specified the correct path.");
                }

                try {
                    $pdo = new PDO(
                        "mysql:host=$DBserver;dbname=$DBname",
                        $DBuser,
                        $DBpass,
                        array(
                            PDO::MYSQL_ATTR_LOCAL_INFILE => true,
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                        )
                    );
                } catch (PDOException $e) {
                    error_log('database connection failed!');
                    die("database connection failed: " . $e->getMessage());
                }

                $affectedRows = $pdo->exec(
                    "LOAD DATA LOCAL INFILE "
                    . $pdo->quote($csvfile)
                    . " INTO TABLE `importdata` FIELDS TERMINATED BY "
                    . $pdo->quote($fieldSeparator)
                    . " ESCAPED BY "
                    . $pdo->quote($fieldEscapedBy)
                    . " ENCLOSED BY "
                    . $pdo->quote($fieldEnclosedBy)
                    . " LINES TERMINATED BY "
                    . $pdo->quote($lineSeparator)
                    . " IGNORE 1 LINES "
                );

                echo "Loaded a total of $affectedRows records from the 'collection.csv' file.";
            }
        ?>

        <?php include "footer.php" ?>
    </body>
</html>
