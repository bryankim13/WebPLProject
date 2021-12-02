<?php
// REQUIRED HEADERS FOR CORS
// Allow access to our development server, localhost:4200
header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT");

include('database_connection.php');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Extra Error Printing
$mysqli = new mysqli($dbserver, $dbuser, $dbpass, $dbdatabase);
$user = null;

$request = file_get_contents("php://input");
$data = json_decode($request, true);

$output = [
    "time" => date("Y-m-d g:i a"),
    "request" => $data
];
$wishes = [];

foreach ($data as $wish) {
    array_push($wishes, "{$wish['model']} for {$wish['brand']}");
}

$output["wishes"] = $wishes;

// Send the result to the client (print it out)

header("Content-Type: application/json");
echo json_encode($output, JSON_PRETTY_PRINT);