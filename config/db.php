<?php
$host = "localhost";
$user = "root";   // XAMPP default user
$pass = "";       // Leave blank for XAMPP
$dbname = "fudgicraft";

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>