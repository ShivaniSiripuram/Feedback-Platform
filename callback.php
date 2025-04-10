<?php
require_once 'config.php';

echo "Step 1: Reached callback.php<br>";

if (isset($_GET['code'])) {
    echo "Step 2: Authorization code received<br>";

    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    if (!isset($token['error'])) {
        echo "Step 3: Token fetched<br>";

        $client->setAccessToken($token['access_token']);
        echo "Step 4: Access token set<br>";

        // Get user info
        $oauth = new Google_Service_Oauth2($client);
        $userInfo = $oauth->userinfo->get();
        echo "Step 5: User info fetched<br>";

        $name = $userInfo->name;
        $email = $userInfo->email;
        $google_id = $userInfo->id;

        // Check if user exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() == 0) {
            // Insert new user with google_id
            $stmt = $pdo->prepare("INSERT INTO users (name, email, google_id) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $google_id]);
        }

        // Start session and store user info
        session_start();
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;

        header('Location: feedback.php'); // Go to feedback form
        exit;
    } else {
        echo "Token error: " . $token['error'];
    }
} else {
    echo "Access denied!";
}
?>
