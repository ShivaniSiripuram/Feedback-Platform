<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$name = $_SESSION['name'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product = $_POST['product_name'] ?? '';
    $category = $_POST['category'] ?? '';
    $rating = intval($_POST['rating'] ?? 0);
    $comment = $_POST['comment'] ?? '';

    if (empty($product) || empty($category) || empty($comment) || $rating < 1 || $rating > 5) {
        die("Invalid input. Please go back and try again.");
    }

    $conn = new mysqli('localhost', 'root', '', 'feedback_platform'); // Update DB name
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO product_feedback (user_name, product_name, category, rating, comment) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sssis", $name, $product, $category, $rating, $comment);
    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();

    echo "<script>alert('Feedback submitted successfully!'); window.location.href='feedback.php';</script>";
    exit();
} else {
    echo "Invalid Request";
}
