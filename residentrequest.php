<?php
require_once "db_conn.php";



if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get input from the form
  $request_title = $_POST['request_title'];
  $request_date = $_POST['request_date'];
  $request_description = $_POST['request_description'];
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $request_username = $_POST['request_username'];
  $request_email = $_POST['request_email'];

// Insert the data into tbl_small_occasion table, without specifying approval_status
$query = "INSERT INTO tbl_small_occasion (request_title, request_date, request_description, request_username, request_email, first_name, last_name) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "sssssss", $request_title, $request_date, $request_description, $request_username, $request_email, $first_name, $last_name);
mysqli_stmt_execute($stmt);




  // Check for successful insertion
  if (mysqli_stmt_affected_rows($stmt) > 0) {
    $success_message = "Request submitted successfully!";
    ?>
     <script>
       window.alert('Request sent successfully!');
       window.location.href='memberevent.php';
     </script>
     <?php
  } else {
    ?>
     <script>
       window.alert('Request failed to send!');
       window.location.href='memberevent.php';
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
  <style>
    body{
      width: 100%;
      height: calc(100%);
      background: #007bff;
    }
    main#main{
      width:100%;
      height: calc(100%);
      background:rgb(250, 0, 0);
    }
    #login-right{
      position: absolute;
      right:0;
      width:40%;
      height: calc(100%);
      background:rgb(47, 69, 234);
      display: flex;
      align-items: center
    }
    #login-left{
      position: absolute;
      left:0;
      width:60%;
      height: calc(100%);
      background:rgb(235, 235, 239);
      display: flex;
      align-items: center;
    }
    #login-right .card{
      margin: auto
        
    }
    .logo {
      margin: auto;
      font-size: 8rem;
      padding: .5em 0.8em;
      color: #000000b3;
    }
    .form-group {
      padding-bottom: 8px;
      font-family: sans-serif;
    }
    /* Add some margin and padding to the form */
    form {
      margin: 20px;
      padding: 20px;
      width: 80%; /* Adjusted form width */
      max-width: 600px; /* Added maximum width for form */
      margin: auto; /* Center the form horizontally */
    }
    /* Add some space between labels and input fields */
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
    /* Hover state for the button */
    button[type="submit"]:hover {
      background-color: #1b22fa;
    }
    input::placeholder {
      color: #bbb;
      font-size: 16px;
      font-weight: 300;
    }
    .logo img {
      width: 400px;
      height: auto;
    }
    .header {
            background-color: #007bff;
            padding: 30px;
        }

        .home-btn {
            margin-left: 70px;
        }

        .request-event-btn {
            margin-left: 900px;
        }
        
  </style>
</head>
<body>
<div class="header">
<a href="home.php" class="home-btn">HOME</a>
<a href="memberevent.php" class="request-event-btn">BACK</a>
</div>
  <form action="residentrequest.php" method="post">
    <label for="request_title">Request Title:</label><br>
    <input type="text" id="request_title" name="request_title" required><br>
    <label for="request_date">Request Date:</label><br>
    <input type="date" id="request_date" name="request_date" required><br>
    <label for="first_name">First Name:</label><br>
    <input type="text" id="first_name" name="first_name" required>
    <label for="last_name">Last Name:</label><br>
    <input type="text" id="last_name" name="last_name" required><br>
    <label for="email">Email:</label><br>
    <input type="email" id="request_email" name="request_email" required><br>
    <label for="request_description">Request Description:</label><br>
    <textarea id="request_description" name="request_description" required></textarea><br><br>
    <button type="submit">Submit</button>
    </form>
</body>
</html>


