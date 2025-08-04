<?php
$conn = new mysqli("localhost", "root", "", "dashboard45");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$id = intval($_GET['id']);
$sql = "DELETE FROM portfolio WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    header("Location: day45_show_portfolio.php");
    exit;
} else {
    echo "Error deleting: " . $conn->error;
}
?>
