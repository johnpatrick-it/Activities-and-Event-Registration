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

if ($approval_status == 'approved') {
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
        // Rest of the PHPMailer code here to send notification email
    } else {
        echo "<p>Error: Email is not set or not valid. Please make sure all required fields are filled.</p>";
        exit;
    }
}


    $subject = "Request Approved";
    $message = "Your request has been approved by the admin.";

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Replace with your SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'BaranggayMapulangLupa@gmail.com';  // Replace with your SMTP username
        $mail->Password = 'likpo123456789';  // Replace with your SMTP password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('BaranggayMapulangLupa@gmail.com', 'Admin');
        $mail->addAddress($to);

        // Content
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
    } catch (Exception $e) {
        $mail->ErrorInfo;
        
    }

if ($approval_status == 'rejected') {
    // Get reject reason from form
     // Retrieve email from tbl_small_occasion table
     $query = "SELECT request_email FROM tbl_small_occasion WHERE request_id = ?";
     $stmt = mysqli_prepare($conn, $query);
     mysqli_stmt_bind_param($stmt, "i", $request_id);
     mysqli_stmt_execute($stmt);
     $result = mysqli_stmt_get_result($stmt);
     $row = mysqli_fetch_assoc($result);
     $to = $row['request_email']; 
    $reject_reason = $_POST['reject_reason'];

    // Send notification to user for rejection
    $to = $_POST['request_email'];
    $subject = "Request Rejected";
    $message = "Your request has been rejected by the admin for the following reason:\n\n" . $reject_reason;

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Replace with your SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'BaranggayMapulangLupa@gmail.com';  // Replace with your SMTP username
        $mail->Password = 'likpo123456789';  // Replace with your SMTP password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('BaranggayMapulangLupa@gmail.com', 'Admin');
        $mail->addAddress($to);

        // Content
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
}
// Close database connection
mysqli_close($conn);
?>
<script>
    alert('Request updated successfully');
    window.location.href = 'admindashboard.php';
</script>

