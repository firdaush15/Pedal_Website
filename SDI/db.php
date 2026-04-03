<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');       // Or your MySQL username
define('DB_PASS', '');           // Or your MySQL password
define('DB_NAME', 'pedal_Malaysia');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, 3306);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
?>
