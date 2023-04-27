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

mysqli_close($conn);
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
    <button id="upload-event-btn">Upload an Event</button>
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
