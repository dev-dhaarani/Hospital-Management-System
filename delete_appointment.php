<?php
include 'db.php';

// Check if user is logged in and is an admin or doctor
if (!isset($_SESSION['username']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'doctor')) {
    echo "<script>alert('⚠️ Unauthorized Access!'); window.location='login.php';</script>";
    exit();
}

// Get Appointment ID from URL
if (isset($_GET['id'])) {
    $appointment_id = intval($_GET['id']);

    // Delete appointment from database
    $query = "DELETE FROM appointments WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $appointment_id);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Appointment Deleted Successfully!'); window.location='appointments.php';</script>";
    } else {
        echo "<script>alert('❌ Error Deleting Appointment!'); window.location='appointments.php';</script>";
    }
    
    $stmt->close();
} else {
    echo "<script>alert('⚠️ Invalid Request!'); window.location='appointments.php';</script>";
}

$conn->close();
?>
