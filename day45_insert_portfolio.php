<?php
// DB connection settings
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "dashboard45"; // Replace this with your DB name

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$title = trim($_POST['title']);
$category = trim($_POST['category']);
$image_path = trim($_POST['image_path']);
$description = trim($_POST['description']);

// Prepare and insert data
$sql = "INSERT INTO portfolio (title, category, image_path, description) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("ssss", $title, $category, $image_path, $description);
    if ($stmt->execute()) {
        echo "✅ Portfolio item added successfully. ";
    } else {
        echo "❌ Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "❌ Failed to prepare statement: " . $conn->error;
}

$conn->close();
?>