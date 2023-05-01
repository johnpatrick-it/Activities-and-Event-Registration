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
<!DOCTYPE html>
<html>
<head>
    <title>Pending Requests</title>
    <style>
         body {
              font-family: Arial, sans-serif;
          }
          .requests-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            border: 10px solid black;
            border-radius: 5px;
            margin-bottom: 20px;
            
        }
        .request-item {
            width: calc(33% - 20px);
            margin-bottom: 20px;
        }
          table {
              width: 100%;
              border-collapse: separate;
              margin-bottom: 20px;
              border-spacing: 0 20px;
              box-shadow: 0 0 10px rgba(0, 0, 0, 10);
          }
          th, td {
              padding: 7px;
              text-align: left;
              border-bottom: 1px solid #ddd;
          }
          th {
              background-color: #f2f2f2;
          }
          td.request-description{
            max-width: 300px;
            word-wrap: break-word;
          }
          form {
              margin-top: 10px;
              text-align: center;
          }
          input[type="radio"] {
              margin-right: 5px;
          }
          input[type="submit"] {
              padding: 15px;
              background-color: #4CAF50;
              color: #fff;
              border: none;
              cursor: pointer;

          }
          input[type="submit"]:hover {
              background-color: #45a049;
          }
          hr {
              border: none;
              border-top: 1px solid #ddd;
              margin: 20px 0;
          }
    </style>
</head>
<body>
<header>
</header>
<div class="requests-container">
    <?php
    // Include database connection file
    include('db_conn.php');

    // Fetch pending requests from tbl_small_occasion
    $query = "SELECT * FROM tbl_small_occasion WHERE approval_status = 'pending'";
    $result = mysqli_query($conn, $query);

    // Check if any pending requests found
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $request_id = $row['request_id'];
            $request_title = $row['request_title'];
            $request_date = $row['request_date'];
            $request_description = $row['request_description'];
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
            $request_email = $row['request_email'];

            // Display request details in HTML table
            echo "<table>";
            echo "<tr><th>Request ID:</th><td>" . $request_id . "</td></tr>";
            echo "<tr><th>Title:</th><td>" . $request_title . "</td></tr>";
            echo "<tr><th>Date:</th><td>" . $request_date . "</td></tr>";
            echo "<tr><th>Request Description:</th><td>" . $request_description . "</td></tr>";
            echo "<tr><th>First Name:</th><td>" . $first_name . "</td></tr>";
            echo "<tr><th>Last Name:</th><td>" . $last_name . "</td></tr>";
            echo "<tr><th>Email:</th><td>" . $request_email . "</td></tr>";
            echo "<tr><td colspan='2'>";
            echo "<form action='approve_reject.php' method='post' onsubmit='return confirmReject()'>";
            echo "<input type='hidden' name='request_id' value='" . $request_id . "'>";
            echo "<br>";
            echo "<input type='radio' name='approval_status' value='approved' checked> Approve ";
            echo "<input type='radio' name='approval_status' value='rejected'> Reject ";
            echo"<br>";
            echo "<br>";
            echo ("<input type='submit' value='Submit'>");
            echo "</form>";
            echo "</td></tr>";
            echo "</table>";
            }
            } else {
            echo "<p>No pending requests found.</p>";
            }
            // Close database connection
mysqli_close($conn);
?>
</div>
<script>
    function confirmReject() {
    var rejectRadio = document.querySelector('input[name="approval_status"][value="rejected"]');
    if (rejectRadio.checked) {
        var rejectReason = prompt("Enter the reason for rejection:");
        if (rejectReason === null || rejectReason === "") {
            alert("Please enter a reason for rejection.");
            return false;
        } else {
            return true;
        }
    }
    return true;
}
</script>
</main>
</body>
</html>


