<?php
include('db_connection.php');

// Check if PassengerID is set
if (isset($_REQUEST['PassengerID'])) {
    $passenger_id = $_REQUEST['PassengerID'];

    // Prepare statement with parameterized query to prevent SQL injection (security improvement)
    $stmt = $connection->prepare("SELECT * FROM passengers WHERE PassengerID=?");
    $stmt->bind_param("i", $passenger_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['UserID'];
        $ride_id = $row['RideID'];
    } else {
        echo "Passenger not found.";
    }

    $stmt->close(); // Close the statement after use
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Passenger Information</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update passenger information form -->
        <h2><u>Update Passenger Information</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <label for="user_id">User ID:</label>
            <input type="text" name="user_id" value="<?php echo isset($user_id) ? $user_id : ''; ?>">
            <br><br>

            <label for="ride_id">Ride ID:</label>
            <input type="text" name="ride_id" value="<?php echo isset($ride_id) ? $ride_id : ''; ?>">
            <br><br>

            <input type="submit" name="up" value="Update">
        </form>
    </center>
</body>
</html>

<?php
if (isset($_POST['up'])) {
    // Retrieve updated values from form
    $user_id = $_POST['user_id'];
    $ride_id = $_POST['ride_id'];

    // Update the passenger in the database (prepared statement again for security)
    $stmt = $connection->prepare("UPDATE passengers SET UserID=?, RideID=? WHERE PassengerID=?");
    $stmt->bind_param("iii", $user_id, $ride_id, $passenger_id);
    $stmt->execute();

    // Redirect to appropriate page after update
    header('Location: passengers.php');
    exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
