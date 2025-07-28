<?php

$host = 'localhost'; 
$db_name = 'salon';
$username = 'root';
$password = '';
$port = 3306; 

$conn = new mysqli($host, $username, $password, $db_name, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>