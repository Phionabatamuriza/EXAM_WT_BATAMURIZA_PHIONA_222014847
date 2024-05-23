<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Linking to external stylesheet -->
  <link rel="stylesheet" type="text/css" href="mystyle.css" title="style 1" media="screen, tv, projection, handheld, print"/>
  <!-- Defining character encoding -->
  <meta charset="utf-8">
  <!-- Setting viewport for responsive design -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Notifications Page</title>
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

<body bgcolor="gray">
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
    <h1><u>Notifications Form</u></h1>

    <form method="post" onsubmit="return confirmInsert();">

        <label for="notification_id">Notification ID:</label>
        <input type="number" id="notification_id" name="notification_id" required><br><br>

        <label for="user_id">User ID:</label>
        <input type="number" id="user_id" name="user_id" required><br><br>

        <label for="notification_type">Notification Type:</label>
        <input type="text" id="notification_type" name="notification_type" required><br><br>

        <label for="message">Message:</label>
        <input type="text" id="message" name="message" required><br><br>

        <label for="timestamp">Timestamp:</label>
        <input type="datetime-local" id="timestamp" name="timestamp" required><br><br>

        <input type="submit" name="add" value="Insert">
    </form>

    <?php
    include('db_connection.php');

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind the parameters
        $stmt = $connection->prepare("INSERT INTO notifications(NotificationID, UserID, NotificationType, Message, Timestamp) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $notification_id, $user_id, $notification_type, $message, $timestamp);
        // Set parameters and execute
        $notification_id = $_POST['notification_id'];
        $user_id = $_POST['user_id'];
        $notification_type = $_POST['notification_type'];
        $message = $_POST['message'];
        $timestamp = $_POST['timestamp'];

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
    <title>Notification Details</title>
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
    <center><h2>Notification Table</h2></center>
    <table border="3">
        <tr>
            <th>Notification ID</th>
            <th>User ID</th>
            <th>Notification Type</th>
            <th>Message</th>
            <th>Timestamp</th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
<?php
include('db_connection.php');

// Prepare SQL query to retrieve all notifications
$sql = "SELECT * FROM notifications";
$result = $connection->query($sql);

// Check if there are any notifications
if ($result->num_rows > 0) {
    // Output data for each row
    while ($row = $result->fetch_assoc()) {
        $notification_id = $row['NotificationID']; // Fetch the Notification ID
        echo "<tr>
            <td>" . $row['NotificationID'] . "</td>
            <td>" . $row['UserID'] . "</td>
            <td>" . $row['NotificationType'] . "</td>
            <td>" . $row['Message'] . "</td>
            <td>" . $row['Timestamp'] . "</td>
            <td><a style='padding:4px' href='delete_notifications.php?notification_id=$notification_id'>Delete</a></td> 
            <td><a style='padding:4px' href='update_notifications.php?notification_id=$notification_id'>Update</a></td> 
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

