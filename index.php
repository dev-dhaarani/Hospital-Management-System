<?php include 'footer.php'; ?>

<?php
session_start();
include 'db.php'; // Ensure this file connects to your database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure the connection exists
    if (!$conn) {
        die("❌ Database Connection Failed: " . mysqli_connect_error());
    }

    // Secure input handling
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = trim($_POST['password']); // Don't escape passwords

    // Debugging: Display entered credentials (without exposing real passwords)
    echo "🔍 Username Entered: " . htmlspecialchars($username) . "<br>";

    // Fetch user details securely
    $query = "SELECT * FROM users WHERE username=?";
    $stmt = mysqli_prepare($conn, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    } else {
        die("❌ Query Preparation Failed: " . mysqli_error($conn));
    }

    // Debugging: Check query execution result
    if (!$result) {
        die("❌ Query Execution Failed: " . mysqli_error($conn));
    }

    // Debugging: Check number of rows
    echo "🔍 Rows Found: " . mysqli_num_rows($result) . "<br>";

    if ($result && mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        // Debugging: Show fetched user data (excluding password for security)
        echo "<pre>";
        print_r([
            'id' => $user['id'],
            'username' => $user['username'],
            'email' => $user['email'],
            'role' => $user['role'],
        ]);
        echo "</pre>";

        // Check password
        if ($password === $user['password']) {
            echo "✅ Password Matched!<br>";
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Debugging: Check session values
            echo "🔍 Session Username: " . $_SESSION['username'] . "<br>";
            echo "🔍 Session Role: " . $_SESSION['role'] . "<br>";

            // Redirect based on role
            if ($user['role'] == 'admin') {
                header("Location: dashboard.php");
            } else {
                header("Location: appointments.php");
            }
            exit();
        } else {
            echo "❌ Password did not match<br>";
        }
    } else {
        echo "❌ No user found with this username<br>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Management Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Background Image */
        body {
            background: url('hospital-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Login Box */
        .login-container {
            max-width: 400px;
            background: rgba(255, 255, 255, 0.2); /* Soft Transparent Effect */
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(12px); /* Frosted Glass Effect */
            color: #333; /* Darker text for visibility */
            text-align: center;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        /* Login Heading */
        .login-container h2 {
            color: #222; /* Darker Title */
            font-weight: bold;
            margin-bottom: 20px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }

        /* Input Fields */
        .form-control {
            background: rgba(255, 255, 255, 0.8);
            border: none;
            color: #222;
            font-weight: bold;
        }

        .form-control::placeholder {
            color: #555;
        }

        /* Button */
        .btn-custom {
            background-color: #007bff;
            border: none;
            padding: 10px;
            width: 100%;
            font-size: 16px;
            font-weight: bold;
            color: white;
            border-radius: 5px;
            transition: all 0.3s ease-in-out;
        }

        .btn-custom:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>🔐 Hospital Login</h2>
    <form method="POST">
        <div class="mb-3">
            <input type="text" name="username" class="form-control" placeholder="👤 Username" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="🔒 Password" required>
        </div>
        <button type="submit" class="btn btn-custom">Login</button>
    </form>
</div>

</body>
</html>
