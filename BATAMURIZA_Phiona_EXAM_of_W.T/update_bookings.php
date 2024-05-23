<?php
include('db_connection.php');

// Check if Booking ID is set
if (isset($_REQUEST['booking_id'])) {
    $booking_id = $_REQUEST['booking_id'];

    // Prepare statement with parameterized query to prevent SQL injection (security improvement)
    $stmt = $connection->prepare("SELECT * FROM bookings WHERE BookingID=?");
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $ride_id = $row['RideID'];
        $passenger_id = $row['PassengerID'];
        $booking_time = $row['BookingTime'];
        $status = $row['Status'];
    } else {
        echo "Booking not found.";
    }

    $stmt->close(); // Close the statement after use
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Booking Information</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update booking information form -->
        <h2><u>Update Booking Information</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <label for="ride_id">Ride ID:</label>
            <input type="text" name="ride_id" value="<?php echo isset($ride_id) ? $ride_id : ''; ?>">
            <br><br>

            <label for="passenger_id">Passenger ID:</label>
            <input type="text" name="passenger_id" value="<?php echo isset($passenger_id) ? $passenger_id : ''; ?>">
            <br><br>

            <label for="booking_time">Booking Time:</label>
            <input type="datetime-local" name="booking_time" value="<?php echo isset($booking_time) ? date('Y-m-d\TH:i', strtotime($booking_time)) : ''; ?>">
            <br><br>

            <label for="status">Status:</label>
            <input type="text" name="status" value="<?php echo isset($status) ? $status : ''; ?>">
            <br><br>

            <input type="submit" name="up" value="Update">
        </form>
    </center>
</body>
</html>

<?php
if (isset($_POST['up'])) {
    // Retrieve updated values from form
    $ride_id = $_POST['ride_id'];
    $passenger_id = $_POST['passenger_id'];
    $booking_time = $_POST['booking_time'];
    $status = $_POST['status'];

    // Update the booking in the database (prepared statement again for security)
    $stmt = $connection->prepare("UPDATE bookings SET RideID=?, PassengerID=?, BookingTime=?, Status=? WHERE BookingID=?");
    $stmt->bind_param("iissi", $ride_id, $passenger_id, $booking_time, $status, $booking_id);
    $stmt->execute();

    // Redirect to appropriate page after update
    header('Location: bookings.php');
    exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
