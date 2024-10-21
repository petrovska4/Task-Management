<?php
require_once('send_email.php');

$task = [
    'title' => 'Sample Task',
    'description' => 'This is a description of the task.',
    'due_date' => '2024-10-22'
];

send_email($task, 9); // Call the function to send the email
