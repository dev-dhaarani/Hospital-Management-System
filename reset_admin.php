<?php
session_start();
include __DIR__ . '/db.php'; // Ensure correct database connection

// CSRF Token Generation
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Handle Password Reset Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error'] = "Invalid request!";
        header("Location: reset_admin.php");
        exit();
    }

    $admin_email = mysqli_real_escape_string($conn, $_POST['email']);
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate inputs
    if (empty($admin_email) || empty($new_password) || empty($confirm_password)) {
        $_SESSION['error'] = "All fields are required.";
    } elseif ($new_password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match!";
    } elseif (strlen($new_password) < 6) {
        $_SESSION['error'] = "Password must be at least 6 characters long!";
    } else {
        // Hash the new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update admin password
        $query = "UPDATE users SET password = ? WHERE email = ? AND role = 'admin'";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ss", $hashed_password, $admin_email);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = "Admin password reset successfully!";
        } else {
            $_SESSION['error'] = "Error resetting password.";
        }

        mysqli_stmt_close($stmt);
    }

    header("Location: reset_admin.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Admin Password | MediSys</title>
    <link rel="stylesheet" href="styles.css"> <!-- External CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 40%;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #007bff;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
        }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .btn {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background: #0056b3;
        }
        .message {
            text-align: center;
            padding: 10px;
            border-radius: 5px;
        }
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Reset Admin Password</h2>

    <?php if (isset($_SESSION['error'])) { ?>
        <p class="message error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
    <?php } ?>
    
    <?php if (isset($_SESSION['success'])) { ?>
        <p class="message success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
    <?php } ?>

    <form action="reset_admin.php" method="POST">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        
        <div class="form-group">
            <label>Admin Email:</label>
            <input type="email" name="email" required>
        </div>
        <div class="form-group">
            <label>New Password:</label>
            <input type="password" name="password" required>
        </div>
        <div class="form-group">
            <label>Confirm Password:</label>
            <input type="password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn">Reset Password</button>
    </form>

    <p style="text-align:center; margin-top:15px;">
        <a href="login.php">Back to Login</a>
    </p>
</div>

</body>
</html>
