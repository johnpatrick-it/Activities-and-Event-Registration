<?php
// Start the session
session_start();

// Connect to the database
require_once 'db_conn.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the form data
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Find the user in the database
  $sql = "SELECT * FROM users WHERE username = '$username'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) === 1) {
    $user = mysqli_fetch_assoc($result);

    // Check if the password matches
    if (password_verify($password, $user['password'])) {
  // Set session variables to indicate that the user is logged in
  $_SESSION['loggedin'] = true;
  $_SESSION['user_id'] = $user['id'];

  // Redirect to the appropriate page based on user type
  if ($user['user_type'] === 'admin') {
    header('Location: admindashboard.php');
    exit();
  } else if ($user['user_resident'] === 'non-resident') {
    header('Location: guesthome.php');
    exit();
  } else {
    header('Location: home.php');
    exit();
  }
} else {
  echo "Invalid username or password.";
}
  }

mysqli_close($conn);
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <style>
    *{
    font-family: sans-serif;
    box-sizing: border-box;
    
}


    
    body {
      background: linear-gradient(to bottom, #5158BB, #F3B61F, #DF2935);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

   form {
       background-color: white;
       padding: 50px;
       border-radius: 10px;
       box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
       max-width: 400px;
       width: 100%;
   }

   h2 {
       text-align: center;
       margin-bottom: 30px;
   }

   label {
       display: block;
       margin-bottom: 10px;
   }

   input {
       width: 100%;
       padding: 10px;
       margin-bottom: 20px;
       border: none;
       border-radius: 5px;
       box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
   }

   button {
       display: block;
       width: 100%;
       padding: 10px;
       margin-top: 20px;
       border: none;
       border-radius: 5px;
       background-color: #1690a7;
       color: white;
       font-size: 18px;
       font-weight: bold;
       cursor: pointer;
       transition: background-color 0.3s;
   }

   button:hover {
       background-color: #136d83;
   }

   .error {
       color: red;
       margin-bottom: 10px;
   }


  </style>
</head>
<body>
  

 

  <form method="post" action="login.php">
    <?php if (isset($error_msg)): ?>
    <p><?php echo $error_msg; ?></p>
  <?php endif; ?>
  
    <center> <img src="assets/images/brgylogo.png" style="width: 100px;"></center>
    <label for="username">Username:</label>
    <input type="text" name="username" required autocomplete="off"><br><br>

    <label for="password">Password:</label>
    <input type="password" name="password" required autocomplete="off"><br><br>

    <button type="submit" value="Login">Login</button>
    <p>No account yet? <a href="register.php">Register here </a></p>
  </form>
</body>
</html>