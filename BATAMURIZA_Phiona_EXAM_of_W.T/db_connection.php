<?php
// Connection details
$host = "localhost";
$user = "Batamuriza";
$pass = "phiona";
$database = "carpoolingapplication";

// Creating connection
$connection = new mysqli($host, $user, $pass, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>