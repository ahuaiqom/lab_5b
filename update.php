<?php
include_once 'Database.php';

if (isset($_GET['matric'])) {
    $matric = htmlspecialchars($_GET['matric']);
    $database = new Database();
    $conn = $database->getConnection();

    // Query to get user data based on matric
    $stmt = $conn->prepare("SELECT name, role, password FROM users WHERE matric = ?");
    $stmt->bind_param("s", $matric);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    $name = $user['name'] ?? '';
    $role = $user['role'] ?? '';
    $password = $user['password'] ?? ''; // Password should be kept if not changed
    $stmt->close();
    $conn->close();
} else {
    header("Location: user.php"); // Redirect if matric not found
    exit();
}

// Handling the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $role = htmlspecialchars($_POST['role']);
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $password;

    // Update user information in the database
    $database = new Database();
    $conn = $database->getConnection();
    
    $stmt = $conn->prepare("UPDATE users SET name = ?, role = ?, password = ? WHERE matric = ?");
    $stmt->bind_param("ssss", $name, $role, $password, $matric);
    if ($stmt->execute()) {
        echo "<script>
                alert('Update successfully');
                window.location.href = 'user.php'; // Redirect to user.php
              </script>";
    } else {
        echo "<script>
                alert('Error updating user');
              </script>";
    }

    $stmt->close();
    $conn->close();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Update User</h1>
        <form action="" method="POST">
            <input type="hidden" name="matric" value="<?php echo htmlspecialchars($matric); ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role:</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="student" <?php echo $role === 'student' ? 'selected' : ''; ?>>student</option>
                    <option value="lecture" <?php echo $role === 'lecture' ? 'selected' : ''; ?>>lecture</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep current password">
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="user.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
