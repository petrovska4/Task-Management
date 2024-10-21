<?php
require('../models/db.php');  
require('../models/project.php');  

$action = filter_input(INPUT_POST, 'action');

if (isset($_GET['file_path'])) {
    $file_path = urldecode($_GET['file_path']); // Decode the URL-encoded file path

    // Set headers to initiate a file download
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file_path));

    // Clear output buffer and read the file
    ob_clean();
    flush();
    readfile($file_path);
    exit;
}

if ($action == 'add') {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $created_by = $_COOKIE['user_id'];

    // Check if required fields are not empty
    if (empty($name) || empty($description)) {
        echo "All fields are required.";
        exit; // Exit here to avoid further processing
    }

    $file_path = null;
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $target_dir = '../../uploads/'; // Set your upload directory
        $target_file = $target_dir . basename($_FILES['file']['name']);
        $uploadOk = 1;

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size (example: limit to 2MB)
        if ($_FILES['file']['size'] > 2000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats (example: allow jpg, png, pdf)
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (!in_array($imageFileType, ['jpg', 'png', 'pdf', 'docx'])) {
            echo "Sorry, only JPG, PNG, PDF & DOCX files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            // If everything is ok, try to upload file
            if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
                $file_path = $target_file; // Save the file path to store in the database
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        echo "No file uploaded or there was an upload error.";
        exit;
    }

    add_project($name, $description, $created_by, $file_path);
    
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
    
    edit_project($id, $name, $description);
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
