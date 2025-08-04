<?php
$conn = new mysqli("localhost", "root", "", "dashboard45");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM adout WHERE id = $id");
$about = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $content = $conn->real_escape_string($_POST['content']);
    $image_path = $conn->real_escape_string($_POST['image_path']);

    $sql = "UPDATE adout SET title='$title', content='$content', image_path='$image_path', updated_at=NOW() WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: day45_show_about.php"); // Replace with actual listing page name
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit About Entry</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
<div class="container mt-5">
  <h2 class="mb-4 text-warning">Edit About Section</h2>
  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Title</label>
      <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($about['title']) ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Content</label>
      <textarea name="content" class="form-control" rows="5" required><?= htmlspecialchars($about['content']) ?></textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">Image Path (URL)</label>
      <input type="text" name="image_path" class="form-control" value="<?= htmlspecialchars($about['image_path']) ?>">
    </div>
    <button type="submit" class="btn btn-success">Update</button>
    <a href="day45_show_about.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>
</body>
</html>
