<?php
require('../models/db.php');  
require('../models/project.php');  

$action = filter_input(INPUT_POST, 'action');

if ($action == 'add') {
    $name = $_POST['project'];
    $description = $_POST['description'];
    $created_by = 1;
    $created_at = $_POST('created_at');

    add_project($name, $description, $created_by, $created_at);

    header("Location: ../views/projects/index.php");

} elseif ($action == 'delete') {
    $id = $_POST['id'];

    delete_project($id);

    header("Location: ../views/projects/index.php");

} elseif ($action == "edit") {
    $id = $_POST['id'];
    $name = $_POST['project'];
    $description = $_POST['description'];
    $created_at = $_POST['created_at'];
    $created_by = 1;
    

    edit_project($id, $name, $description, $created_at, $created_by);

    header("Location: ../views/projects/index.php");

} else {
    echo "Invalid action";
}
?>
