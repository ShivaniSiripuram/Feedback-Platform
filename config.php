<?php
require_once 'vendor/autoload.php'; // Ensure Google API Client is installed via Composer

// DB config
$host = 'localhost';
$db = 'your db_name';
$user = 'root';
$pass = ''; // Leave empty if no password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}

// Google OAuth config
$client = new Google_Client();
$client->setClientId('YOUR_CLIENT_ID'); // Replace with your actual client ID
$client->setClientSecret('YOUR_CLIENT_SECRET'); // Replace with your actual client secret
$client->setRedirectUri('http://localhost/feedback-platform/callback.php');
$client->addScope('email');
$client->addScope('profile');

