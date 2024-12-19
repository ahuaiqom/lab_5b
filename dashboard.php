<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php"); // Redirect ke login jika belum login
    exit();
}

echo "<h1>Welcome, " . htmlspecialchars($_SESSION['user_name']) . "!</h1>";
echo "<p>Role: " . htmlspecialchars($_SESSION['user_role']) . "</p>";
echo "<a href='logout.php'>Logout</a>";
?>
