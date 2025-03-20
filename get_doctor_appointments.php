<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db.php";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming the doctor's ID is passed via a GET parameter
$doctor_id = isset($_GET['doctor_id']) ? intval($_GET['doctor_id']) : 0;

// Validate doctor_id
if ($doctor_id <= 0) {
    die("Invalid doctor ID.");
}

// Define the SQL query to retrieve appointments for the specific doctor
$sql = "SELECT a.appointment_id, p.patient_name, a.appointment_date, a.appointment_time, a.status
        FROM appointments a
        JOIN patients p ON a.patient_id = p.patient_id
        WHERE a.doctor_id = ?
        ORDER BY a.appointment_date, a.appointment_time";

// Prepare and bind
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $doctor_id);

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Check if there are results
if ($result->num_rows > 0) {
    // Output data of each row
    echo "<table border='1'>
            <tr>
                <th>Appointment ID</th>
                <th>Patient Name</th>
                <th>Appointment Date</th>
                <th>Appointment Time</th>
                <th>Status</th>
            </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row["appointment_id"]) . "</td>
                <td>" . htmlspecialchars($row["patient_name"]) . "</td>
                <td>" . htmlspecialchars($row["appointment_date"]) . "</td>
                <td>" . htmlspecialchars($row["appointment_time"]) . "</td>
                <td>" . htmlspecialchars($row["status"]) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No appointments found for this doctor.";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
