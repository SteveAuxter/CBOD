<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="mystyle.css">
        <title>Utilities: Help</title>
    </head>
    <body>
        <?php include "utilities_header.php" ?>
        <?php include "variables.php" ?>
        <?php //include "utilities_submenu.php" ?>
        
        <ul class="menu">
            <li><a href="utilities_main.php">Status</a></li>
            <li><a href="utilities_step1.php">(1) GAM to CSV</a></li>
            <li><a href="utilities_step2.php">(2) CSV to MySQL</a></li>
            <li><a href="utilities_empty.php">Empty MySQL DB</a></li>
            <li><a class="active" href="utilities_help.php">Help</a></li>
        </ul>
        <hr>
        
        <ul>
            <li><h3>Initial Collection</h3></li>
            If this is your first time running through CBOD, you should only need to perform two steps:<br>
            (1) <b>GAM to CSV</b> - this will export data from the Google Admin console and place it neatly in a CSV file.<br>
            (2) <b>CSV to MySQL</b> - this will import the newly created CSV file into a newly created MySQL database.<br>

            <li><h3>Updating the Collection</h3></li>
            If you need to collect new or updated data from the Google Admin console, but you've already imported into the MySQL database, you'll need one extra step:<br>
            <b>Empty MySQL DB</b> - if you already have data in your MySQL database, you need to empty it first before populating it with new or updated data.<br>
            Then you may proceed with the usual step (1) <b>GAM to CSV</b> followed by step (2) <b>CSV to MySQL</b><br>
            <br>
            <hr>

            <li><h3>GAM to CSV</h3></li>
            <i>Q. What command/script/thing are you executing?</i><br>
            <p>A. 'PATH_TO_GAMADV_EXECUTABLE config csv_output_column_delimiter ";" print cros fields annotatedAssetId,annotatedLocation,annotatedUser,autoUpdateExpiration,bootMode,ethernetMacAddress,firmwareVersion,lastEnrollmentTime,lastSync,macAddress,manufactureDate,model,notes,orgUnitPath,osVersion,platformVersion,serialNumber,status queries "\"status:ACTIVE\",\"status:DISABLED\"" > collection.csv'<br>
            <br>
            <i>Q. Are you collecting information about all devices?</i><br>
            <p>A. Only ACTIVE and DISABLED, while purposefully omitting DEPROVISIONED devices.<br>
            <br>
            <i>Q. May I see what you collected?</i><br>
            <p>A. Absolutely! <a href="collection.csv" target="_blank">Here you go!</a><br>
            <br>

            <li><h3>CSV to MySQL</h3></li>
            <i>Q. I clicked the button and it said "Can't create database '<?php echo $DBname; ?>'; database exists"</i><br>
            <p>A. Use the "Empty MySQL DB" option, then retry "CSV to MySQL"<br>
            <br>
            <i>Q. I clicked the button and it said "Table 'importdata' already exists"</i><br>
            <p>A. Use the "Empty MySQL DB" option, then retry "CSV to MySQL"<br>
            <br>
            <i>Q. I clicked the button and it said "Loaded a total of 0 records from the 'collection.csv' file"</i><br>
            <p>A. Use the "Empty MySQL DB" option, then retry "CSV to MySQL" and/or make sure your 'collection.csv' is NOT empty by downloading and opening it. If it truly is empty, retry the "GAM to CSV" step.<br>
            <br>
        </ul>

        <?php include "footer.php" ?>
    </body>
</html>
