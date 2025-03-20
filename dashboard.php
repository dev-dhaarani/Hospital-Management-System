<?php
session_start();
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    echo "<script>alert('❌ Access Denied! Please Login First.'); window.location='login.php';</script>";
    exit();
}

// Store session values in variables
$username = $_SESSION['username'];
$role = $_SESSION['role'];
?>

<!-- Footer Include (Move outside PHP block) -->
<?php include 'footer.php'; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Hospital Management</title>
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
            flex-direction: column;
        }

        /* Dashboard Container */
        .dashboard-container {
            width: 80%;
            max-width: 900px;
            background: rgba(255, 255, 255, 0.2); /* Soft Transparent */
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(12px); /* Frosted Glass Effect */
            color: #333;
            text-align: center;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        /* Heading */
        .dashboard-container h2 {
            color: #222;
            font-weight: bold;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }

        /* Dashboard Buttons */
        .btn-dashboard {
            display: block;
            background: #007bff;
            color: white;
            font-size: 18px;
            font-weight: bold;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            transition: all 0.3s ease-in-out;
            text-decoration: none;
        }

        .btn-dashboard:hover {
            background: #0056b3;
            transform: scale(1.05);
        }

        /* Logout Button */
        .btn-logout {
            background: #dc3545;
            color: white;
        }

        .btn-logout:hover {
            background: #b52a37;
        }
    </style>
</head>
<body>

<div class="dashboard-container">
    <h2>🏥 Welcome, <?= ucfirst($username); ?>!</h2>
    <p><strong>Role:</strong> <?= ucfirst($role); ?></p>

    <!-- Dashboard Navigation Buttons -->
    <a href="appointments.php" class="btn btn-dashboard">📅 Manage Appointments</a>
    <a href="patients.php" class="btn btn-dashboard">👨‍⚕️ View Patients</a>
    <a href="doctors.php" class="btn btn-dashboard">🩺 View Doctors</a>
    <a href="invoices.php" class="btn btn-dashboard">📜 Billing & Invoices</a>
    <a href="admin_users.php" class="btn btn-dashboard">⚙️ Manage Users</a>

    <!-- Logout Button -->
    <a href="logout.php" class="btn btn-dashboard btn-logout">🚪 Logout</a>
</div>

</body>
</html>
