<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_name = trim($_POST['patient_name']);
    $doctor_id = $_POST['doctor_id'];
    $appointment_date = $_POST['appointment_date'];
    $appointment_time = $_POST['appointment_time'];
    $status = "Pending";

    // Validate inputs
    if (empty($patient_name) || empty($doctor_id) || empty($appointment_date) || empty($appointment_time)) {
        $_SESSION['error'] = "All fields are required!";
        header("Location: book_appointment.php");
        exit;
    }

    // Insert appointment into database
    $query = "INSERT INTO appointments (patient_name, doctor_id, appointment_date, appointment_time, status) 
              VALUES (?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sisss", $patient_name, $doctor_id, $appointment_date, $appointment_time, $status);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Appointment booked successfully!";
        header("Location: appointments.php");
        exit;
    } else {
        $_SESSION['error'] = "Error booking appointment!";
        header("Location: book_appointment.php");
        exit;
    }
}

?>
