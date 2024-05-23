<?php
include('db_connection.php');

// Check if Driver ID is set
if (isset($_REQUEST['DriverID'])) {
    $driver_id = $_REQUEST['DriverID'];

    // Prepare statement with parameterized query to prevent SQL injection (security improvement)
    $stmt = $connection->prepare("SELECT * FROM driverprofile WHERE DriverID=?");
    $stmt->bind_param("i", $driver_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['UserID'];
        $license_number = $row['LicenseNumber'];
        $car_model = $row['CarModel'];
        $car_capacity = $row['CarCapacity'];
    } else {
        echo "Driver not found.";
    }

    $stmt->close(); // Close the statement after use
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Driver Profile</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update driver profile form -->
        <h2><u>Update Driver Profile</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <label for="user_id">User ID:</label>
            <input type="text" name="user_id" value="<?php echo isset($user_id) ? $user_id : ''; ?>">
            <br><br>

            <label for="license_number">License Number:</label>
            <input type="text" name="license_number" value="<?php echo isset($license_number) ? $license_number : ''; ?>">
            <br><br>

            <label for="car_model">Car Model:</label>
            <input type="text" name="car_model" value="<?php echo isset($car_model) ? $car_model : ''; ?>">
            <br><br>

            <label for="car_capacity">Car Capacity:</label>
            <input type="text" name="car_capacity" value="<?php echo isset($car_capacity) ? $car_capacity : ''; ?>">
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
    $license_number = $_POST['license_number'];
    $car_model = $_POST['car_model'];
    $car_capacity = $_POST['car_capacity'];

    // Update the driver profile in the database (prepared statement again for security)
    $stmt = $connection->prepare("UPDATE driverprofile SET UserID=?, LicenseNumber=?, CarModel=?, CarCapacity=? WHERE DriverID=?");
    $stmt->bind_param("isssi", $user_id, $license_number, $car_model, $car_capacity, $driver_id);
    $stmt->execute();

    // Redirect to appropriate page after update
    header('Location: driverprofile.php');
    exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
