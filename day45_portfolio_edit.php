<?php
$conn = new mysqli("localhost", "root", "", "dashboard45");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM portfolio WHERE id = $id");
$item = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $category = $conn->real_escape_string($_POST['category']);
    $image_path = $conn->real_escape_string($_POST['image_path']);
    $description = $conn->real_escape_string($_POST['description']);

    $sql = "UPDATE portfolio SET title='$title', category='$category', image_path='$image_path', description='$description' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: day45_show_portfolio.php");
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
  <title>Edit Portfolio Item</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-dark text-light">

<div class="container mt-5">
  <h2 class="text-warning mb-4">Edit Portfolio Item</h2>
  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Title</label>
      <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($item['title']) ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Category</label>
      <input type="text" name="category" class="form-control" value="<?= htmlspecialchars($item['category']) ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Image Path (URL)</label>
      <input type="text" name="image_path" class="form-control" value="<?= htmlspecialchars($item['image_path']) ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Description</label>
      <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($item['description']) ?></textarea>
    </div>
    <button type="submit" class="btn btn-success">Update</button>
    <a href="day45_show_portfolio.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>

</body>
</html>
