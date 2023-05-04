<?php
require_once "db_conn.php";



if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get input from the form
  $request_title = $_POST['request_title'];
  $request_date = $_POST['request_date'];
  $request_description = $_POST['request_description'];
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $request_email = $_POST['request_email'];

// Insert the data into tbl_small_occasion table, without specifying approval_status
$query = "INSERT INTO tbl_small_occasion (request_title, request_date, request_description, request_email, first_name, last_name) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ssssss", $request_title, $request_date, $request_description, $request_email, $first_name, $last_name);
mysqli_stmt_execute($stmt);




  // Check for successful insertion
  if (mysqli_stmt_affected_rows($stmt) > 0) {
    $success_message = "Request submitted successfully!";
    ?>
     <script>
       window.alert('Request sent successfully!');
       window.location.href='residentrequest.php';
     </script>
     <?php
  } else {
    ?>
     <script>
       window.alert('Request failed to send!');
       window.location.href='residentrequest.php';
     </script>
     <?php
  }

  // Close database connection
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Resident Request Form</title>

    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-digimedia-v1.css">
    <link rel="stylesheet" href="assets/css/animated.css">
    <link rel="stylesheet" href="assets/css/owl.css">
  <style>
    body{
      width: 100%;
      height: calc(100%);
      background: #A6E3E9;
    }
    main#main{
      width:100%;
      height: calc(100%);
      background:rgb(250, 0, 0);
    }

    .form-group {
      padding-bottom: 8px;
      font-family: sans-serif;
    }
    form {
      margin: 20px;
      padding: 20px;
      width: 60%; /* Adjusted form width */
      max-width: 600; /* Added maximum width for form */
      margin: auto;
    }
    label {
      display: block;
      margin-bottom: 5px;
    }
    input {
      margin-bottom: 10px;
      padding: 5px;
      border-radius: 5px;
      border: 1px solid #ccc;
      font-size: 16px;
      width: 100%;
    }
    /* Style the submit button */
    button[type="submit"] {
      background-color: rgb(239, 21, 21);
      border: none;
      color: white;
      padding: 10px 20px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      border-radius: 5px;
      cursor: pointer;
    }
    button[type="submit"]:hover {
      background-color: #1b22fa;
    }
    input::placeholder {
      color: #bbb;
      font-size: 16px;
      font-weight: 300;
    }
    .header {
            background-color: #CBF1F5;
            padding: 30px;
            margin: auto;
        }

        .home-btn {
            margin-left: 70px;
        }

        .request-event-btn {
            margin-left: 900px;
        }

        textarea {
    margin-bottom: 10px;
    padding: 5px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 16px;
    width: 100%;
    height: 100px; 
  }
  .submit-container {
    text-align: center;
    margin-top: 10px;
  }
      
  
  </style>
</head>
<body>

<div class="pre-header">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-sm-8 col-7">
          <ul class="info">
            <li><a href="#"><i class="fa fa-envelope"></i>brgy.mapulanglupa2018@gmail.com</a></li>
            <li><a href="#"><i class="fa fa-phone"></i>0923-088-8995</a></li>
          </ul>
        </div>
        <div class="col-lg-4 col-sm-4 col-5">
          <ul class="social-media">
            <li><a href="https://www.facebook.com/bagongmapulanglupa2018"><i class="fa fa-facebook"></i></a></li>
            
          </ul>
        </div>
      </div>
    </div>
  </div>



<div class="header">
<div class="border-first-button"><a href="memberevent.php">Back To Events</a></div>
</div>
  <form action="residentrequest.php" method="post">
    <label for="request_title">Request Title:</label>
    <input type="text" id="request_title" name="request_title" required><br>
    <label for="request_date">Request Date:</label>
    <input type="date" id="request_date" name="request_date" required><br>
    <label for="first_name">First Name:</label>
    <input type="text" id="first_name" name="first_name" required>
    <label for="last_name">Last Name:</label>
    <input type="text" id="last_name" name="last_name" required><br>
    <label for="email">Email:</label>
    <input type="email" id="request_email" name="request_email" required><br>
    <label for="request_description">Request Description:</label>
    <textarea id="request_description" name="request_description" required></textarea><br><br>
    <div class="submit-container">
      <button type="submit">Submit</button>
    </div>
</form>
    </form>
</body>
</html>


