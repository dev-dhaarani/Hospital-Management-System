<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital_db";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define the SQL query to retrieve appointment data
$sql = "SELECT appointment_id, patient_name, doctor_name, appointment_date, appointment_time, status FROM appointments";

// Execute the query
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Output data of each row
    echo "<table border='1'>
            <tr>
                <th>Appointment ID</th>
                <th>Patient Name</th>
                <th>Doctor Name</th>
                <th>Appointment Date</th>
                <th>Appointment Time</th>
                <th>Status</th>
            </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["appointment_id"] . "</td>
                <td>" . $row["patient_name"] . "</td>
                <td>" . $row["doctor_name"] . "</td>
                <td>" . $row["appointment_date"] . "</td>
                <td>" . $row["appointment_time"] . "</td>
                <td>" . $row["status"] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Close the database connection
$conn->close();
?>
