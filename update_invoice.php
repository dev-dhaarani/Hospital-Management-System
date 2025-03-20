<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM invoices WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $invoice = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_name = $_POST['patient_name'];
    $contact = $_POST['contact'];
    $doctor = $_POST['doctor'];
    $treatment = $_POST['treatment'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];

    $query = "UPDATE invoices SET 
              patient_name='$patient_name', contact='$contact', doctor='$doctor',
              treatment='$treatment', amount='$amount', date='$date' WHERE id=$id";

    if (mysqli_query($conn, $query)) {
        echo "Invoice Updated!";
        header("Location: invoices.php");
    }
}
?>

<form method="post">
    <input type="text" name="patient_name" value="<?php echo $invoice['patient_name']; ?>" required>
    <input type="text" name="contact" value="<?php echo $invoice['contact']; ?>" required>
    <input type="text" name="doctor" value="<?php echo $invoice['doctor']; ?>" required>
    <input type="text" name="treatment" value="<?php echo $invoice['treatment']; ?>" required>
    <input type="number" name="amount" value="<?php echo $invoice['amount']; ?>" required>
    <input type="date" name="date" value="<?php echo $invoice['date']; ?>" required>
    <button type="submit">Update Invoice</button>
</form>
