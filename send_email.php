<?php
require_once "Mail.php";
require_once 'app/models/db.php';

session_start();

function send_email($task, $recipient) {
    $smtp_host = 'smtp.gmail.com';
    $smtp_username = 'tijanapetrovska173@gmail.com';
    $smtp_password = 'pbyavdauuaayxwcn';
    $smtp_port = 587;

    $headers = [
        'From'    => $_SESSION['email'],
        'Subject' => 'New Task Assigned: ' . $task['title'],
        'Content-Type' => 'text/html; charset=UTF-8',
    ];

    $body = 'You have been assigned a new task: <strong>' . $task['title'] . '</strong><br>' .
            'Description: ' . $task['description'] . '<br>' .
            'Due Date: ' . $task['due_date'];

    $smtp_params = [
        'host'     => $smtp_host,
        'port'     => $smtp_port,
        'auth'     => true,
        'username' => $smtp_username,
        'password' => $smtp_password,
    ];

    $mail = Mail::factory('smtp', $smtp_params);

    $result = $mail->send($recipient, $headers, $body);

    if (PEAR::isError($result)) {
        echo 'Email sending failed: ' . $result->getMessage();
    } else {
        echo 'Email sent successfully!';
    }
}