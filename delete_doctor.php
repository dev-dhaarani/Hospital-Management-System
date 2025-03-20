<?php
include 'db.php';
session_start();

// Check if user is logged in and has admin privileges
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('❌ Access Denied! Only Admins can delete doctors.'); window.location='doctors.php';</script>";
    exit();
}

// Check if doctor_id is provided
if (isset($_GET['id'])) {
    $doctor_id = intval($_GET['id']); // Ensure it's a valid integer

    // Delete doctor from the database
    $query = "DELETE FROM doctors WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $doctor_id);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Doctor deleted successfully!'); window.location='doctors.php';</script>";
    } else {
        echo "<script>alert('❌ Error deleting doctor.'); window.location='doctors.php';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('❌ Invalid Request. No doctor ID provided.'); window.location='doctors.php';</script>";
}

$conn->close();
?>
