<?php
$conn = new mysqli("localhost", "root", "", "dashboard45");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM services WHERE id = $id");
$service = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $icon = $conn->real_escape_string($_POST['icon']);

    $sql = "UPDATE services SET title='$title', description='$description', icon='$icon' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: day45_show_services.php");
        exit;
    } else {
        echo "Error updating: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Edit Service</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-dark text-light">

<div class="container mt-5">
  <h2 class="text-warning mb-4">Edit Service</h2>
  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Title</label>
      <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($service['title']) ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Description</label>
      <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($service['description']) ?></textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">Icon URL</label>
      <input type="text" name="icon" class="form-control" value="<?= htmlspecialchars($service['icon']) ?>">
    </div>
    <button type="submit" class="btn btn-success">Update</button>
    <a href="day45_show_services.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>

</body>
</html>
