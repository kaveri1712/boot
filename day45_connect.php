<?php
$servername = "localhost";     // or your DB host
$username = "root";            // your MySQL username
$password = "";                // your MySQL password
$dbname = "dashboard45"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>