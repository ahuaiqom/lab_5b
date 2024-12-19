<?php
include_once 'Database.php';

$database = new Database();
$conn = $database->getConnection();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">User List</h1>
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
                // Query untuk mendapatkan data pengguna
                $query = "SELECT matric, name, role FROM users";
                $result = $conn->query($query);

                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Sanitasi data sebelum ditampilkan
                        $matric = htmlspecialchars($row['matric']);
                        $name = htmlspecialchars($row['name']);
                        $role = htmlspecialchars($row['role']);

                        echo "<tr>
                                <td>$matric</td>
                                <td>$name</td>
                                <td>$role</td>
                                <td>
                                    <a href='update.php?matric=$matric' class='btn btn-warning btn-sm'>Update</a>
                                    <a href='delete.php?matric=$matric' class='btn btn-danger btn-sm'>Delete</a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>No users found</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
