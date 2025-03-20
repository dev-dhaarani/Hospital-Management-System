<?php
include 'db.php';
session_start();

// Check if user is logged in and has admin privileges
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('❌ Access Denied! Only Admins can delete invoices.'); window.location='invoices.php';</script>";
    exit();
}

// Check if invoice_id is provided
if (isset($_GET['id'])) {
    $invoice_id = intval($_GET['id']); // Ensure it's a valid integer

    // Delete invoice from the database
    $query = "DELETE FROM invoices WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $invoice_id);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Invoice deleted successfully!'); window.location='invoices.php';</script>";
    } else {
        echo "<script>alert('❌ Error deleting invoice.'); window.location='invoices.php';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('❌ Invalid Request. No invoice ID provided.'); window.location='invoices.php';</script>";
}

$conn->close();
?>
