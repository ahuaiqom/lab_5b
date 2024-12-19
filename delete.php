<?php
include_once 'Database.php';

if (isset($_GET['matric'])) {
    $matric = htmlspecialchars($_GET['matric']);
    $database = new Database();
    $conn = $database->getConnection();

    // Query to delete the user based on matric
    $stmt = $conn->prepare("DELETE FROM users WHERE matric = ?");
    $stmt->bind_param("s", $matric);
    
    if ($stmt->execute()) {
        // Successful deletion
        echo "<script>
                alert('Successfully deleted');
                window.location.href = 'user.php'; // Redirect to user.php
              </script>";
    } else {
        // Error deleting user
        echo "<script>
                alert('Error deleting user');
                window.location.href = 'user.php'; // Redirect to user.php even if there's an error
              </script>";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    header("Location: user.php"); // Redirect if matric is not set
    exit();
}
?>
