<?php
// Start the session
session_start();

// Include the database connection file
require 'db_conn.php';

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve the form inputs
  $event_joined = $_POST['event_joined'];
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $birthday = $_POST['birthday'];
  
  // Calculate the age based on the birthday
  $today = date("Y-m-d");
  $diff = date_diff(date_create($birthday), date_create($today));
  $age = $diff->format('%y');
  
  $sex = $_POST['sex'];
  $address = $_POST['address'];
  
  // Check if the residency_image has been uploaded
  if ($_FILES['residency_image']['size'] > 0) {
    $residency_image = file_get_contents($_FILES['residency_image']['tmp_name']);
  } else {
    $residency_image = null;
  }
  
  // Prepare a SQL statement to insert the data into the tbl_eventreg table
  $stmt = mysqli_prepare($conn, 'INSERT INTO tbl_eventreg (event_joined, first_name, last_name, birthday, age, sex, address, residency_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
  mysqli_stmt_bind_param($stmt, 'ssssisss', $event_joined, $first_name, $last_name, $birthday, $age, $sex, $address, $residency_image);
  mysqli_stmt_execute($stmt);
  
  // Redirect to the success page
  header('Location: memberevent.php');
  exit();
}
?>
<form method="POST" enctype="multipart/form-data">
  <div>
    <label for="event_joined">Event Name:</label>
    <input type="text" name="event_joined" value="<?php echo $_GET['event_id']; ?>" readonly>
  </div>
  <div>
    <label for="first_name">First Name:</label>
    <input type="text" name="first_name" required>
  </div>
  <div>
    <label for="last_name">Last Name:</label>
    <input type="text" name="last_name" required>
  </div>
  <div>
    <label for="birthday">Birthday:</label>
    <input type="date" name="birthday" required>
  </div>
  <div>
    <label for="sex">Sex:</label>
    <select name="sex" required>
      <option value="male">Male</option>
      <option value="female">Female</option>
    </select>
  </div>
  <div>
    <label for="address">Address:</label>
    <input type="text" name="address" required>
  </div>
  <div>
    <label for="residency">Residency:</label>
    <select name="residency" required>
      <option value="resident">Resident</option>
      <option value="outsider">Outsider</option>
    </select>
  </div>
  <div>
    <label for="residency_image">Residency Image:</label>
<input type="file" name="residency_image" >

  </div>
  <button type="submit" name="submit">Register</button>
</form>
<?php
// Check if the form has been submitted
if (isset($_POST['submit'])) {
  // Retrieve the form data
  $event_joined = $_POST['event_joined'];
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $birthday = $_POST['birthday'];
  $sex = $_POST['sex'];
  $address = $_POST['address'];
  $residency = $_POST['residency'];
  
  // Check if residency is 'resident' and residency_image has been uploaded
  $residency_image = null;
  if ($residency === 'resident' && isset($_FILES['residency_image']) && $_FILES['residency_image']['size'] > 0) {
    // Get the uploaded file data
    $residency_image_name = $_FILES['residency_image']['name'];
    $residency_image_tmp_name = $_FILES['residency_image']['tmp_name'];
    $residency_image_size = $_FILES['residency_image']['size'];
    $residency_image_type = $_FILES['residency_image']['type'];

    // Read the file contents
    $residency_image = file_get_contents($residency_image_tmp_name);
  }

  // Prepare a SQL statement to insert the event registration data
  $stmt = mysqli_prepare($conn, 'INSERT INTO tbl_eventreg (event_joined, first_name, last_name, birthday, age, sex, address, residency, residency_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
  
  // Calculate the age based on the birthday
  $age = date_diff(date_create($birthday), date_create('today'))->y;

  // Bind the parameters to the SQL statement
  mysqli_stmt_bind_param($stmt, 'ssssisssb', $event_joined, $first_name, $last_name, $birthday, $age, $sex, $address, $residency, $residency_image);

  // Execute the SQL statement
  if (mysqli_stmt_execute($stmt)) {
    echo "Registration successful.";
  } else {
    echo "Registration failed.";
  }

  // Close the prepared statement
  mysqli_stmt_close($stmt);
}
?>
