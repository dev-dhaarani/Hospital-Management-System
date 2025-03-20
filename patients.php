<?php
include __DIR__ . '/db.php'; // Include database connection

// Check if the connection is valid
if (!isset($conn)) {
    die("Database connection error.");
}

// Fetch all patients from the database
$query = "SELECT * FROM patients";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients List | MediSys</title>
    <link rel="stylesheet" href="styles.css"> <!-- External CSS file for better styling -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #007bff;
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
        th {
            background: #007bff;
            color: white;
        }
        tr:hover {
            background: #f1f1f1;
        }
        .btn {
            display: inline-block;
            padding: 8px 12px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }
        .btn:hover {
            background: #218838;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Patients List</h2>
    
    <?php if (mysqli_num_rows($result) > 0) { ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Contact</th>
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo $row['age']; ?></td>
                    <td><?php echo $row['gender']; ?></td>
                    <td><?php echo $row['contact']; ?></td>
                    <td>
                        <a href="edit_patient.php?id=<?php echo $row['id']; ?>" class="btn">Edit</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p>No patients found.</p>
    <?php } ?>
</div>

</body>
</html>
