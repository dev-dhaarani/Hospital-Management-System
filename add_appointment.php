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
    $patient_id = $_POST['patient_id'];
    $doctor_id = $_POST['doctor_id'];
    $date = $_POST['appointment_date'];
    $time = $_POST['appointment_time'];
    
    // Insert into database
    $query = "INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time, status) VALUES ('$patient_id', '$doctor_id', '$date', '$time', 'Pending')";
    
    if ($conn->query($query) === TRUE) {
        $message = "<div class='alert alert-success'>Appointment booked successfully!</div>";
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
    <title>Add Appointment - MediSys</title>
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
    <h2>Book an Appointment</h2>
    <?= $message; ?>
    <form method="post">
        <div class="mb-3">
            <label for="patient_id" class="form-label">Patient ID</label>
            <input type="text" class="form-control" name="patient_id" id="patient_id" required>
        </div>

        <div class="mb-3">
            <label for="doctor_id" class="form-label">Doctor ID</label>
            <input type="text" class="form-control" name="doctor_id" id="doctor_id" required>
        </div>

        <div class="mb-3">
            <label for="appointment_date" class="form-label">Appointment Date</label>
            <input type="date" class="form-control" name="appointment_date" id="appointment_date" required>
        </div>

        <div class="mb-3">
            <label for="appointment_time" class="form-label">Appointment Time</label>
            <input type="time" class="form-control" name="appointment_time" id="appointment_time" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Book Appointment</button>
        <a href="dashboard.php" class="btn btn-secondary w-100 mt-2">Back to Dashboard</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
