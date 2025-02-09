<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('db_connection.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);


function send_password_reset($get_name, $get_email,$password, $flag)
{ 
    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = 0;                      
        $mail->isSMTP();                                           
        $mail->Host       = 'smtp.gmail.com';                      
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = '22b01a0570@svecw.edu.in';                
        $mail->Password   = 'Harshi#2005';                
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         
        $mail->Port       = 587;                                    

        $mail->setFrom('22b01a0570@svecw.edu.in', 'Art Gallery Admin');
        $mail->addAddress($get_email);                              
       
        $mail->isHTML(true); 
        if($flag == 'true'){                               
        $mail->Subject = '"Congratulations! Your Artist Registration Has Been Approved"';
        $mail->Body    = "

            <h2>Dear $get_name,</h2>
            <p>We are delighted to inform you that your registration as an artist has been approved! After reviewing your application, we were impressed by your talents and achievements. We are excited to welcome you to our platform.</p>
            <p>Here are your login credentials:</p>
            <p>Username: $get_name  </p>
            <p>Password: $password</p>
            <p>You can now log in to your account and start showcasing your art to a wider audience. We are looking forward to seeing your contributions and wish you all the best in your artistic journey with us.</p>
            <p>Best regards, <br> Admin.</p>
        ";
        }
        else if($flag == 'false'){
            $mail->Subject = '"Update on Your Artist Registration Application"';
            $mail->Body    = "
            <h2>Dear $get_name,</h2>
            <p>Thank you for your interest in joining our platform and for taking the time to submit your registration. After careful consideration, we regret to inform you that your application has not been approved at this time.</p>
            <p>This decision was made based on a thorough review of the provided information and current platform requirements. We encourage you to continue honing your craft and consider reapplying in the future.</p>
            <p>Thank you for your understanding.</p>
            <p>Best regards,<br> Admin.</p>
            ";
        }
        else if($flag == 'acceptReq'){
            $mail->Subject = '"Order Confirmation"';
            $mail->Body    = "
            <h2>Dear $get_name,</h2>
            <p>We are excited to inform you that your order has been successfully placed.</p>
            <p>Thank you for your support and enthusiasm for our artist's work. We hope this piece brings you great joy and inspiration.</p>
            <p>Best regards,<br> Admin. </p>
            ";
        }
        else if($flag == 'denyReq'){
            $mail->Subject = '"Update on Your Purchase Request"';
            $mail->Body    = "
            <h2>Dear $get_name,</h2>
            <p>Thank you for your interest in purchasing our arts </p>
            <p>After careful consideration, we regret to inform you that our artist has decided not to proceed with the sale of this artwork at this time. We understand this may be disappointing news and we apologize for any inconvenience this may cause.</p>
            <p>Please know that we greatly appreciate your enthusiasm for our artist's work, and we hope you will continue to explore other artworks available in our gallery.</p>
            <p>Thank you for your understanding.</p>
            <p>Best regards,<br> Admin. </p>
            ";
        }
        else{
             $mail->Subject = '"Important: Your Artist Account Status"';
             $mail->Body    = " 


             <p>We regret to inform you that your account on our platform has been removed, effective immediately. This decision was made after careful consideration and is in accordance with our platform's policies and guidelines.</p>
             <p>Please understand that this action was not taken lightly, and it follows a thorough review process. We value the contributions of all our artists and are committed to maintaining the standards and integrity of our platform.</p>
             <p>Thank you for your understanding.</p>
             <p>Best regards,<br> Admin</p>
             ";
        }
        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function sendEmail($get_name,$get_email,$pass,$flag){
        send_password_reset($get_name,$get_email,$pass,$flag);
        if($flag == 'delete'){
            header("Location:manageArtist.php");
        }
        else if($flag == 'true' ||  $flag == 'false'){
            header("Location:artistReqDisplay.php");
        }
        else{
            header("Location:productReqDisplay.php");
        }
       
        exit(0);
}


?>