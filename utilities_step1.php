<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="mystyle.css">
        <title>Utilities: Step 1</title>
    </head>
    <body>
        <?php include "utilities_header.php" ?>
        <?php include "variables.php" ?>
        <?php //include "utilities_submenu.php" ?>
        
        <ul class="menu">
            <li><a href="utilities_main.php">Status</a></li>
            <li><a class="active" href="utilities_step1.php">(1) GAM to CSV</a></li>
            <li><a href="utilities_step2.php">(2) CSV to MySQL</a></li>
            <li><a href="utilities_empty.php">Empty MySQL DB</a></li>
            <li><a href="utilities_help.php">Help</a></li>
        </ul>
        <hr>
        
        <br><br>
        <form method="POST">
            <input type="submit" name="GAMtoCSV" id="GAMtoCSV" value="Step 1: Query GAM & Build CSV" ><br>
        </form>
        <br><br>

        <?php
            function gatherData() {
                global $GAMpath;
                $fullCommand = $GAMpath . ' config csv_output_column_delimiter ";" print cros fields annotatedAssetId,annotatedLocation,annotatedUser,autoUpdateExpiration,bootMode,ethernetMacAddress,firmwareVersion,lastEnrollmentTime,lastSync,macAddress,manufactureDate,model,notes,orgUnitPath,osVersion,platformVersion,serialNumber,status queries "\"status:ACTIVE\",\"status:DISABLED\"" > collection.csv';
                shell_exec($fullCommand);
                echo "<br>Script has completed. Check the STATUS page for more details.<br>";
            }

            if(array_key_exists('GAMtoCSV',$_POST)) {
                gatherData();
            }
        ?>

        <?php include "footer.php" ?>
    </body>
</html>
