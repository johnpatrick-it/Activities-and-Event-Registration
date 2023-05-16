<!DOCTYPE html>
<html>
<head>
  <title>Barangay Mapulang Lupa Admin Dashboard</title>
</head>
<style> /* Style for navigation */
*{
    font-family: sans-serif;
}
nav {
  background-color: #333;
  height: 50px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 20px;
}

nav ul {
  list-style: none;
  margin: 0;
  padding: 0;
  display: flex;
}

nav ul li {
  margin-right: 20px;
}

nav ul li:last-child {
  margin-right: 0;
}

nav ul li a {
  color: #fff;
  text-decoration: none;
  font-weight: bold;
  padding: 10px;
}

nav ul li a:hover {
  background-color: #555;
}

/* Style for main section */
main {
  margin: 20px;
}

main h1 {
  font-size: 36px;
  margin-bottom: 10px;
}

main p {
  font-size: 18px;
  line-height: 1.5;
}
 table, th, td {
      border: 1px solid black;
      border-collapse: collapse;
      padding: 5px;
    }
</style>
<body>
 <nav>
    <ul>
      <li><a href="admindashboard.php">Home</a></li>
      <li><a href="adminevents.php">Manage Events</a></li>
      <li><a href="#">Manage Accounts</a></li>
      <li><a href="adminpending.php">Users Request</a></li>
      <li><a href="admin_event_reg.php">Manage event Registration</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
  </nav>
  <main>
  <h1 style="text-align:center;">Manage Events</h1>
  
<?php
require_once 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $event_title = $_POST['event_title'];
    $event_date = $_POST['event_date'];
    $event_description = $_POST['event_description'];
    $event_limit = $_POST['event_limit'];
    $event_type = $_POST['event_type'];
    $event_covered = $_POST['event_covered'];

    // Upload poster file
    $poster_dir = 'uploads/';
    $poster_name = $_FILES['event_poster']['name'];
    $poster_tmp = $_FILES['event_poster']['tmp_name'];
    $poster_path = $poster_dir . $poster_name;
    move_uploaded_file($poster_tmp, $poster_path);

    // Insert data into tbl_event
    $query = "INSERT INTO tbl_event (event_title, event_date, event_description, event_poster, event_limit, event_DateCreated, event_Type, `event-covered`)
              VALUES ('$event_title', '$event_date', '$event_description', '$poster_path', '$event_limit', NOW(), '$event_type', '$event_covered')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header('Location: admindashboard.php');
        exit();
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css\event.css">
</head>
<body>
    <button id="upload-event-btn" style="font-size: 24px; padding: 5px;">Upload an Event</button>

    <div id="event-form-popup" class="form-popup">
        <form id="event-form" action="add_event.php" method="post" enctype="multipart/form-data">
            <h2>Add New Event</h2>
            <label for="event-title">Title:</label>
            <input type="text" id="event-title" name="event_title" required>
            <label for="event-date">Date:</label>
            <input type="date" id="event-date" name="event_date" required>
            <label for="event-description">Description:</label>
            <textarea id="event-description" name="event_description" required></textarea>
            <label for="event-poster">Poster:</label>
            <input type="file" id="event-poster" name="event_poster" accept="image/*" required>
            <label for="event-limit">Limit:</label>
            <input type="number" id="event-limit" name="event_limit">
            <label for="event-type">Type:</label>
            <select id="event-type" name="event_type" required>
                <option value="Seminars">Seminars</option>
                <option value="Meeting">Meeting</option>
                <option value="Webinar">Webinar</option>
                <option value="Sports">Sports</option>
                <option value="Community Service">Community Service</option>
            </select>
            <label for="event-covered">Covered:</label>
            <select id="event-covered" name="event_covered" required>
                <option value="residents-only   ">Residents Only</option>
                <option value="open-for-all">Public</option>
            </select>
    <input type="submit" value="Add Event">
    </form>
    </div>
    <script src="js\event.js"></script>
</body>
</html>

  <table style="width:100%; border-collapse:collapse;">
    <thead>
      <tr style="background-color:grey; color:white; font-weight:bold;">
        <th>ID</th>
        <th>Title</th>
        <th>Date</th>
        <th>Poster</th>
        <th>Limit</th>
        <th>Type</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>
      <?php
        // Include database connection file
        include_once "db_conn.php";
        
        // Fetch data from table
        $sql = "SELECT event_id, event_title, event_date, event_poster, event_limit, event_Type FROM tbl_event";
        $result = mysqli_query($conn, $sql);
        
        // Display data in table
        if (mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>".$row["event_id"]."</td>";
            echo "<td>".$row["event_title"]."</td>";
            echo "<td>".$row["event_date"]."</td>";
            echo "<td>".$row["event_poster"]."</td>";
            echo "<td>".$row["event_limit"]."</td>";
            echo "<td>".$row["event_Type"]."</td>";
            echo "<td><a href='edit_event.php?event_id=".$row["event_id"]."'>Edit</a></td>";
            echo "<td><a href='delete_event.php?event_id=".$row["event_id"]."'>Delete</a></td>";
            echo "</tr>";
          }
        } else {
          echo "<tr><td colspan='7'>No events found</td></tr>";
        }
        
        // Close database connection
        mysqli_close($conn);
      ?>
    </tbody>
  </table>
</main>

</body>
</html>