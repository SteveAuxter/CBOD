<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="mystyle.css">
        <title>Asset ID: Help</title>
    </head>
    <body>
        <?php include "assetid_header.php" ?>
        <?php //include "assetid_submenu.php" ?>
        
        <ul class="menu">
            <li><a href="assetid_main.php">Device Info</a></li>
            <li><a href="assetid_wipeusers.php">Clear Profiles</a></li>
            <li><a href="assetid_powerwash.php">Remote Powerwash</a></li>
            <li><a class="active" href="assetid_help.php">Help</a></li>
        </ul>
        <hr>
        
        <ul>
            <li><h3>Asset ID: Device Info</h3></li>
            <p>
            Enter an Asset ID and click Search for single Asset ID.<br>
            CBOD will first query the local database for an <b>EXACT MATCH</b> and provide a single result if one is found.<br>
            NOTE: If no exact match is found the process stops and a message appears indicating as much.<br>
            <p>
            Assuming a match is found in the local database ...<br>
            CBOD will then use GAMADV-XTD3 to query Google directly and provide basic device info on the same Asset ID.<br>
            The result from Google will include the Recent User List, where the topmost username is the most recent user of that device.<br>
            NOTE: The result from Google is the most current data available and may be newer or different than the local database.<br>
            
            <li><h3>Asset ID: Clear Profiles</h3></li>
            <p>
            Enter an Asset ID and click Clear Profiles.<br>
            CBOD will use GAMADV-XTD3 to issue the "wipe_users" command to the device based on the Asset ID query.<br>
            NOTE: It is helpful to make sure the device is on while performing this action.<br>
            
            <li><h3>Asset ID: Remote Powerwash</h3></li>
            <p>
            Enter an Asset ID and click Remote Powerwash.<br>
            CBOD will use GAMADV-XTD3 to issue the "remote_powerwash" command to the device based on the Asset ID query.<br>
            NOTE: It is helpful to make sure the device is on while performing this action.<br>
            
            <p><a href="https://github.com/SteveAuxter/CBOD/wiki/Asset-ID" target="_blank">Check the wiki on GitHub</a></p>

        </ul>

        <?php include "footer.php" ?>
    </body>
</html>
