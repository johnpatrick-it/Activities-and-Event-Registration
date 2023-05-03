<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  // Redirect to the login page
  header('Location: login.php');
  exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Barangay Mapulang Lupad Admin Dashboard</title>
  <style>
    /* Style for navigation */
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
      display: flex;
      justify-content: space-between;
    }

    /* Style for card */
    .card {
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      padding: 20px;
      width: 30%;
    }

    .card h2 {
      font-size: 24px;
      margin-top: 0;
    }

    .card p {
      font-size: 18px;
      margin: 10px 0 0;
    }
    a {
        text-decoration: none;
        color:black;
    }

  </style>
</head>
<?php
// Connect to the database
require_once 'db_conn.php';

// Count total number of events
$sql = "SELECT COUNT(*) AS total_events FROM tbl_event";
$result = mysqli_query($conn, $sql);
$total_events = mysqli_fetch_assoc($result)['total_events'];

$current_date = date('Y-m-d');

// Count the total number of events
$sql_total_events = "SELECT COUNT(*) as total_events FROM tbl_event";
$result_total_events = mysqli_query($conn, $sql_total_events);
$row_total_events = mysqli_fetch_assoc($result_total_events);
$total_events = $row_total_events['total_events'];

// Count the number of finished events
$sql_finished_events = "SELECT COUNT(*) as finished_events FROM tbl_event WHERE event_date < '$current_date'";
$result_finished_events = mysqli_query($conn, $sql_finished_events);
$row_finished_events = mysqli_fetch_assoc($result_finished_events);
$finished_events = $row_finished_events['finished_events'];

// Count the number of upcoming events
$sql_upcoming_events = "SELECT COUNT(*) as upcoming_events FROM tbl_event WHERE event_date > '$current_date'";
$result_upcoming_events = mysqli_query($conn, $sql_upcoming_events);
$row_upcoming_events = mysqli_fetch_assoc($result_upcoming_events);
$upcoming_events = $row_upcoming_events['upcoming_events'];

// Count the number of pending requests
$sql_pending_requests = "SELECT COUNT(*) as pending_requests FROM tbl_small_occasion WHERE approval_status = 'pending'";
$result_pending_requests = mysqli_query($conn, $sql_pending_requests);
$row_pending_requests = mysqli_fetch_assoc($result_pending_requests);
$pending_requests = $row_pending_requests['pending_requests'];
?>

<body>
  <nav>
    <ul>
      <li><a href="adminevents.php">Home</a></li>
      <li><a href="adminevents.php">Manage Events</a></li>
      <li><a href="#">Manage Accounts</a></li>
      <li><a href="adminpending.php">Users Request</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </nav>
  <main>
    <div class="card">
     <a href="#"> <h2>Total Events</h2>
      <p><?php echo $total_events; ?></p>
      </a>
    </div>
    <div class="card">
      <a href="#"><h2>Finished Events</h2>
      <p><?php echo $finished_events; ?></p>
      </a>
    </div>
    <div class="card">
      <a href="#"><h2>Upcoming Events</h2>
      <p><?php echo $upcoming_events; ?></p>
      </a>
    </div>
    <div class="card">
      <a href="adminpending.php"><h2>Pending Requests</h2>
      <p><?php echo $pending_requests; ?></p>
    </a>
  </div>
  </main>
</body>