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
  $residency = $_POST['residency'];
  
  // Check if the residency_image has been uploaded
  $residency_image = null;
  if ($residency === 'resident' && $_FILES['residency_image']['size'] > 0) {
    $residency_image = file_get_contents($_FILES['residency_image']['tmp_name']);
  }
  
  // Prepare a SQL statement to insert the data into the tbl_eventreg table
  $stmt = mysqli_prepare($conn, 'INSERT INTO tbl_eventreg (event_joined, first_name, last_name, birthday, age, sex, address, residency, residency_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
  mysqli_stmt_bind_param($stmt, 'ssssisssb', $event_joined, $first_name, $last_name, $birthday, $age, $sex, $address, $residency, $residency_image);
  mysqli_stmt_execute($stmt);
  
  // Redirect to the success page
  header('Location: memberevent.php');
  exit();
}

$event_id = $_GET['event_id'];
$query = "SELECT event_limit, event_title FROM tbl_event WHERE event_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 's', $event_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$event_limit = $row['event_limit'];
$event_title = $row['event_title'];

$query = "SELECT COUNT(*) as reg_id FROM tbl_eventreg WHERE event_joined = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 's', $event_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$reg_id = $row['reg_id'];

$event_limit_reached = false;
if ($reg_id >= $event_limit) {
  $event_limit_reached = true;
}

?>
<html>
    <title>Registration</title>
<head>
<style>

.wrapper {
  display: flex;
  width: 100%;
  justify-content: center;
}
.centered {
  margin: 0;
  background-color: lightblue;
  flex: 1;
  padding: 15px;
  text-align: center;
}
body {
    font-family: Arial, sans-serif;
  }

  .form-container {
    display: flex;
    justify-content: center;
    margin-top: 2rem;
  }

  form {
    background-color: #f1f1f1;
    padding: 2rem;
    border-radius: 10px;
    width: 400px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  label {
    display: block;
    margin-bottom: 0.5rem;
  }

  input[type="text"],
  input[type="date"],
  select {
    width: 100%;
    padding: 0.5rem;
    margin-bottom: 1rem;
    border: 1px solid #ccc;
    border-radius: 4px;
  }

  input[type="file"] {
    margin-bottom: 1rem;
  }

  button[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 0.8rem;
    text-align: center;
    border: none;
    cursor: pointer;
    width: 100%;
    border-radius: 4px;
  }

  button[type="submit"]:hover {
    background-color: #45a049;
  }
  .form-center {
  width: 400px;
  margin: 0 auto;
}

</style>
</head>
<body>
<div class="wrapper">
  <div class="form-center">
    <form method="POST" enctype="multipart/form-data" onsubmit="return validateForm();">
      <div>
        <label for="event_joined">Event ID:</label>
        <input type="text" name="event_joined" value="<?php echo htmlspecialchars($event_title); ?>" readonly>
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
        <input type="file" name="residency_image">
      </div>
      <button type="submit" name="submit">Register</button>
    </form>
  </div>
</div>
</div>
</body>

<?php if ($event_limit_reached): ?>
    <script>
    alert("The event limit has been reached. You cannot register for this event.");
    window.location.href = "memberevent.php";
    </script>
<?php endif; ?>

</html>
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
<script>
function validateForm() {
  var event_joined = document.getElementsByName("event_joined")[0].value;
  var first_name = document.getElementsByName("first_name")[0].value;
  var last_name = document.getElementsByName("last_name")[0].value;
  var birthday = document.getElementsByName("birthday")[0].value;
  var sex = document.getElementsByName("sex")[0].value;
  var address = document.getElementsByName("address")[0].value;
  var residency = document.getElementsByName("residency")[0].value;
  var residency_image = document.getElementsByName("residency_image")[0].value;

  if (
    /^\s/.test(event_joined) ||
    /^\s/.test(first_name) ||
    /^\s/.test(last_name) ||
    /^\s/.test(birthday) ||
    /^\s/.test(sex) ||
    /^\s/.test(address) ||
    /^\s/.test(residency) ||
    (residency === "resident" && /^\s/.test(residency_image))
  ) {
    alert("Please enter only valid inputs.");
    return false;
  }
}
</script>