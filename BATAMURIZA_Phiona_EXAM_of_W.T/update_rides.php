<?php
include('db_connection.php');

// Check if RideID is set
if (isset($_REQUEST['RideID'])) {
    $ride_id = $_REQUEST['RideID'];

    // Prepare statement with parameterized query to prevent SQL injection (security improvement)
    $stmt = $connection->prepare("SELECT * FROM rides WHERE RideID=?");
    $stmt->bind_param("i", $ride_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $driver_id = $row['DriverID'];
        $departure_location = $row['DepartureLocation'];
        $destination = $row['Destination'];
        $departure_time = $row['DepartureTime'];
        $available_seats = $row['AvailableSeats'];
    } else {
        echo "Ride not found.";
    }

    $stmt->close(); // Close the statement after use
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Ride Information</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
<center>
    <!-- Update ride information form -->
    <h2><u>Update Ride Information</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="driver_id">Driver ID:</label>
        <input type="number" name="driver_id" value="<?php echo isset($driver_id) ? $driver_id : ''; ?>">
        <br><br>

        <label for="departure_location">Departure Location:</label>
        <input type="text" name="departure_location" value="<?php echo isset($departure_location) ? $departure_location : ''; ?>">
        <br><br>

        <label for="destination">Destination:</label>
        <input type="text" name="destination" value="<?php echo isset($destination) ? $destination : ''; ?>">
        <br><br>

        <label for="departure_time">Departure Time:</label>
        <input type="datetime-local" name="departure_time" value="<?php echo isset($departure_time) ? $departure_time : ''; ?>">
        <br><br>

        <label for="available_seats">Available Seats:</label>
        <input type="number" name="available_seats" value="<?php echo isset($available_seats) ? $available_seats : ''; ?>">
        <br><br>

        <input type="submit" name="up" value="Update">
    </form>
</center>
</body>
</html>

<?php
if (isset($_POST['up'])) {
    // Retrieve updated values from form
    $driver_id = $_POST['driver_id'];
    $departure_location = $_POST['departure_location'];
    $destination = $_POST['destination'];
    $departure_time = $_POST['departure_time'];
    $available_seats = $_POST['available_seats'];

    // Update the ride in the database (prepared statement again for security)
    $stmt = $connection->prepare("UPDATE rides SET DriverID=?, DepartureLocation=?, Destination=?, DepartureTime=?, AvailableSeats=? WHERE RideID=?");
    $stmt->bind_param("issisi", $driver_id, $departure_location, $destination, $departure_time, $available_seats, $ride_id);
    $stmt->execute();

    // Redirect to appropriate page after update
    header('Location: rides.php');
    exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
