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

// Check if form submitted via POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect and sanitize input
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $raw_password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'client';

    // Validation
    if (empty($username) || empty($email) || empty($raw_password)) {
        die("Error: All fields are required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Error: Invalid email format.");
    }

    // Check for existing user
    $check = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $check->bind_param("ss", $username, $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        die("Error: Username or Email already exists.");
    }
    $check->close();

    // Hash password
    $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

    // Insert user into DB
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $hashed_password, $role);

    if ($stmt->execute()) {
        echo "✅ User registered successfully.";
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request method.";
}

$conn->close();
?>
