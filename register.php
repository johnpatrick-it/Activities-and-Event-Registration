<?php

require_once('db_conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $name = $first_name . ' ' . $last_name;
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $user_resident = $_POST['user_resident'];

    $sql = "INSERT INTO `users` (`first_name`, `last_name`, `name`, `username`, `email`, `password`, `user_resident`, `user_type`)
            VALUES (?, ?, ?, ?, ?, ?, ?, 'member')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssssss', $first_name, $last_name, $name, $username, $email, $password, $user_resident);
    $stmt->execute();

    if ($stmt->affected_rows === 1) {
        echo "User registered successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>REGISTER</title>
 	

</head>
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
		background:rgb(235, 235, 239);/*#28a745;*/
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

/**/
  /* Add some margin and padding to the form */
  /* Add some margin and padding to the form */
  form {
    margin: 20px;
    padding: 20px;
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

</style>

<body>

  <main id="main" class=" alert-info">
  		<div id="login-left">
  			<div class="logo">
  				<img src="assets/images/brgylogo.png">
  			</div>
  		</div>
  		<div id="login-right">
  			<div class="w-100">
                
  				<br>
            
  			<div class="card col-md-8">
  				<div class="card-body">
  					<form id="login-form" method="POST" action="register.php">
                        <div>
                            <label for="first_name" style="font-size: large; font-family: sans-serif;">First Name:</label>
                            <input type="text" id="first_name" name="first_name" placeholder="First Name" required>
                          </div>
                          <div>
                            <label for="last_name" style="font-size: large; font-family: sans-serif;">Last Name:</label>
                            <input type="text" id="last_name" name="last_name" placeholder="Last Name" required>
                          </div>
                          <div>
                            <label for="username" style="font-size: large; font-family: sans-serif;">Username:</label>
                            <input type="text" id="username" name="username" placeholder="Username" required>
                          </div>
                          <div>
                            <label for="email" style="font-size: large; font-family: sans-serif;">Email:</label>
                            <input type="email" id="email" name="email" placeholder="Email" required>
                          </div>
                          <div>
                            <label for="password" style="font-size: large; font-family: sans-serif;">Password:</label>
                            <input type="password" id="password" name="password" placeholder="Password" required>
                          </div>
                          <div>
                            <label style="font-size: large; font-family: sans-serif;">Resident:</label>
                            <select name="user_resident" style="border: blue;" required>
                                <option value="">--Select--</option>
                                <option value="non-resident">Non-Resident</option>
                                <option value="resident">Resident</option>
                            </select>
                          </div>
                          <br>
                          <button type="submit">Register</button>
                          <a href="login.php" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px;">Login</a>
                        </form>
  				    </div>
  			    </div>
  		    </div>
   		</div>

  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>


</body>