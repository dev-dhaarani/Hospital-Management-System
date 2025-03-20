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
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    
    // Insert into database
    $query = "INSERT INTO patients (name, age, gender, email, phone, address) VALUES ('$name', '$age', '$gender', '$email', '$phone', '$address')";
    
    if ($conn->query($query) === TRUE) {
        $message = "<div class='alert alert-success'>Patient added successfully!</div>";
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
    <title>Add Patient - MediSys</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background: url('hospital-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 600px;
            margin: 80px auto;
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
    <h2>Add Patient</h2>
    <?= $message; ?>
    <form method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Patient Name</label>
            <input type="text" class="form-control" name="name" id="name" required>
        </div>

        <div class="mb-3">
            <label for="age" class="form-label">Age</label>
            <input type="number" class="form-control" name="age" id="age" required>
        </div>

        <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <select class="form-control" name="gender" id="gender" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="email" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" name="phone" id="phone" required>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea class="form-control" name="address" id="address" rows="3" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100">Add Patient</button>
        <a href="dashboard.php" class="btn btn-secondary w-100 mt-2">Back to Dashboard</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
