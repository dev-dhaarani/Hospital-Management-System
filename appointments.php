<?php
include 'db.php';

// Fetch all appointments with doctor names
$result = mysqli_query($conn, "SELECT appointments.*, doctors.name AS doctor_name FROM appointments 
                               JOIN doctors ON appointments.doctor_id = doctors.id 
                               ORDER BY appointment_date DESC");

// Handle status update request (if received)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['appointment_id']) && isset($_POST['status'])) {
    $appointment_id = mysqli_real_escape_string($conn, $_POST['appointment_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Update the status in the database
    $query = "UPDATE appointments SET status='$status' WHERE id='$appointment_id'";
    if (mysqli_query($conn, $query)) {
        echo json_encode(["success" => true]);
        exit;
    } else {
        echo json_encode(["success" => false]);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Appointments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body style="background: url('hospital-bg.jpg') no-repeat center center fixed; background-size: cover;">

<div class="container mt-4">
    <h2 class="text-center text-white mb-4">📅 Manage Appointments</h2>
    
    <table class="table table-striped table-bordered bg-white">
        <thead class="table-dark">
            <tr>
                <th>Patient Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Doctor</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= htmlspecialchars($row['patient_name']); ?></td>
                <td><?= htmlspecialchars($row['patient_email']); ?></td>
                <td><?= htmlspecialchars($row['patient_phone']); ?></td>
                <td><?= htmlspecialchars($row['doctor_name']); ?></td>
                <td><?= htmlspecialchars($row['appointment_date']); ?></td>
                <td><?= htmlspecialchars($row['appointment_time']); ?></td>
                <td>
                    <span class="badge <?= ($row['status'] == 'Approved') ? 'bg-success' : (($row['status'] == 'Denied') ? 'bg-danger' : 'bg-warning'); ?>">
                        <?= $row['status']; ?>
                    </span>
                </td>
                <td>
                    <?php if ($row['status'] == 'Pending'): ?>
                        <button class="btn btn-success btn-sm update-status" data-id="<?= $row['id']; ?>" data-status="Approved">✅ Approve</button>
                        <button class="btn btn-danger btn-sm update-status" data-id="<?= $row['id']; ?>" data-status="Denied">❌ Deny</button>
                    <?php else: ?>
                        <span class="text-muted">No Actions</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function(){
        $(".update-status").click(function(){
            var appointment_id = $(this).data("id");
            var status = $(this).data("status");

            $.post("appointments.php", { appointment_id: appointment_id, status: status }, function(response){
                var result = JSON.parse(response);
                if(result.success) {
                    location.reload(); // Reload page after status change
                } else {
                    alert("Error updating appointment status!");
                }
            });
        });
    });
</script>

</body>
</html>
