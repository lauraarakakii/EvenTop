<?php
/*
$db_name = "laura";
$db_host = "localhost";
$db_user = "Laura";
$db_pass = "7[_a@lSchxPz43kg";
$port_number = "3312";

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name, $port_number);

$connPDO = new PDO("mysql:dbname=". $db_name .";host=". $db_host, $db_user, $db_pass, $port_number);

// Check connection
if ($conn1->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}*/

$host = 'localhost';
$db = 'laura';
$user = 'Laura';
$pass = '7[_a@lSchxPz43kg';
$charset = 'utf8mb4';
$port = '3312';

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$conn = new PDO($dsn, $user, $pass, $opt);

?>