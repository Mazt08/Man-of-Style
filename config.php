<?php
$servername = "localhost";
$username = "u165011657_root"; // Default XAMPP username
$password = "Joemoriezz052023";
$dbname = "u165011657_azulcosmetics"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>