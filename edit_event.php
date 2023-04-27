<!DOCTYPE html>
<html>
<head>
  <title>Edit Event</title>
</head>
<body>
  <?php
    // Include database connection file
    include_once "db_conn.php";

    // Check if form is submitted
    if(isset($_POST['update'])) {
      $event_id = $_POST['event_id'];
      $event_title = $_POST['event_title'];
      $event_date = $_POST['event_date'];
      $event_description = $_POST['event_description'];
     
      $event_limit = $_POST['event_limit'];
      $event_Type = $_POST['event_Type'];
      $event_covered = $_POST['event_covered'];

      // Upload event poster file
      if(!empty($event_poster)) {
        $event_poster = file_get_contents($event_poster);
      } else {
        $event_poster = NULL;
      }

      // Update data in table
      $sql = "UPDATE tbl_event SET event_title='$event_title', event_date='$event_date', event_description='$event_description', event_limit='$event_limit', event_Type='$event_Type', `event-covered`='$event_covered' WHERE event_id=$event_id";
      $result = mysqli_query($conn, $sql);

      // Check if data is updated successfully
      if($result) {
        echo "<p>Data updated successfully.</p>";
      } else {
        echo "<p>Failed to update data.</p>";
      }
    }

    // Get event ID from URL parameter
    $event_id = $_GET['event_id'];

    // Fetch data from table
    $sql = "SELECT * FROM tbl_event WHERE event_id=$event_id";
    $result = mysqli_query($conn, $sql);

    // Display form with pre-filled data
    if(mysqli_num_rows($result) == 1) {
      $row = mysqli_fetch_assoc($result);
  ?>
  <form method="post" enctype="multipart/form-data">
    <input type="hidden" name="event_id" value="<?php echo $row['event_id']; ?>">
    <label for="event_title">Event Title:</label>
    <input type="text" name="event_title" value="<?php echo $row['event_title']; ?>"><br><br>
    <label for="event_date">Event Date:</label>
    <input type="date" name="event_date" value="<?php echo $row['event_date']; ?>"><br><br>
    <label for="event_description">Event Description:</label>
    <textarea name="event_description"><?php echo $row['event_description']; ?></textarea><br><br>
    
    <label for="event_limit">Event Limit:</label>
    <input type="number" name="event_limit" value="<?php echo $row['event_limit']; ?>"><br><br>
    <label for="event_Type">Event Type:</label>
    <select name="event_Type">
      <option value="Seminars" <?php if($row['event_Type'] == 'Seminars') { echo 'selected'; } ?>>Seminars</option>
      <option value="Meeting" <?php if($row['event_Type'] == 'Meeting') { echo 'selected'; } ?>>Meeting</option>
      <option value="Webinar" <?php if
    ($row['event_Type'] == 'Webinar') { echo 'selected'; } ?>>Webinar</option>
    <option value="Sports" <?php if($row['event_Type'] == 'Sports') { echo 'selected'; } ?>>Sports</option>
    <option value="Community Service" <?php if($row['event_Type'] == 'Community Service') { echo 'selected'; } ?>>Community Service</option>
    </select><br><br>
    <label for="event_covered">Event Covered:</label>
    <input type="radio" name="event_covered" value="residents-only" <?php if($row['event-covered'] == 'residents-only') { echo 'checked'; } ?>>Residents Only
    <input type="radio" name="event_covered" value="open-for-all" <?php if($row['event-covered'] == 'open-for-all') { echo 'checked'; } ?>>Open for All<br><br>
    <input type="submit" name="update" value="Update">

  </form>
  <?php
    } else {
      echo "<p>No event found.</p>";
    }
    // Close database connection
mysqli_close($conn);
?>

</body>
</html>