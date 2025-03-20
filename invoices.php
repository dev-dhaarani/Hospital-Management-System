<?php
include 'db.php';

$query = "SELECT * FROM invoices";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoices</title>
    <style>
        body {
            background-image: url('hospital_invoice_bg.jpg');
            background-size: cover;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 80%;
            margin: auto;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .btn {
            padding: 8px 12px;
            text-decoration: none;
            color: white;
            border-radius: 5px;
            margin-right: 5px;
        }
        .btn-update { background: #28a745; }
        .btn-delete { background: #dc3545; }
        .btn-generate { background: #007bff; }
    </style>
</head>
<body>

<div class="container">
    <h2>Invoice Management</h2>
    <table>
        <tr>
            <th>Patient Name</th>
            <th>Contact</th>
            <th>Doctor</th>
            <th>Treatment</th>
            <th>Amount</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['patient_name']; ?></td>
                <td><?php echo $row['contact']; ?></td>
                <td><?php echo $row['doctor']; ?></td>
                <td><?php echo $row['treatment']; ?></td>
                <td><?php echo $row['amount']; ?></td>
                <td><?php echo $row['date']; ?></td>
                <td>
                    <a href="generate_invoice.php?id=<?php echo $row['id']; ?>" class="btn btn-generate">Generate PDF</a>
                    <a href="update_invoice.php?id=<?php echo $row['id']; ?>" class="btn btn-update">Update</a>
                    <a href="delete_invoice.php?id=<?php echo $row['id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure?');">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>

</body>
</html>
