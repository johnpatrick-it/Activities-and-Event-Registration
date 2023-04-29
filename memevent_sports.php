<?php
session_start();

    include('db_conn.php');

?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>Barangay Mapulang Lupa - Valenzuela City</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-digimedia-v1.css">
    <link rel="stylesheet" href="assets/css/animated.css">
    <link rel="stylesheet" href="assets/css/owl.css">
<!--

TemplateMo 568 DigiMedia

https://templatemo.com/tm-568-digimedia

-->
<!-- Custom styles -->
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
        p{
            color: #020202;
        }
        
	</style>
  </head>

<body>

  

  <!-- Pre-header Starts -->
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
  <!-- Pre-header End -->

  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav class="main-nav">
           
            <!-- ***** Logo End ***** -->
            <!-- ***** Menu Start ***** -->
            <ul class="nav">
              <li><a href="memberevent.php" >All Events</a></li>
              <li><a href="memevent_seminar.php" >Seminars</a></li>
              <li><a href="memevent_meeting.php" >Meeting</a></li>
              <li><a href="memevent_webinar.php">Webinar</a></li>
              <li><a href="memevent_sports.php"class="active" >Sports</a></li>
              <li><a href="memevent_comservice.php">Community Service</a></li>

              <li><a href="residentrequest.php" style="color: green; font-weight: bold;">Request</a></li>
             <li><div class="border-first-button"><a href="home.php">Back to Home</a></div></li> 
              
            </ul>        
            <a class='menu-trigger'>
                <span>Menu</span>
            </a>
            <!-- ***** Menu End ***** -->
          </nav>
        </div>
      </div>
    </div>
  </header>
  <body>
<body>
    <div class="container">
		<h1>Events</h1>
		<hr>
		<div class="row">
			<?php
			// Select all events from the tbl_event table where event_Type is Seminars
			$sql = "SELECT * FROM tbl_event WHERE event_Type = 'Sports'";
			$result = mysqli_query($conn, $sql);

			// Check if there are any events
			if (mysqli_num_rows($result) > 0) {
				// Loop through each event and display the details
				while ($row = mysqli_fetch_assoc($result)) {
					echo '<div class="col-sm-6 mb-4">';
					echo '<div class="card">';
					if (!empty($row['event_poster'])) {
						echo '<a href="' . $row['event_poster'] . '"><img src="' . $row['event_poster'] . '" class="card-img-top"></a>';
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
						echo '<a href="mem_register.php?event_id=' . $row['event_id'] . '" class="btn btn-primary">Register</a>';
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
				echo 'No seminars found.';
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
