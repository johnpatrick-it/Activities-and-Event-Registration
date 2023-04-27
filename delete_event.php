<?php
// Include database connection file
include_once "db_conn.php";

// Check if event_id is set in URL parameter
if(isset($_GET['event_id'])) {
  $event_id = $_GET['event_id'];

  // Delete data from table
  $sql = "DELETE FROM tbl_event WHERE event_id=$event_id";
  $result = mysqli_query($conn, $sql);

  // Check if data is deleted successfully
  if($result) {
    echo "<p>Event deleted successfully.</p>";
  } else {
    echo "<p>Failed to delete event.</p>";
  }
} else {
  echo "<p>No event ID specified.</p>";
}
// Close database connection
mysqli_close($conn);
?>
