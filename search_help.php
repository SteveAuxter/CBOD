<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="mystyle.css">
        <title>Search: Help</title>
    </head>
    <body>
        <?php include "search_header.php" ?>
        <?php //include "search_submenu.php" ?>
        
        <ul class="menu">
            <li><a href="search_main.php">Find & Sort</a></li>
            <li><a class="active" href="search_help.php">Help</a></li>
        </ul>
        <hr>
        
        <ul>
            <li><h3>Search: Find & Sort</h3></li>
            <p><a href="https://github.com/SteveAuxter/CBOD/wiki/Menu:-Search" target="_blank">CBOD wiki on GitHub</a></p>
            <p>Enter full or partial Asset ID, Serial Number, or Note - then press <b>Search</b>.</p>
            <p>(Hint) Leave the search field blank - then press <b>Search</b> - will show all devices.</p>
            <p>Sorting will always default to Asset ID, but can be toggled to Serial Number or Notes field.</p>
            <p>Clicking linked Asset ID will open Asset ID > Device Info, showing details direct from Google query - <i>including</i> Recent User List.</p>
            <p>Clicking linked Serial Number will open Serial Number > Device Info, showing details direct from Google query - <i>including</i> Recent User List.</p>
            <p>Clicking linked Device ID will open the device page directly in Google Admin console.</p>
        </ul>

        <?php include "footer.php" ?>
    </body>
</html>
