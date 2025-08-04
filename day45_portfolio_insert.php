<?php
// DB connection info
$server = "localhost";
$user = "root";
$password = "";
$db = "dashboard45";

// Create connection
$conn = new mysqli($server, $user, $password, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process POST data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if (empty($title)) {
        die("Error: Title is required.");
    }

    // Handle file upload if image was submitted
    $imagePath = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = "uploads/portfolio/";
        // Create directory if not exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = basename($_FILES['image']['name']);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Allowed image extensions
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (in_array($fileExt, $allowedExts)) {
            // Generate a unique filename to avoid overwriting
            $newFileName = uniqid('port_') . '.' . $fileExt;
            $destPath = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $imagePath = $destPath;
            } else {
                die("Error: Failed to move uploaded file.");
            }
        } else {
            die("Error: Invalid image file type.");
        }
    }

    // Prepare and execute insert query
    $stmt = $conn->prepare("INSERT INTO portfilo (title, description, image) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $description, $imagePath);

    if ($stmt->execute()) {
        echo "✅ Portfolio item added successfully.";
        echo '<br><a href="portfolio_add.html">Add another</a>';
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request method.";
}

$conn->close();
?>
