<?php

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

// Handle delete
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    $conn->query("DELETE FROM users WHERE id = $id");
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Fetch all contact messages
$sql = "SELECT id, name, email, message, submitted_at FROM contacta ORDER BY submitted_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Contact Messages</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #1c92d2, #f2fcfe);
            padding: 30px;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #222;
        }
        form {
            background: #fff;
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 12px;
        }
        h3 {
            margin-top: 30px;
            color: #0066cc;
        }
        input, textarea {
            width: 100%;
            padding: 8px;
            margin-top: 6px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            background: #28a745;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
        }
        button:hover {
            background: #218838;
        }
    </style>
</head>
<body class="bg-dark text-light">
  <div class="table-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-warning">Contact Messages</h2>
    <!-- 🔙 Back to External Form -->
        <a href="day45_contacts_form.html" class="btn btn-outline-light">← Back to Form</a>
    </div>
    <?php if ($result->num_rows > 0): ?>
    <table class="table table-bordered table-dark table-hover">
        <thead class="table-warning text-dark">
  <tr>
    <th>Id</th>
    <th>Name</th>
    <th>Email</th>
    <th>Message</th>
    <th>Submitted At</th>
    <th>Actions</th>
  </tr>
</thead>

      <tbody>
        
          <?php while($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['id']) ?></td>
              <td><?= htmlspecialchars($row['name']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= htmlspecialchars($row['message']) ?></td>
              <td><?= htmlspecialchars($row['submitted_at']) ?></td>
              <td>
  <a href="day45_edit_contacts.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
  <a href="day45_delete_contacts.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this message?');">Delete</a>
</td>

            </tr>
          <?php endwhile; ?>
        </tbody>
         </table>
          <?php else: ?>
            <div class="alert alert-info">No messages found.</div>
            <?php endif; ?>
          
  </div>
</body>
</html>
<?php
$conn->close();
?>