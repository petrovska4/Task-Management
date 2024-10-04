<?php
require('../models/db.php');  
require('../models/task.php');  
require('../models/project.php');
require('../libraries/taskLibrary.php');

$action = filter_input(INPUT_POST, 'action');

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     var_dump($_POST);  // This will show the submitted form data
// }

if($action == 'add') {
    $title = $_POST['task'];
    $description = $_POST['description'];
    $priority = $_POST['priority'];
    $due_date = $_POST['due_date'];
    $project_id = $_POST['project'];
    $assigned_to = $_POST['assigned_to'];

    if(taskLibrary::validateDates($due_date) == false) {
        echo "Invalid date.";
        header("Location: ../views/tasks/index.php");
        exit;
    }

    if(!project_exists($project_id)){
        echo "Project does not exist.";
        header("Location: ../views/tasks/index.php");
        exit;
    } 

    $created_by = 1;  

    add_task($title, $description, $priority, $due_date, $project_id, $created_by, $assigned_to);

    header("Location: ../views/tasks/index.php");

} elseif($action == 'delete') {
    $id = $_POST['id'];

    delete_task($id);

    header("Location: ../views/tasks/index.php");
} elseif($action == "edit") {
    $id = $_POST['id'];
    $title = $_POST['task'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $priority = $_POST['priority'];
    $due_date = $_POST['due_date'];
    $project_id = $_POST['project'];
    $assigned_to = $_POST['assigned_to'];

    if(!taskLibrary::validateDates($due_date)) {
        echo "Invalid date.";
        header("Location: ../views/tasks/index.php");
        exit;
    }

    $created_by = 1;  

    edit_task($id, $title, $description, $status, $priority, $due_date, $project_id, $created_by, $assigned_to);

    header("Location: ../views/tasks/index.php");

} else echo "fail";
?>
