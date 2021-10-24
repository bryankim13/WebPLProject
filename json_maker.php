<?php
    include('database_connection.php');
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Extra Error Printing
    $mysqli = new mysqli($dbserver, $dbuser, $dbpass, $dbdatabase);
    $user = null;
    // Join session or start one
    session_start();
    $stmt = $mysqli->query("select * from location;");
    $data_table = mysqli_fetch_all($stmt, MYSQLI_ASSOC);
    $file = file_put_contents("location_table.json", $file);
    
?>