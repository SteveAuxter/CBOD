<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="mystyle.css">
        <title>DataTables: Full List</title>
        
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">

        <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>

        <!--
            DOM settings explained, default config:
            B = Buttons
            l = Length changing input control
            f = Filtering input
            t = the Table
            i = Information summary
            p = Pagination control
            r = pRocessing display element
        -->

        <script type="text/javascript">
            $(document).ready(function() {
                $('#myTable').DataTable( {
                    lengthMenu:
                    [
                        [10, 25, 100, -1],
                        [10, 25, 100, "All"]
                    ],
                    responsive: true,
                    dom: "Bftlrip",
                    buttons: 
                    [
                        {extend: 'copy', title: null, exportOptions: {columns: ':visible'}},
                        {extend: 'csv', title: null, exportOptions: {columns: ':visible'}},
                        {extend: 'excel', title: null, exportOptions: {columns: ':visible'}},
                        {extend: 'pdf', title: 'Datatables PDF', exportOptions: {columns: ':visible'}},
                        {extend: 'print', title: 'Datatables Print', exportOptions: {columns: ':visible'}},
                        {extend: 'colvis', text: 'Toggle Columns'}
                    ]
                } );
            } );
        </script>

    </head>
    <body
        <?php include "datatables_header.php" ?>
        <?php include "variables.php" ?>
        <?php //include "datatables_submenu.php" ?>

        <ul class="menu">
            <li><a class="active" href="datatables_main.php">Full List</a></li>
            <li><a href="datatables_help.php">Help</a></li>
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

                $sql = "SELECT * FROM importdata";
                $result = $conn->query($sql);
                ?>
                <!-- Exit PHP and draw HTML table -->
                <table id="myTable" class="cell-border display responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th>Asset ID</th>
                            <th>Serial #</th>
                            <th>Notes</th>
                            <th>Model</th>
                            <th>Status</th>
                            <th>Location</th>
                            <th>User</th>
                            <th>WiFi MAC</th>
                            <th>Wired MAC</th>
                            <th>OS Version</th>
                            <th>Platform Version</th>
                            <th>Firmware Version</th>
                            <!-- <th>Boot Mode</th> -->
                            <!-- <th>Last Enrollment</th> -->
                            <!-- <th>Last Sync</th> -->
                            <!-- <th>Manufacture Date</th> -->
                            <!-- <th>Auto Update Exp</th> -->
                            <th>Org Unit Path</th>
                            <th>Device ID</th>
                        </tr>
                    </thead>
            <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <!-- Exit PHP and populate HTML table -->
                        <tr>
                            <td><?php echo $row["annotatedAssetId"]; ?></td>
                            <td><?php echo $row["serialNumber"]; ?></td>
                            <td><?php echo (str_replace('\\\n', '<br>', $row["notes"])); ?></td>
                            <td><?php echo $row["model"]; ?></td>
                            <td><?php echo $row["status"]; ?></td>
                            <td><?php echo $row["annotatedLocation"]; ?></td>
                            <td><?php echo $row["annotatedUser"]; ?></td>
                            <td><?php echo $row["macAddress"]; ?></td>
                            <td><?php echo $row["ethernetMacAddress"]; ?></td>
                            <td><?php echo $row["osVersion"]; ?></td>
                            <td><?php echo $row["platformVersion"]; ?></td>
                            <td><?php echo $row["firmwareVersion"]; ?></td>
                            <!-- <td><//?php echo $row["bootMode"]; ?></td> -->
                            <!-- <td><//?php echo $row["lastEnrollmentTime"]; ?></td> -->
                            <!-- <td><//?php echo $row["lastSync"]; ?></td> -->
                            <!-- <td><//?php echo $row["manufactureDate"]; ?></td> -->
                            <!-- <td><//?php echo $row["autoUpdateExpiration"]; ?></td> -->
                            <td><?php echo $row["orgUnitPath"]; ?></td>
                            <td><?php echo $row["deviceId"]; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    <!-- Exit PHP and finalize HTML table -->
                </table>
                <?php
                }
                $conn->close();
            } else {
                echo "No database exists. You should go to UTLITIES > CSV to MySQL and import your collection into the local database";
            }
            ?>
       
        <?php include "footer.php" ?>
    </body>
</html>
