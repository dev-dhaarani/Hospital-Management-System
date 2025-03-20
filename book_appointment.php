<?php
include 'db.php';

// Fetch doctors for dropdown
$doctorQuery = "SELECT id, name FROM doctors ORDER BY name ASC";
$doctorResult = mysqli_query($conn, $doctorQuery);

// Handle appointment booking
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_name = mysqli_real_escape_string($conn, $_POST['patient_name']);
    $patient_email = mysqli_real_escape_string($conn, $_POST['patient_email']);
    $patient_phone = mysqli_real_escape_string($conn, $_POST['patient_phone']);
    $doctor_id = mysqli_real_escape_string($conn, $_POST['doctor_id']);
    $appointment_date = mysqli_real_escape_string($conn, $_POST['appointment_date']);
    $appointment_time = mysqli_real_escape_string($conn, $_POST['appointment_time']);
    $status = "Pending";

    if (!empty($patient_name) && !empty($patient_email) && !empty($patient_phone) && !empty($doctor_id) && !empty($appointment_date) && !empty($appointment_time)) {
        $query = "INSERT INTO appointments (patient_name, patient_email, patient_phone, doctor_id, appointment_date, appointment_time, status) 
                  VALUES ('$patient_name', '$patient_email', '$patient_phone', '$doctor_id', '$appointment_date', '$appointment_time', '$status')";
        if (mysqli_query($conn, $query)) {
            $success_message = "✅ Appointment booked successfully!";
        } else {
            $error_message = "❌ Error booking appointment!";
        }
    } else {
        $error_message = "⚠️ All fields are required!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('hospital-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            max-width: 500px;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.3);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📅 Book an Appointment</h2>

    <?php if (isset($success_message)): ?>
        <div class="alert alert-success"><?= $success_message; ?></div>
    <?php endif; ?>
    
    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?= $error_message; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Patient Name</label>
            <input type="text" name="patient_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="patient_email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Phone Number</label>
            <input type="text" name="patient_phone" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Select Doctor</label>
            <select name="doctor_id" class="form-select" required>
                <option value="">-- Select Doctor --</option>
                <?php while ($doctor = mysqli_fetch_assoc($doctorResult)): ?>
                    <option value="<?= $doctor['id']; ?>"><?= htmlspecialchars($doctor['name']); ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Appointment Date</label>
            <input type="date" name="appointment_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Appointment Time</label>
            <input type="time" name="appointment_time" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">📅 Book Appointment</button>
        <a href="index.php" class="btn btn-secondary w-100 mt-2">🔙 Back to Home</a>
    </form>
</div>

</body>
</html>
