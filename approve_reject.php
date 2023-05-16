<?php
require 'C:\Users\Patrick\Downloads\BARANGAY BAGBAG EVENT\Activities-and-Event-Registration\PHPmailer\src\Exception.php';
require 'C:\Users\Patrick\Downloads\BARANGAY BAGBAG EVENT\Activities-and-Event-Registration\PHPmailer\src\PHPMailer.php';
require 'C:\Users\Patrick\Downloads\BARANGAY BAGBAG EVENT\Activities-and-Event-Registration\PHPmailer\src\SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



// Include database connection file
include('db_conn.php');

// Get form data
$request_id = $_POST['request_id'];
$approval_status = $_POST['approval_status'];

// Update approval_status in tbl_small_occasion
$query = "UPDATE tbl_small_occasion SET approval_status = ? WHERE request_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "si", $approval_status, $request_id);
mysqli_stmt_execute($stmt);

// Retrieve email from tbl_small_occasion table
$query = "SELECT request_email FROM tbl_small_occasion WHERE request_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $request_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$to = $row['request_email'];

// Retrieve request_title from tbl_small_occasion table
$query = "SELECT request_title FROM tbl_small_occasion WHERE request_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $request_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$request_title = $row['request_title'];

$query = "SELECT last_name FROM tbl_small_occasion WHERE request_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $request_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$last_name = $row['last_name'];



// Check if email is valid
if (isset($to) && filter_var($to, FILTER_VALIDATE_EMAIL)) {
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    // Server settings
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'baranggaymapulanglupa@gmail.com';
    $mail->Password = 'nvgeadocuwfaohao';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    // Recipients
    $mail->setFrom('baranggaymapulanglupa@gmail.com', 'Admin_Barangay_Mapulanglupa');
    $mail->addAddress($to);

    // Content
    $mail->isHTML(false);

    if ($approval_status == 'approved') {
        $mail->Subject = "Request Approved";
        $mail->Body = "
Dear Mr/Ms $last_name,
        
We are glady to inform you that your recent request ($request_title) has been approved by our administration. After careful review of your request, we have determined that we can accommodate your request at this time.

Please wait for one of our workers to contact you for further discussion of the matter or would you like visit us at the Barangay Hall. Our office hours are open 24/7. 
        
Alternatively, you may also contact us at 
baranggaymapulanglupa@gmail.com or through our Facebook page at https://www.facebook.com/bagongmapulanglupa2018.
Thank you for your understanding and cooperation.
        
Sincerely,
Baranggay Mapulang Lupa Administration:\n\n" ;
       
    } else if ($approval_status == 'rejected') {
        $mail->Subject = "Request Rejected";
        $mail->Body = "
Dear Mr/Ms $last_name,
        
We regret to inform you that your recent request ($request_title) has been rejected by our administration. After careful review of your request, we have determined that we are unable to accommodate it at this time.

If you have any questions or would like to discuss the matter further, please feel free to visit us at the Barangay Hall. Our office hours are open 24/7. 

Alternatively, you may also contact us at 
baranggaymapulanglupa@gmail.com or through our Facebook page at https://www.facebook.com/bagongmapulanglupa2018.
Thank you for your understanding and cooperation.

Sincerely,
Baranggay Mapulang Lupa Administration:\n\n" ;
    }

    try {
        $mail->send();
    } catch (Exception $e) {
        
        
    }
} else {
    echo "<p>Error: Email is not set or not valid. Please make sure all required fields are filled.</p>";
   
}

mysqli_close($conn);
?>
<script>
    alert('Email sent succesfully');
    window.location.href = 'adminpending.php';
</script>