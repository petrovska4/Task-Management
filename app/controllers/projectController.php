<?php
require('../models/db.php');  
require('../models/project.php');  

$action = filter_input(INPUT_POST, 'action');

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     var_dump($_POST);  // This will show the submitted form data
// }

if($action == 'add') {
    $name = $_POST['project'];
    $description = $_POST['description'];
    $created_by = 1;  

    add_project($name, $description, $created_by);

    header("Location: ../views/projects/index.php");

} elseif($action == 'delete') {
    $id = $_POST['id'];

    delete_project($id);

    header("Location: ../views/projects/index.php");
} else echo "fail";
?>
