<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start session only if it’s not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
