<?php
// Database configuration
$host = 'localhost'; // or your server name
$db_name = 'login_db';
$username = 'root';
$password = '';

// Create connection
$conn = new mysqli($host, $username, $password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "";
?>
