<?php
include 'db_conn.php';

$sql = "SELECT tbl_eventreg.*, tbl_event.event_title 
        FROM tbl_eventreg
        INNER JOIN tbl_event ON tbl_eventreg.event_joined = tbl_event.event_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  while($row = mysqli_fetch_assoc($result)) {
    echo "Registration ID: " . $row["reg_id"]. "<br>";
    echo "Event title: " . $row["event_title"]. "<br>";
    echo "First name: " . $row["first_name"]. "<br>";
    echo "Last name: " . $row["last_name"]. "<br>";
    echo "Birthday: " . $row["birthday"]. "<br>";
    echo "Age: " . $row["age"]. "<br>";
    echo "Sex: " . $row["sex"]. "<br>";
    echo "Address: " . $row["address"]. "<br>";
    echo "<br>";
  }
} else {
  echo "No results found";
}

mysqli_close($conn);

?>
