<?php
session_start();
include 'db.php'; // Ensure this file exists and is correctly set up

// Destroy the session
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging Out...</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link your CSS file -->
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }
        .logout-container {
            text-align: center;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .spinner {
            border: 5px solid rgba(0, 0, 0, 0.1);
            border-left-color: #3498db;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        p {
            font-size: 18px;
            color: #333;
        }
    </style>
</head>
<body>

<div class="logout-container">
    <div class="spinner"></div>
    <p>You have been logged out successfully.</p>
    <p>Redirecting to login page...</p>
</div>

<script>
    setTimeout(function() {
        window.location.href = "login.php";
    }, 3000); // Redirect after 3 seconds
</script>

</body>
</html>
