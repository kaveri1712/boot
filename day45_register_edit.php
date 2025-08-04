<?php
$conn = new mysqli("localhost", "root", "", "dashboard45");

if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$id = intval($_GET['id']);
$sql = "SELECT * FROM users WHERE id = $id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $role = $conn->real_escape_string($_POST['role']);

    $update = "UPDATE users SET username='$username', email='$email', role='$role' WHERE id=$id";
    if ($conn->query($update) === TRUE) {
        header("Location: day45_show_register.php"); // Redirect back to user list
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Edit User</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">

<div class="container mt-5">
  <h2 class="text-warning mb-4">Edit User</h2>
  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Username</label>
      <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Role</label>
      <input type="text" name="role" class="form-control" value="<?= htmlspecialchars($user['role']) ?>" required>
    </div>
    <button type="submit" class="btn btn-success">Update</button>
    <a href="day45_show_register.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>

</body>
</html>
