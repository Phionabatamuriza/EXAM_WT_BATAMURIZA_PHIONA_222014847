<?php
include('db_connection.php');

// Check if RouteID is set
if (isset($_REQUEST['RouteID'])) {
    $route_id = $_REQUEST['RouteID'];

    // Prepare statement with parameterized query to prevent SQL injection (security improvement)
    $stmt = $connection->prepare("SELECT * FROM routes WHERE RouteID=?");
    $stmt->bind_param("i", $route_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $ride_id = $row['RideID'];
        $location = $row['Location'];
    } else {
        echo "Route not found.";
    }

    $stmt->close(); // Close the statement after use
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Route Information</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
<center>
    <!-- Update route information form -->
    <h2><u>Update Route Information</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="ride_id">Ride ID:</label>
        <input type="number" name="ride_id" value="<?php echo isset($ride_id) ? $ride_id : ''; ?>">
        <br><br>

        <label for="location">Location:</label>
        <input type="text" name="location" value="<?php echo isset($location) ? $location : ''; ?>">
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
    $location = $_POST['location'];

    // Update the route in the database (prepared statement again for security)
    $stmt = $connection->prepare("UPDATE routes SET RideID=?, Location=? WHERE RouteID=?");
    $stmt->bind_param("isi", $ride_id, $location, $route_id);
    $stmt->execute();

    // Redirect to appropriate page after update
    header('Location: routes.php');
    exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
