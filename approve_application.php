<?php
include("db.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-7.1.1/src/Exception.php';
require 'PHPMailer-7.1.1/src/PHPMailer.php';
require 'PHPMailer-7.1.1/src/SMTP.php';

$id = $_POST['id'];
$status = $_POST['status'];
$remark = $_POST['remark'];

// Update status & remark
$conn->query("UPDATE applicants SET status='$status', officer_remark='$remark' WHERE id=$id");

// Fetch applicant details
$res = $conn->query("SELECT * FROM applicants WHERE id=$id");
$row = $res->fetch_assoc();

$email = $row['email'];
$name  = $row['name'];

$subject = "MahaBuildNOC - Application Status Update";

if ($status == "Approved") {

    $message = "
    Dear $name,<br><br>

    <h3 style='color:green;'>Congratulations!</h3>

    Your <b>Building Permission NOC</b> application has been <b>Approved</b>.<br><br>

    <b>Officer Remark:</b> $remark <br><br>

    You can download your NOC certificate from the portal.<br><br>

    <a href='http://localhost:8888/mahabuildnoc/check_status.php'>
    Click here to Check Status
    </a>

    <br><br>

    Regards,<br>
    Government of Maharashtra<br>
    MahaBuildNOC
    ";

} else {

    $message = "
    Dear $name,<br><br>

    <h3 style='color:red;'>Application Rejected</h3>

    Your Building Permission NOC application has been Rejected.<br><br>

    <b>Officer Remark:</b> $remark

    <br><br>

    Regards,<br>
    Government of Maharashtra<br>
    MahaBuildNOC
    ";
}

$mail = new PHPMailer(true);

try{

    $mail->isSMTP();

    $mail->Host = 'smtp.gmail.com';

    $mail->SMTPAuth = true;

    $mail->Username = 'vidulayeole66@gmail.com';

    $mail->Password = 'YOUR_APP_PASSWORD';

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

    $mail->Port = 587;

    $mail->setFrom('vidulayeole66@gmail.com','MahaBuildNOC');

    $mail->addAddress($email,$name);

    $mail->isHTML(true);

    $mail->Subject = $subject;

    $mail->Body = $message;

    $mail->send();

    echo "<script>
    alert('Application Updated & Email Sent Successfully');
    window.location='officier_dashboard.php';
    </script>";

}
catch(Exception $e){

    echo "<script>
    alert('Mailer Error : ".$mail->ErrorInfo."');
    window.location='officier_dashboard.php';
    </script>";

}
?>