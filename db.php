<?php

$db_name = "laura";
$db_host = "localhost";
$db_user = "Laura";
$db_pass = "7[_a@lSchxPz43kg";
$port_number = "3312";

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name, $port_number);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>