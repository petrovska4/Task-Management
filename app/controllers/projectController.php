<?php
require('../models/db.php');  
require('../models/project.php');  

$action = filter_input(INPUT_POST, 'action');

if ($action == 'add') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $created_by = 1;  

    add_project($name, $description, $created_by);

    header("Location: ../views/projects/index.php");

} elseif ($action == 'delete') {
    $id = $_POST['id'];

    delete_project($id);

    header("Location: ../views/projects/index.php");
} elseif ($action == "edit") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $created_by = 1;
    
    edit_project($id, $name, $description, $created_by);
    header("Location: ../views/projects/index.php");
} else {
    echo "Invalid action";
}
?>
