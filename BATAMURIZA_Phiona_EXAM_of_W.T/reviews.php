<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Linking to external stylesheet -->
  <link rel="stylesheet" type="text/css" href="mystyle.css" title="style 1" media="screen, tv, projection, handheld, print"/>
  <!-- Defining character encoding -->
  <meta charset="utf-8">
  <!-- Setting viewport for responsive design -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Review Page</title>
  <style>
    /* Normal link */
    a {
      padding: 10px;
      color: white;
      background-color: yellow;
      text-decoration: none;
      margin-right: 15px;
    }

    /* Visited link */
    a:visited {
      color: purple;
    }
    /* Unvisited link */
    a:link {
      color: brown; /* Changed to lowercase */
    }
    /* Hover effect */
    a:hover {
      background-color: white;
    }

    /* Active link */
    a:active {
      background-color: red;
    }

    /* Extend margin left for search button */
    button.btn {
      margin-left: 15px; /* Adjust this value as needed */
      margin-top: 4px;
    }
    /* Extend margin left for search button */
    input.form-control {
      margin-left: 1200px; /* Adjust this value as needed */

      padding: 8px;
     
    }
  </style>

  <!-- JavaScript validation and content load for insert data-->
        <script>
            function confirmInsert() {
                return confirm('Are you sure you want to insert this record?');
            }
        </script>
        
  </head>

  <header>

<body bgcolor="orange">
  <form class="d-flex" role="search" action="search.php">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="query">
      <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
  <ul style="list-style-type: none; padding: 0;">
    <li style="display: inline; margin-right: 10px;">
    <img src="./image/logo.jpeg" width="90" height="60" alt="Logo">
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./home.html">HOME</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./about.html">ABOUT</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./contact.html">CONTACT</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./bookings.php">BOOKINGS</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./driverprofile.php">DRIVER PROFILE</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./notifications.php">NOTIFICATIONS</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./passengers.php">PASSENGERS</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./payments.php">PAYMENTS</a>
  </li>  <li style="display: inline; margin-right: 10px;"><a href="./reviews.php">REVIEWS</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./rides.php">RIDES</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./routes.php">ROUTES</a>
  </li>
<li style="display: inline; margin-right: 10px;"><a href="./vehicle.php">VEHICLE</a>
  </li>
   
   
  
    <li class="dropdown" style="display: inline; margin-right: 10px;">
      <a href="#" style="padding: 10px; color: white; background-color: skyblue; text-decoration: none; margin-right: 15px;">Settings</a>
      <div class="dropdown-contents">
        <!-- Links inside the dropdown menu -->
        <a href="login.html">Login</a>
        <a href="register.html">Register</a>
        <a href="logout.php">Logout</a>
      </div>
    </li><br><br>
    
    
    
  </ul>

</header>
<section>
    <h1><u>Reviews Form</u></h1>

<form method="post" onsubmit="return confirmInsert();">

    <label for="ReviewID">ReviewID:</label>
    <input type="number" id="book_id" name="book_id" required><br><br>

    <label for="RideID">RideID:</label>
    <input type="number" id="ride_id" name="ride_id" required><br><br>

    <label for="Rating">Rating:</label>
    <input type="text" id="passenger_id" name="passenger_id" required><br><br>

    <label for="Comment">Comment:</label>
    <input type="text" id="booking_time" name="booking_time" required><br><br>

    <label for="Timestamp">Timestamp:</label>
    <input type="datetime-local" id="bookingtime" name="bookingtime" required><br><br>
    </select><br><br>

    <input type="submit" name="add" value="Insert">
</form>

<?php
include('db_connection.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and bind the parameters
    $stmt = $connection->prepare("INSERT INTO reviews(ReviewID , RideID, Rating, Comment, Timestamp) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $ReviewID, $RideID, $passenger_id, $Comment, $Timestamp);
    // Set parameters and execute
    $ReviewID = $_POST['book_id'];
    $RideID = $_POST['ride_id'];
    $Rating = $_POST['passenger_id'];
    $Comment = $_POST['booking_time'];
    $Timestamp = $_POST['status'];
   
    if ($stmt->execute() == TRUE) {
        echo "New record has been added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
$connection->close();
?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reviews Details</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <center><h2>Reviews Table</h2></center>
    <table border="3">
        <tr>
            <th>ReviewID</th>
            <th>RideID</th>
            <th>Rating </th>
            <th>Comment</th>
            <th>Timestamp</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
<?php
include('db_connection.php');

// Prepare SQL query to retrieve all reviews
$sql = "SELECT * FROM reviews";
$result = $connection->query($sql);

// Check if there are any reviews
if ($result->num_rows > 0) {
    // Output data for each row
    while ($row = $result->fetch_assoc()) {
        $ReviewID = $row['ReviewID']; // Fetch the Booking ID
        echo "<tr>
            <td>" . $row['ReviewID'] . "</td>
            <td>" . $row['RideID'] . "</td>
            <td>" . $row['Rating'] . "</td>
            <td>" . $row['Comment'] . "</td>
            <td>" . $row['Timestamp'] . "</td>
            <td><a style='padding:4px' href='delete_reviews.php?ReviewID=$ReviewID'>Delete</a></td> 
            <td><a style='padding:4px' href='update_reviews.php?ReviewID=$ReviewID'>Update</a></td> 
        </tr>";
    }

} else {
    echo "<tr><td colspan='7'>No data found</td></tr>";
}
// Close the database connection
$connection->close();
?>
      </table>

</body>

</section>
 
<footer>
  <center> 
   <b><h2>UR CBE BIT &copy, 2024 &reg, Designer by:BATAMURIZA Phiona</h2></b>
  </center>
</footer>
  
</body>
</html>

