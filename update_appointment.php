<?php
session_start();
include __DIR__ . '/db.php'; // Ensure correct database connection

// Check if appointment ID is provided
if (!isset($_GET['id'])) {
    $_SESSION['error'] = "Invalid request!";
    header("Location: appointments.php");
    exit();
}

$appointment_id = intval($_GET['id']);

// Fetch existing appointment details
$query = "SELECT * FROM appointments WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $appointment_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$appointment = mysqli_fetch_assoc($result);

if (!$appointment) {
    $_SESSION['error'] = "Appointment not found!";
    header("Location: appointments.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_date = mysqli_real_escape_string($conn, $_POST['appointment_date']);
    $new_time = mysqli_real_escape_string($conn, $_POST['appointment_time']);
    $new_status = mysqli_real_escape_string($conn, $_POST['status']);

    $update_query = "UPDATE appointments SET appointment_date = ?, appointment_time = ?, status = ? WHERE id = ?";
    $update_stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($update_stmt, "sssi", $new_date, $new_time, $new_status, $appointment_id);

    if (mysqli_stmt_execute($update_stmt)) {
        $_SESSION['success'] = "Appointment updated successfully!";
        header("Location: appointments.php");
        exit();
    } else {
        $_SESSION['error'] = "Error updating appointment.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Appointment | MediSys</title>
    <link rel="stylesheet" href="styles.css"> <!-- External CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
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
        input, select {
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
        .back-btn {
            display: inline-block;
            padding: 10px;
            background: #6c757d;
            color: white;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 10px;
            width: 100%;
        }
        .back-btn:hover {
            background: #5a6268;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Update Appointment</h2>

    <?php if (isset($_SESSION['error'])) { ?>
        <p class="message error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
    <?php } ?>
    
    <?php if (isset($_SESSION['success'])) { ?>
        <p class="message success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
    <?php } ?>

    <form action="update_appointment.php?id=<?php echo $appointment_id; ?>" method="POST">
        <div class="form-group">
            <label>Patient Name:</label>
            <input type="text" value="<?php echo htmlspecialchars($appointment['patient_name']); ?>" disabled>
        </div>
        <div class="form-group">
            <label>Doctor Name:</label>
            <input type="text" value="<?php echo htmlspecialchars($appointment['doctor_name']); ?>" disabled>
        </div>
        <div class="form-group">
            <label>Appointment Date:</label>
            <input type="date" name="appointment_date" value="<?php echo $appointment['appointment_date']; ?>" required>
        </div>
        <div class="form-group">
            <label>Appointment Time:</label>
            <input type="time" name="appointment_time" value="<?php echo $appointment['appointment_time']; ?>" required>
        </div>
        <div class="form-group">
            <label>Status:</label>
            <select name="status">
                <option value="Pending" <?php echo ($appointment['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="Confirmed" <?php echo ($appointment['status'] == 'Confirmed') ? 'selected' : ''; ?>>Confirmed</option>
                <option value="Cancelled" <?php echo ($appointment['status'] == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
            </select>
        </div>
        <button type="submit" class="btn">Update Appointment</button>
    </form>

    <a href="appointments.php" class="back-btn">Go Back</a>
</div>

</body>
</html>
