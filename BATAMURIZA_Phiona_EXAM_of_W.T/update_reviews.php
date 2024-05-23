<?php
include('db_connection.php');

// Check if ReviewID is set
if (isset($_REQUEST['ReviewID'])) {
    $review_id = $_REQUEST['ReviewID'];

    // Prepare statement with parameterized query to prevent SQL injection (security improvement)
    $stmt = $connection->prepare("SELECT * FROM reviews WHERE ReviewID=?");
    $stmt->bind_param("i", $review_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $ride_id = $row['RideID'];
        $rating = $row['Rating'];
        $comment = $row['Comment'];
        $timestamp = $row['Timestamp'];
    } else {
        echo "Review not found.";
    }

    $stmt->close(); // Close the statement after use
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Review Information</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
<center>
    <!-- Update review information form -->
    <h2><u>Update Review Information</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="ride_id">Ride ID:</label>
        <input type="number" name="ride_id" value="<?php echo isset($ride_id) ? $ride_id : ''; ?>">
        <br><br>

        <label for="rating">Rating:</label>
        <input type="number" name="rating" value="<?php echo isset($rating) ? $rating : ''; ?>">
        <br><br>

        <label for="comment">Comment:</label>
        <input type="text" name="comment" value="<?php echo isset($comment) ? $comment : ''; ?>">
        <br><br>

        <label for="timestamp">Timestamp:</label>
        <input type="datetime-local" name="timestamp" value="<?php echo isset($timestamp) ? $timestamp : ''; ?>">
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
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $timestamp = $_POST['timestamp'];

    // Update the review in the database (prepared statement again for security)
    $stmt = $connection->prepare("UPDATE reviews SET RideID=?, Rating=?, Comment=?, Timestamp=? WHERE ReviewID=?");
    $stmt->bind_param("iissi", $ride_id, $rating, $comment, $timestamp, $review_id);
    $stmt->execute();

    // Redirect to appropriate page after update
    header('Location: reviews.php');
    exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
