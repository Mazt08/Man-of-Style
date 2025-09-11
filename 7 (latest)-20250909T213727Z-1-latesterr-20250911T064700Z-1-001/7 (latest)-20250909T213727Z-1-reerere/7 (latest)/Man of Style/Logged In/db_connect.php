<?php
$servername = "localhost";   // usually "localhost"
$username   = "root";        // your MySQL username
$password   = "";            // your MySQL password (default empty in XAMPP)
$dbname     = "manofstyle"; // replace with your DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>