<?php
$conn = new mysqli("localhost", "root", "", "dashboard45");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM contacta WHERE id = $id");
$contact = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);

    $sql = "UPDATE contacta SET name='$name', email='$email', message='$message' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: day45_show_contacts.php"); // Update this to your actual listing page
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
  <title>Edit Contact Message</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light text-dark">
<div class="container mt-5">
  <h2 class="mb-4">Edit Contact Message</h2>
  <form method="POST">
    <div class="mb-3">
      <label>Name</label>
      <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($contact['name']) ?>" required>
    </div>
    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($contact['email']) ?>" required>
    </div>
    <div class="mb-3">
      <label>Message</label>
      <textarea name="message" class="form-control" rows="4" required><?= htmlspecialchars($contact['message']) ?></textarea>
    </div>
    <button type="submit" class="btn btn-success">Update</button>
    <a href="day45_show_contacts.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>
</body>
</html>
