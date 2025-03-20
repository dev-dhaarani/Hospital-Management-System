<?php
include 'db.php';
session_start();

// Check if user is logged in and has admin privileges
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Get patient ID from URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: patients.php");
    exit();
}

$patient_id = intval($_GET['id']);

// Fetch patient details from the database
$query = "SELECT * FROM patients WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: patients.php");
    exit();
}

$patient = $result->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $medical_history = $_POST['medical_history'];

    $update_query = "UPDATE patients SET name = ?, age = ?, gender = ?, phone = ?, email = ?, address = ?, medical_history = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("sisssssi", $name, $age, $gender, $phone, $email, $address, $medical_history, $patient_id);

    if ($update_stmt->execute()) {
        echo "<script>alert('Patient details updated successfully!'); window.location.href='patients.php';</script>";
    } else {
        echo "<script>alert('Error updating patient details. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Patient</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: url('hospital-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            width: 50%;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Patient</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($patient['name']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Age</label>
            <input type="number" name="age" class="form-control" value="<?php echo htmlspecialchars($patient['age']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Gender</label>
            <select name="gender" class="form-control" required>
                <option value="Male" <?php if ($patient['gender'] === 'Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if ($patient['gender'] === 'Female') echo 'selected'; ?>>Female</option>
                <option value="Other" <?php if ($patient['gender'] === 'Other') echo 'selected'; ?>>Other</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($patient['phone']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($patient['email']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-control" required><?php echo htmlspecialchars($patient['address']); ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Medical History</label>
            <textarea name="medical_history" class="form-control" required><?php echo htmlspecialchars($patient['medical_history']); ?></textarea>
        </div>
        <button type="submit" class="btn btn-success w-100">Update Patient</button>
        <a href="patients.php" class="btn btn-secondary w-100 mt-2">Cancel</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
