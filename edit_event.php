<!DOCTYPE html>
<html>
<head>
  <title>Edit Event</title>
  <style>
    body {
      background-color: lightcyan;
      text-align: center;
      font-family: Arial, sans-serif;
    }

    form {
      display: block; 
      flex-wrap: wrap; 
      justify-content: center; 
      align-items: center; 
      background-color: #A6E3E9;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 100%; 
      box-sizing: border-box;
    }

    label, input, textarea, select {
      display: block;
      width: 100%;
      margin-bottom: 10px;
    }

    input[type="submit"], button {
      background-color: dodgerblue;
      color: white;
      border: none;
      border-radius: 5px;
      padding: 10px 20px;
      cursor: pointer;
      margin-right: 10px;
    }

    input[type="submit"]:hover, button:hover {
      background-color: royalblue;
    }
    input[type="text"], input[type="date"], input[type="number"], textarea, select {
      width: 50%; 
    }
    input[type="submit"].update-button {
      height: 35px;
      width: 80px;
}
.button-container {
  display: inline-flex;
  justify-content: space-between;
  width: 100%;
  max-width: 200px;
  margin: 20px auto; 
}

.update-button, #exit-btn {
  flex-grow: 1;
  margin: 0 5px; 
}
.radio-container {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
}

.radio-container label {
  margin-right: 10px;
}

input[type="radio"] {
  margin-top: 2px;
}
.form-group {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-bottom: 20px;
    }

  #exit-btn {
  background-color: red;
  color: white;
  border: none;
  border-radius: 5px;
  padding: 10px 20px;
  cursor: pointer;
  margin-right: 10px;
}

#exit-btn:hover {
  background-color: crimson;
}
  </style>
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
      <div class="form-group">
        <label for="event_title">Event Title:</label>
        <input type="text" name="event_title" value="<?php echo $row['event_title']; ?>">
      </div>
      <div class="form-group">
        <label for="event_date">Event Date:</label>
        <input type="date" id="event-date" name="event_date" value="<?php echo $row['event_date']; ?>">
      </div>
      <div class="form-group">
        <label for="event_description">Event Description:</label>
        <textarea name="event_description"><?php echo $row['event_description']; ?></textarea>
      </div>
      <div class="form-group">
        <label for="event_limit">Event Limit:</label>
        <input type="number" name="event_limit" value="<?php echo $row['event_limit']; ?>">
      </div>
      <div class="form-group">
        <label for="event_Type">Event Type:</label>
          <select name="event_Type">
            <option value="Seminars" <?php if($row['event_Type'] == 'Seminars') { echo 'selected'; } ?>>Seminars</option>
            <option value="Meeting" <?php if($row['event_Type'] == 'Meeting') { echo 'selected'; } ?>>Meeting</option>
            <option value="Webinar" <?php if
            ($row['event_Type'] == 'Webinar') { echo 'selected'; } ?>>Webinar</option>
            <option value="Sports" <?php if($row['event_Type'] == 'Sports') { echo 'selected'; } ?>>Sports</option>
            <option value="Community Service" <?php if($row['event_Type'] == 'Community Service') { echo 'selected'; } ?>>Community Service</option>
          </select><br><br>
      </div>    
      <div class="form-group">
        <label for="event_covered">Event Covered:</label>
      <div class="radio-container">
        <input type="radio" name="event_covered" value="residents-only" <?php if($row['event-covered'] == 'residents-only') { echo 'checked'; } ?>>
        <label for="residents-only">Residents Only</label>
        <input type="radio" name="event_covered" value="open-for-all" <?php if($row['event-covered'] == 'open-for-all') { echo 'checked'; } ?>>
        <label for="open-for-all">Open for All</label>
      </div>
      <div class="button-container">
        <input type="submit" name="update" value="Update" class="update-button">
        <button id="exit-btn" type="button">Exit</button>
      </div>

  </form>
  <?php
    } else {
      echo "<p>No event found.</p>";
    }
    // Close database connection
mysqli_close($conn);
?>

</body>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById("exit-btn").addEventListener("click", function() {
      window.location.href = "adminevents.php";
    });

    // Disable past dates in the date input field
    const today = new Date();
    const formattedDate = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0') + '-' + String(today.getDate()).padStart(2, '0');
    document.getElementById("event-date").setAttribute("min", formattedDate);
  });
</script>

</html>