<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$server = "localhost";
$user = "root";
$password = "";
$db = "dashboard45";

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

// Fetch all services
$sql = "SELECT id, title, description, icon, created_at FROM services";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>All Services</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
        font-family: Arial, sans-serif;
        background: linear-gradient(to right, #1c92d2, #f2fcfe);
        padding: 30px;
        color: #333;
    }
    h2 {
        color: #222;
    }
    .table-container {
        max-width: 1000px;
        margin: auto;
    }
  </style>
</head>
<body class="bg-dark text-light">

<div class="table-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="mb-4 text-warning">Our Services</h2>
        <!-- 🔙 Back to External Form -->
        <a href="day45_service_form.html" class="btn btn-outline-light">← Back to Form</a>
    </div>
  

  <?php if ($result->num_rows > 0): ?>
    <table class="table table-bordered table-dark table-hover">
      <thead class="table-warning text-dark">
  <tr>
    <th>ID</th>
    <th>Title</th>
    <th>Description</th>
    <th>Icon</th>
    <th>Created At</th>
    <th>Actions</th>

  </tr>
</thead>

      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
                      <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>
                <td><?= htmlspecialchars($row['icon']) ?></td>
                <td><?= htmlspecialchars($row['created_at']) ?></td>
               
                <td>
  <a href="day45_edit_service.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
  <a href="day45_delete_service.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this service?');">Delete</a>
</td>
</tr>
              
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <div class="alert alert-info">No services found.</div>
  <?php endif; ?>

</div>

</body>
</html>

<?php
$conn->close();
?>