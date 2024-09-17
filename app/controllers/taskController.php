<?php
require('../models/db.php');  
require('../models/task.php');  

$action = filter_input(INPUT_POST, 'action');

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     var_dump($_POST);  // This will show the submitted form data
// }

if($action == 'add') {
    echo "success";
    $title = $_POST['task'];
    $description = $_POST['description'];
    $due_date = $_POST['due'];
    $project_id = $_POST['project'];
    $assigned_to = $_POST['assigned_to'];

    $status = 'Pending';  
    $priority = 'Normal'; 
    $created_by = 1;  

    add_task($title, $description, $status, $priority, $due_date, $project_id, $created_by, $assigned_to);

    echo "Task successfully added!";
    header("Location: ../views/tasks/index.php");

} else echo "fail";
?>
