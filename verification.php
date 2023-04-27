<?php
// Include the database connection file
include('db_conn.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>User Verification Form</title>
	<style>
		table, th, td {
			border: 1px solid black;
			border-collapse: collapse;
			padding: 5px;
			text-align: center;
		}

		th {
			background-color: #ddd;
		}

		label {
			display: block;
			margin-top: 10px;
		}
	</style>
</head>
<body>
	<h1>User Verification Form</h1>
	<?php
	// Retrieve user data from the database
	$sql = "SELECT * FROM users";
	$result = mysqli_query($conn, $sql);

	// Display user data in a table
	if (mysqli_num_rows($result) > 0) {
		echo '<table>';
		echo '<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Name</th><th>Username</th><th>Email</th><th>Password</th><th>User Type</th><th>User Resident</th><th>User Proof</th></tr>';
		while ($row = mysqli_fetch_assoc($result)) {
			echo '<tr><td>' . $row['id'] . '</td><td>' . $row['first_name'] . '</td><td>' . $row['last_name'] . '</td><td>' . $row['name'] . '</td><td>' . $row['username'] . '</td><td>' . $row['email'] . '</td><td>' . $row['password'] . '</td><td>' . $row['user_type'] . '</td><td>' . $row['user_resident'] . '</td><td>' . ($row['user_proof'] ? '<img src="data:image/jpeg;base64,' . base64_encode($row['user_proof']) . '"/>' : '') . '</td></tr>';
		}
		echo '</table>';
	} else {
		echo 'No users found.';
	}
	?>

	<form method="post" enctype="multipart/form-data">
		<label for="user_proof">User Proof:</label>
		<input type="file" name="user_proof" accept="image/*">
		<input type="submit" name="submit" value="Submit">
	</form>

	<?php
	// Handle form submission
	if (isset($_POST['submit'])) {
		$user_proof = addslashes(file_get_contents($_FILES['user_proof']['tmp_name']));

		// Update user proof in the database
		$sql = "UPDATE users SET user_proof='$user_proof' WHERE id=1"; // replace 1 with the user ID of the logged-in user
		mysqli_query($conn, $sql);
	}
	?>

</body>
</html>
