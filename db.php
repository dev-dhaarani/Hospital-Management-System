<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital_db";

// Start session only if it’s not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("❌ Database Connection Failed: " . $conn->connect_error);
}

// Set character set to UTF-8
$conn->set_charset("utf8");

?>
