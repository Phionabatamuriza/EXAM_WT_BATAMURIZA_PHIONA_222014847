<?php
// Check if the 'query' GET parameter is set
if (isset($_GET['query']) && !empty($_GET['query'])) {

 include('db_connection.php');

    // Sanitize input to prevent SQL injection
    $searchTerm = $connection->real_escape_string($_GET['query']);

    // Queries for different tables
    $queries = [
        'bookings' => "SELECT  BookingID FROM bookings WHERE BookingID LIKE '%$searchTerm%'",
        'driverprofile' => "SELECT LicenseNumber FROM driverprofile WHERE LicenseNumber LIKE '%$searchTerm%'",
        'notifications' => "SELECT  UserID FROM notifications WHERE  UserID LIKE '%$searchTerm%'",
        'passengers' => "SELECT  PassengerID FROM passengers WHERE PassengerID LIKE '%$searchTerm%'",
        'payments' => "SELECT PaymentMethod FROM payments WHERE PaymentMethod LIKE '%$searchTerm%'",
         'reviews' => "SELECT Comment FROM reviews WHERE Comment LIKE '%$searchTerm%'",
        'rides' => "SELECT  RideID FROM rides WHERE RideID LIKE '%$searchTerm%'",
        'routes' => "SELECT Location FROM routes WHERE  Location LIKE '%$searchTerm%'",
        'vehicle' => "SELECT PlateNumber FROM vehicle WHERE PlateNumber LIKE '%$searchTerm%'",
    ];

    // Output search results
    echo "<h2><u>Search Results:</u></h2>";

    foreach ($queries as $table => $sql) {
        $result = $connection->query($sql);
        echo "<h3>Table of $table:</h3>";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<p>" . $row[array_keys($row)[0]] . "</p>"; // Dynamic field extraction from result
            }
        } else {
            echo "<p>No results found in $table matching the search term: '$searchTerm'</p>";
        }
    }

    // Close the connection
    $connection->close();
} else {
    echo "<p>No search term was provided.</p>";
}
?>

