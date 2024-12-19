<?php
session_start();
include_once 'Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Koneksi ke database
    $database = new Database();
    $conn = $database->getConnection();

    // Validasi dan filter input
    $matric = htmlspecialchars(trim($_POST['matric']));
    $password = trim($_POST['password']);

    if (empty($matric) || empty($password)) {
        $error = "All fields are required!";
    } else {
        // Query untuk mencari user berdasarkan matric
        $stmt = $conn->prepare("SELECT * FROM users WHERE matric = ?");
        $stmt->bind_param("s", $matric);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                // Set session login
                $_SESSION['logged_in'] = true;
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['matric'] = $user['matric'];
                header("Location: user.php"); // Redirect ke halaman user
                exit();
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "No user found with that Matric.";
        }

        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">User Login</h1>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <div class="mb-3">
                <label for="matric" class="form-label">Matric:</label>
                <input type="text" class="form-control" id="matric" name="matric" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            <a href="register.php" class="btn btn-link">Register here if you have not.</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
