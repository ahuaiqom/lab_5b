<?php
include_once 'Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Koneksi database
    $database = new Database();
    $conn = $database->getConnection();

    // Validasi dan filter input
    $matric = htmlspecialchars(trim($_POST['matric']));
    $name = htmlspecialchars(trim($_POST['name']));
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash password
    $role = htmlspecialchars(trim($_POST['role']));

    // Validasi input kosong
    if (empty($matric) || empty($name) || empty($password) || empty($role)) {
        echo "All fields are required!";
    } else {
        // Query untuk memasukkan data
        $stmt = $conn->prepare("INSERT INTO users (matric, name, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $matric, $name, $password, $role);

        if ($stmt->execute()) {
            echo "Registration successful! <a href='login.php'>Login here</a>";
        } else {
            echo "Error: " . $stmt->error;
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
    <title>Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">User Registration</h1>
        <!-- Form Registrasi -->
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <div class="mb-3">
                <label for="matric" class="form-label">Matric:</label>
                <input type="text" class="form-control" id="matric" name="matric" maxlength="10" required>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role:</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="">Please select</option>
                    <option value="lecturer">Lecturer</option>
                    <option value="student">Student</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
