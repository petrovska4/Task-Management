<?php
require('../models/db.php');  
require('../models/project.php');  

$action = filter_input(INPUT_POST, 'action');

if ($action == 'add') {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $created_by = 1;

    // Check if required fields are not empty
    if (empty($name) || empty($description)) {
        echo "All fields are required.";
        exit; // Exit here to avoid further processing
    }

    add_project($name, $description, $created_by);
    
    // Redirect after successful addition
    header("Location: ../views/projects/index.php");
    exit;
    //header("Location: ../views/projects/index.php");

} elseif ($action == 'delete') {

        $id = $_POST['id'];
        //echo "Attempting to delete project with ID: $id"; // Debugging line
        delete_project($id);
        header("Location: ../views/projects/index.php");
        exit;
    
} elseif ($action == "edit") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $created_by = 1;
    
    edit_project($id, $name, $description, $created_by);
    header("Location: ../views/projects/index.php");
} elseif ($action == 'filter') {
    // Debugging output
    echo "<pre>";
    print_r($_GET); // Print the filter parameters
    echo "</pre>";

    // Get filter inputs
    $projectName = filter_input(INPUT_GET, 'projectName', FILTER_SANITIZE_STRING);
    $createdBy = filter_input(INPUT_GET, 'createdBy', FILTER_SANITIZE_STRING);
    

    // Start with the base SQL query
    $sql = "SELECT * FROM task WHERE 1=1";
    $params = [];
    $types = ''; // String to hold types of the parameters

    // Add conditions based on user inputs
    if (!empty($projectName)) {
        $sql .= " AND title LIKE ?";
        $params[] = "%$projectName%"; // Add parameter
        $types .= 's'; // 's' for string
    }

    if (!empty($createdBy)) {
        $sql .= " AND created_by = ?";
        $params[] = $createdBy; // Add parameter
        $types .= 'i'; // 's' for string
    }

    // Prepare the statement
    $statement = $db->prepare($sql);
    if (!empty($params)) {
        $statement->bind_param($types, ...$params); // Bind parameters
    }

    // Execute the statement
    if (!$statement->execute()) {
        echo "SQL error: " . $statement->error; // Debugging output
    } else {
        $result = $statement->get_result(); // Get the result set
        $rows = $result->fetch_all(MYSQLI_ASSOC); // Fetch rows

        // Check if there are rows
        if (empty($rows)) {
            echo "No tasks found.";
        }

        // You can now pass $rows to the view that displays tasks
        include '../views/projects/index.php'; // Adjust this path as necessary
        exit; // Exit after including the view
    }
}
 else {
    echo "Invalid action";
}
?>
