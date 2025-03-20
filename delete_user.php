<?php
include 'db.php';
session_start();

// Check if user is logged in and has admin privileges
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('❌ Access Denied! Only Admins can delete users.'); window.location='admin_users.php';</script>";
    exit();
}

// Check if user ID is provided
if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']); // Ensure it's a valid integer

    // Prevent the admin from deleting themselves
    if ($user_id == $_SESSION['user_id']) {
        echo "<script>alert('⚠️ You cannot delete your own account!'); window.location='admin_users.php';</script>";
        exit();
    }

    // Delete user from the database
    $query = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('✅ User deleted successfully!'); window.location='admin_users.php';</script>";
    } else {
        echo "<script>alert('❌ Error deleting user.'); window.location='admin_users.php';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('❌ Invalid Request. No user ID provided.'); window.location='admin_users.php';</script>";
}

$conn->close();
?>
