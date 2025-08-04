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

// Get form data and sanitize
$title = trim($_POST['title'] ?? '');
$content = trim($_POST['content'] ?? '');
$image_path = trim($_POST['image_path'] ?? '');

// Validate required fields
if (empty($title) || empty($content)) {
    die("❌ Error: Title and content are required.");
}

// Prepare and insert data into adout table
$sql = "INSERT INTO adout (title, content, image_path) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("sss", $title, $content, $image_path);
    if ($stmt->execute()) {
        echo "✅ About section saved successfully. ";
    } else {
        echo "❌ Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "❌ Failed to prepare statement: " . $conn->error;
}

$conn->close();
?>