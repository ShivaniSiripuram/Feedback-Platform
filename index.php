<?php
session_start();

if (!isset($_SESSION['user_email'])) {
    header('Location: login.php');
    exit;
}

echo "<h2>Welcome, " . $_SESSION['user_name'] . "</h2>";
echo "<p>You are logged in as " . $_SESSION['user_email'] . "</p>";
echo "<a href='logout.php'>Logout</a>";
?>
