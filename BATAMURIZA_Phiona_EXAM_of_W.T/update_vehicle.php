<?php
include('db_connection.php');

// Check if VehicleID is set
if (isset($_REQUEST['VehicleID'])) {
    $vehicle_id = $_REQUEST['VehicleID'];

    // Prepare statement with parameterized query to prevent SQL injection (security improvement)
    $stmt = $connection->prepare("SELECT * FROM vehicle WHERE VehicleID=?");
    $stmt->bind_param("i", $vehicle_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $driver_id = $row['DriverID'];
        $vehicle_type = $row['VehicleType'];
        $plate_number = $row['PlateNumber'];
        $year = $row['Year'];
    } else {
        echo "Vehicle not found.";
    }

    $stmt->close(); // Close the statement after use
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Vehicle Information</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
<center>
    <!-- Update vehicle information form -->
    <h2><u>Update Vehicle Information</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="driver_id">Driver ID:</label>
        <input type="number" name="driver_id" value="<?php echo isset($driver_id) ? $driver_id : ''; ?>">
        <br><br>

        <label for="vehicle_type">Vehicle Type:</label>
        <input type="text" name="vehicle_type" value="<?php echo isset($vehicle_type) ? $vehicle_type : ''; ?>">
        <br><br>

        <label for="plate_number">Plate Number:</label>
        <input type="text" name="plate_number" value="<?php echo isset($plate_number) ? $plate_number : ''; ?>">
        <br><br>

        <label for="year">Year:</label>
        <input type="text" name="year" value="<?php echo isset($year) ? $year : ''; ?>">
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
    $vehicle_type = $_POST['vehicle_type'];
    $plate_number = $_POST['plate_number'];
    $year = $_POST['year'];

    // Update the vehicle in the database (prepared statement again for security)
    $stmt = $connection->prepare("UPDATE vehicle SET DriverID=?, VehicleType=?, PlateNumber=?, Year=? WHERE VehicleID=?");
    $stmt->bind_param("isssi", $driver_id, $vehicle_type, $plate_number, $year, $vehicle_id);
    $stmt->execute();

    // Redirect to appropriate page after update
    header('Location: vehicle.php');
    exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
