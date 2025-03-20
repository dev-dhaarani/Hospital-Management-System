<?php
session_start();
include 'db.php';

// Redirect to login if user is not authenticated
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $specialization = $_POST['specialization'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    
    // Insert into database
    $query = "INSERT INTO doctors (name, specialization, email, phone) VALUES ('$name', '$specialization', '$email', '$phone')";
    
    if ($conn->query($query) === TRUE) {
        $message = "<div class='alert alert-success'>Doctor added successfully!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Doctor - MediSys</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background: url('hospital-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 500px;
            margin: 100px auto;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }
        h2 {
            text-align: center;
            color: #007BFF;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Add Doctor</h2>
    <?= $message; ?>
    <form method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Doctor Name</label>
            <input type="text" class="form-control" name="name" id="name" required>
        </div>

        <div class="mb-3">
            <label for="specialization" class="form-label">Specialization</label>
            <input type="text" class="form-control" name="specialization" id="specialization" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="email" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" name="phone" id="phone" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Add Doctor</button>
        <a href="dashboard.php" class="btn btn-secondary w-100 mt-2">Back to Dashboard</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
