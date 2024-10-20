<?php
require 'vendor/autoload.php'; // Ensure you load Composer's autoload if using PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function send_email($task, $assigned_users) {
    $mail = new PHPMailer(true);
    
    try {
        // SMTP settings (Configure your SMTP settings)
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com'; // Your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'your-email@example.com'; // Your email
        $mail->Password = 'your-email-password'; // Your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587; // or 465 for SSL

        // Email content
        $mail->setFrom('your-email@example.com', 'Task Management');
        $mail->Subject = 'New Task Assigned: ' . $task['title'];

        // Add all assigned users to the email
        foreach ($assigned_users as $user_id) {
            $email = get_user_email($user_id); // Fetch email for each user
            if ($email) {
                $mail->addAddress($email); // Add each user's email
            }
        }

        // Content of the email
        $mail->isHTML(true);
        $mail->Body = 'You have been assigned a new task: <strong>' . $task['title'] . '</strong><br>' .
                      'Description: ' . $task['description'] . '<br>' .
                      'Due Date: ' . $task['due_date'];

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
