<?php
// require('../../models/db.php');  // Assuming you have a file to connect to the database
require('../../models/task.php');  // Including the model file you shared
include '../../models/db.php';

// if ($_POST['action'] === 'add') {
if (isset($_POST['add'])) {
    echo "success";
    $title = $_POST['task'];
    $description = $_POST['description'];
    $due_date = $_POST['due'];
    $project_id = $_POST['project'];
    $assigned_to = $_POST['assign'];

    $status = 'Pending';  // Default status (you can modify this as needed)
    $priority = 'Normal'; // Default priority
    $created_by = 1;  // Assuming a fixed user ID for "created_by", adjust this based on your app's logic

    add_task($title, $description, $status, $priority, $due_date, $project_id, $created_by, $assigned_to);

    // header("Location: ../index.php");
    // exit;
}
?>
