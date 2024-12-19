<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 5B - Web Page Development using PHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Lab 5B - Web Page Development</h1>

        <!-- Registration Page -->
        <div id="registration" class="mb-5">
            <h2>Registration</h2>
            <form action="register.php" method="POST">
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
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>

        <!-- Display Users -->
        <div id="display-users" class="mb-5">
            <h2>Users</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Matric</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Replace with dynamic PHP code to fetch users from the database
                    $users = [
                        ['matric' => 'A100', 'name' => 'Ahmad', 'role' => 'student'],
                        ['matric' => 'A101', 'name' => 'Abu', 'role' => 'student'],
                    ];

                    foreach ($users as $user) {
                        echo "<tr>
                            <td>{$user['matric']}</td>
                            <td>{$user['name']}</td>
                            <td>{$user['role']}</td>
                            <td>
                                <a href='update.php?matric={$user['matric']}' class='btn btn-warning btn-sm'>Update</a>
                                <a href='delete.php?matric={$user['matric']}' class='btn btn-danger btn-sm'>Delete</a>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Login Page -->
        <div id="login" class="mb-5">
            <h2>Login</h2>
            <form action="login.php" method="POST">
                <div class="mb-3">
                    <label for="login-matric" class="form-label">Matric:</label>
                    <input type="text" class="form-control" id="login-matric" name="matric" required>
                </div>
                <div class="mb-3">
                    <label for="login-password" class="form-label">Password:</label>
                    <input type="password" class="form-control" id="login-password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
                <a href="#registration" class="btn btn-link">Register here if you have not.</a>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
