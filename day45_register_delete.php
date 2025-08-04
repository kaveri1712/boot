<?php
$conn = new mysqli("localhost", "root", "", "dashboard45");

if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$id = intval($_GET['id']);
$sql = "DELETE FROM users WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    header("Location: users.php"); // Redirect after deletion
    exit;
} else {
    echo "Error deleting record: " . $conn->error;
}
?>
