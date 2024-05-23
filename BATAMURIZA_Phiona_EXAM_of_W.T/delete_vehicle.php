<?php
include('db_connection.php');

// Check if Vehicle ID is set
if(isset($_REQUEST['vehicle_id'])) {
    $vehicle_id = $_REQUEST['vehicle_id'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM vehicle WHERE VehicleID=?");
    $stmt->bind_param("i", $vehicle_id);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Record</title>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this record?");
        }
    </script>
</head>
<body>
    <form method="post" onsubmit="return confirmDelete();">
        <input type="hidden" name="vehicle_id" value="<?php echo $vehicle_id; ?>">
        <input type="submit" value="Delete">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($stmt->execute()) {
            echo "Record deleted successfully.";
        } else {
            echo "Error deleting data: " . $stmt->error;
        }
    }
    ?>
</body>
</html>
<?php

    $stmt->close();
} else {
    echo "Vehicle ID is not set.";
}

$connection->close();
?>
