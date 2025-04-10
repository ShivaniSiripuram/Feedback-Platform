<?php
require_once 'config.php';

// Get Google Auth URL
$login_url = $client->createAuthUrl();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login with Google</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('collage-customer-experience-concept.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(8px);
            padding: 40px 50px;
            border-radius: 12px;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
            width: 90%;
        }

        .login-container h2 {
            margin-bottom: 30px;
            color: #333;
        }

        a.login-btn {
            display: inline-block;
            background-color: #4285F4;
            color: white;
            padding: 12px 30px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        a.login-btn:hover {
            background-color: #3367D6;
            transform: translateY(-2px);
        }

        a.login-btn:active {
            transform: scale(0.98);
        }

        @media (max-width: 500px) {
            .login-container {
                padding: 30px 20px;
            }

            a.login-btn {
                font-size: 16px;
                padding: 10px 20px;
            }
        }
    </style>
</head>
<body>
    <div style="position: absolute; top: 30px; width: 100%; text-align: center;">
        <h1 style="color: white; text-shadow: 2px 2px 4px rgba(0,0,0,0.6); font-size: 36px;">
            Welcome to Feedback Platform
        </h1>
    </div>

    <div class="login-container">
        <h2>Login to Feedback Platform</h2>
        <a class="login-btn" href="<?= htmlspecialchars($login_url) ?>">Login with Google</a>
    </div>
</body>

</html>
