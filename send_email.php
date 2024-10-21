<?php
require_once "Mail.php"; // Ensure PEAR::Mail is installed and loaded
require_once 'app/models/db.php';

session_start();

function send_email($task, $recipient) {
    // SMTP configuration
    $smtp_host = 'smtp.gmail.com';  // Your SMTP server
    $smtp_username = 'tijanapetrovska173@gmail.com';  // Your email
    $smtp_password = 'pbyavdauuaayxwcn';  // Your email password
    $smtp_port = 587;  // 587 for TLS or 465 for SSL

    // Email headers
    $headers = [
        'From'    => $_SESSION['email'],
        'Subject' => 'New Task Assigned: ' . $task['title'],
        'Content-Type' => 'text/html; charset=UTF-8',
    ];

    // Build the list of recipients
    // $recipients = [];
    // foreach ($assigned_users as $user_id) {
    //     $email = get_user_email($user_id);
    //     if ($email) {
    //         $recipients[] = $email;
    //     }
    // }

    // $recipient = 'pecakovab@gmail.com';

    // Email content
    $body = 'You have been assigned a new task: <strong>' . $task['title'] . '</strong><br>' .
            'Description: ' . $task['description'] . '<br>' .
            'Due Date: ' . $task['due_date'];

    // SMTP parameters
    $smtp_params = [
        'host'     => $smtp_host,
        'port'     => $smtp_port,
        'auth'     => true,
        'username' => $smtp_username,
        'password' => $smtp_password,
    ];

    // Create the mail object
    $mail = Mail::factory('smtp', $smtp_params);

    // Send the email
    // $result = $mail->send(implode(',', $recipients), $headers, $body);
    $result = $mail->send($recipient, $headers, $body);

    if (PEAR::isError($result)) {
        echo 'Email sending failed: ' . $result->getMessage();
    } else {
        echo 'Email sent successfully!';
    }
}