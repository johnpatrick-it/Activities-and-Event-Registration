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
    $mail->setFrom('baranggaymapulanglupa@gmail.com', 'admin_barangay_mapulanglupa');
    $mail->addAddress($to);

    // Content
    $mail->isHTML(false);

    if ($approval_status == 'approved') {
        $mail->Subject = "Request Approved";
        $mail->Body = "Your request has been approved by the admin.";
    } else if ($approval_status == 'rejected') {
        $mail->Subject = "Request Rejected";
        $mail->Body = "Your request has been rejected by the admin for the following reason:\n\n" ;
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
