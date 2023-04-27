<?php
// Include the database connection file
include('db_conn.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Events</title>
	<!-- Include Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css\event.css">
    <style>
 		body {
			font-family: 'Montserrat', sans-serif;
		}
		.card-img-top {
			height: 300px;
			object-fit: cover;
		}
		.box {
			padding: 5px;
			color: #fff;
			font-weight: bold;
			border-radius: 5px;
			text-align: center;
			margin-bottom: 10px;
		}
		.upcoming-box {
			background-color: #28a745;
		}
		.done-box {
			background-color: #dc3545;
		}
		.card {
			margin-bottom: 0;
		}
		.card-body {
			padding: 20px;
			display: flex;
			flex-direction: column;
		}
		.card-text {
			margin-bottom: 5px;
		}
		.row {
			margin-right: 0;
			margin-left: 0;
		}
		.col-sm-6 {
			padding-right: 0;
			padding-left: 0;
		}
    </style>
</head>
<body>
	<div class="container">
		<h1>Events</h1>
		<hr>
		<div class="row">
			<?php
			// Select all events from the tbl_event table
			$sql = "SELECT * FROM tbl_event";
			$result = mysqli_query($conn, $sql);

			// Check if there are any events
			if (mysqli_num_rows($result) > 0) {
				// Loop through each event and display the details
				while ($row = mysqli_fetch_assoc($result)) {
					echo '<div class="col-sm-6 mb-4">';
					echo '<div class="card">';
					if (!empty($row['event_poster'])) {
						echo '<img src="' . $row['event_poster'] . '" class="card-img-top">';
					}
					echo '<div class="card-body">';
					echo '<h5 class="card-title">' . $row['event_title'] . '</h5>';
					echo '<p class="card-text">' . $row['event_description'] . '</p>';
					echo '<p class="card-text">Date: ' . $row['event_date'] . '</p>';
					echo '<p class="card-text">Limit: ' . $row['event_limit'] . '</p>';
					echo '<p class="card-text">Date Created: ' . $row['event_DateCreated'] . '</p>';
					echo '<p class="card-text">Type: ' . $row['event_Type'] . '</p>';
					echo '<p class="card-text">Covered: ' . $row['event-covered'] . '</p>';
					
					// Check if the event is upcoming or done based on event_date
					if (strtotime($row['event_date']) > time()) {
						// Upcoming event
						echo '<div class="box upcoming-box">Upcoming</div>';
						
						// Check if event is residents-only
						if ($row['event-covered'] == "residents-only") {
							echo '<a class="btn btn-primary disabled">Residents Only</a>';
						} else {
							echo '<a href="register.php?event_id=' . $row['event_id'] . '" class="btn btn-primary">Register</a>';
						}
						
					} else {
						// Done event
						echo '<div class="box done-box">Done</div>';
						echo '<a class="btn btn-primary disabled">Register</a>';
					}
					
					echo '</div>';
					echo '</div>';
					echo '</div>';
				}
			} else {
				echo 'No events found.';
			}

			// Close the database connection
			mysqli_close($conn);

			?>
		</div>
	</div>

	<!-- Include Bootstrap JS and jQuery -->
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>

</body>
</html>
