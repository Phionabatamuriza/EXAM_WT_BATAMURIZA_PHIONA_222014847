<?php
include('db_connection.php');

// Check if PaymentID is set
if (isset($_REQUEST['PaymentID'])) {
    $payment_id = $_REQUEST['PaymentID'];

    // Prepare statement with parameterized query to prevent SQL injection (security improvement)
    $stmt = $connection->prepare("SELECT * FROM payments WHERE PaymentID=?");
    $stmt->bind_param("i", $payment_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $booking_id = $row['BookingID'];
        $amount = $row['Amount'];
        $payment_method = $row['PaymentMethod'];
        $status = $row['Status'];
    } else {
        echo "Payment not found.";
    }

    $stmt->close(); // Close the statement after use
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Payment Information</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update payment information form -->
        <h2><u>Update Payment Information</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <label for="booking_id">Booking ID:</label>
            <input type="number" name="booking_id" value="<?php echo isset($booking_id) ? $booking_id : ''; ?>">
            <br><br>

            <label for="amount">Amount:</label>
            <input type="number" name="amount" value="<?php echo isset($amount) ? $amount : ''; ?>">
            <br><br>

            <label for="payment_method">Payment Method:</label>
            <input type="text" name="payment_method" value="<?php echo isset($payment_method) ? $payment_method : ''; ?>">
            <br><br>

            <label for="status">Status:</label>
            <select name="status">
                <option value="pending" <?php if(isset($status) && $status == "pending") echo "selected"; ?>>Pending</option>
                <option value="failed" <?php if(isset($status) && $status == "failed") echo "selected"; ?>>Failed</option>
                <option value="completed" <?php if(isset($status) && $status == "completed") echo "selected"; ?>>Completed</option>
            </select>

            <input type="submit" name="up" value="Update">
        </form>
    </center>
</body>
</html>

<?php
if (isset($_POST['up'])) {
    // Retrieve updated values from form
    $booking_id = $_POST['booking_id'];
    $amount = $_POST['amount'];
    $payment_method = $_POST['payment_method'];
    $status = $_POST['status'];

    // Update the payment in the database (prepared statement again for security)
    $stmt = $connection->prepare("UPDATE payments SET BookingID=?, Amount=?, PaymentMethod=?, Status=? WHERE PaymentID=?");
    $stmt->bind_param("idssi", $booking_id, $amount, $payment_method, $status, $payment_id);
    $stmt->execute();

    // Redirect to appropriate page after update
    header('Location: payments.php');
    exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
