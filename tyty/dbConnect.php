<?php
$host = 'localhost'; // Replace with your host
$user = 'root'; // Replace with your database username
$password = ''; // Replace with your database password
$dbname = 'oopbank'; // Replace with your database name

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
