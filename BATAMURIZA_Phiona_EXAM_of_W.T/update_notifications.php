<?php
include('db_connection.php');

// Check if NotificationID is set
if (isset($_REQUEST['NotificationID'])) {
    $notification_id = $_REQUEST['NotificationID'];

    // Prepare statement with parameterized query to prevent SQL injection (security improvement)
    $stmt = $connection->prepare("SELECT * FROM notifications WHERE NotificationID=?");
    $stmt->bind_param("i", $notification_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['UserID'];
        $notification_type = $row['NotificationType'];
        $message = $row['Message'];
        $timestamp = $row['Timestamp'];
    } else {
        echo "Notification not found.";
    }

    $stmt->close(); // Close the statement after use
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Notification Information</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update notification information form -->
        <h2><u>Update Notification Information</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
            <label for="user_id">User ID:</label>
            <input type="text" name="user_id" value="<?php echo isset($user_id) ? $user_id : ''; ?>">
            <br><br>

            <label for="notification_type">Notification Type:</label>
            <input type="text" name="notification_type" value="<?php echo isset($notification_type) ? $notification_type : ''; ?>">
            <br><br>

            <label for="message">Message:</label>
            <input type="text" name="message" value="<?php echo isset($message) ? $message : ''; ?>">
            <br><br>

            <label for="timestamp">Timestamp:</label>
            <input type="text" name="timestamp" value="<?php echo isset($timestamp) ? $timestamp : ''; ?>">
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
    $notification_type = $_POST['notification_type'];
    $message = $_POST['message'];
    $timestamp = $_POST['timestamp'];

    // Update the notification in the database (prepared statement again for security)
    $stmt = $connection->prepare("UPDATE notifications SET UserID=?, NotificationType=?, Message=?, Timestamp=? WHERE NotificationID=?");
    $stmt->bind_param("isssi", $user_id, $notification_type, $message, $timestamp, $notification_id);
    $stmt->execute();

    // Redirect to appropriate page after update
    header('Location: notifications.php');
    exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
