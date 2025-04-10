<?php
// Database connection variables
$host = 'localhost';  // Use 'localhost' for local server
$user = 'root';       // Default username for XAMPP
$password = '';       // Default password for XAMPP
$database = 'Your database name'; // Your database name

// Create connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else {
    echo "hello";
}
?>

