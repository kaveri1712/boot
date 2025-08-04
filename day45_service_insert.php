<?php
// Database config
$server = "localhost";
$user = "root";
$password = "";
$db = "dashboard45";

// Connect to database
$conn = new mysqli($server, $user, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect and sanitize input
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $icon = trim($_POST['icon'] ?? '');

    // Validation
    if (empty($title)) {
        die("Error: Title is required.");
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO services (title, description, icon) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $description, $icon);

    if ($stmt->execute()) {
        echo "✅ Service added successfully.";
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request method.";
}

$conn->close();
?>
