<?php
include 'db.php';
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Get doctor ID from URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: doctors.php");
    exit();
}

$doctor_id = $_GET['id'];

// Fetch doctor details from the database
$query = "SELECT * FROM doctors WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: doctors.php");
    exit();
}

$doctor = $result->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $specialization = $_POST['specialization'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    $update_query = "UPDATE doctors SET name = ?, specialization = ?, phone = ?, email = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("ssssi", $name, $specialization, $phone, $email, $doctor_id);

    if ($update_stmt->execute()) {
        echo "<script>alert('Doctor details updated successfully!'); window.location.href='doctors.php';</script>";
    } else {
        echo "<script>alert('Error updating doctor details. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Doctor</title>
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
    <h2>Edit Doctor</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Doctor Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($doctor['name']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Specialization</label>
            <input type="text" name="specialization" class="form-control" value="<?php echo htmlspecialchars($doctor['specialization']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($doctor['phone']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($doctor['email']); ?>" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Update Doctor</button>
        <a href="doctors.php" class="btn btn-secondary w-100 mt-2">Cancel</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
