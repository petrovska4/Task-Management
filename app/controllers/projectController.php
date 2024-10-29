<?php
require('../models/db.php');  
require('../models/project.php');  

$action = filter_input(INPUT_POST, 'action');

if (isset($_GET['file_path'])) {
    $file_path = urldecode($_GET['file_path']); 

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file_path));

    ob_clean();
    flush();
    readfile($file_path);
    exit;
}

if ($action == 'add') {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $created_by = $_COOKIE['user_id'];

    if (empty($name) || empty($description)) {
        echo "All fields are required.";
        exit;
    }

    $file_path = null;
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $target_dir = '../../uploads/';
        $target_file = $target_dir . basename($_FILES['file']['name']);
        $uploadOk = 1;

        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        if ($_FILES['file']['size'] > 2000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (!in_array($imageFileType, ['jpg', 'png', 'pdf', 'docx'])) {
            echo "Sorry, only JPG, PNG, PDF & DOCX files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES['file']['tmp_name'], $target_file)) {
                $file_path = $target_file;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        echo "No file uploaded or there was an upload error.";
        exit;
    }

    add_project($name, $description, $created_by, $file_path);
    
    header("Location: ../views/projects/index.php");
    exit;

} elseif ($action == 'delete') {

        $id = $_POST['id'];
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
    echo "<pre>";
    print_r($_GET);
    echo "</pre>";

    $projectName = filter_input(INPUT_GET, 'projectName', FILTER_SANITIZE_STRING);
    $createdBy = filter_input(INPUT_GET, 'createdBy', FILTER_SANITIZE_STRING);
    

    $sql = "SELECT * FROM task WHERE 1=1";
    $params = [];
    $types = '';

    if (!empty($projectName)) {
        $sql .= " AND title LIKE ?";
        $params[] = "%$projectName%";
        $types .= 's';
    }

    if (!empty($createdBy)) {
        $sql .= " AND created_by = ?";
        $params[] = $createdBy;
        $types .= 'i';
    }

    $statement = $db->prepare($sql);
    if (!empty($params)) {
        $statement->bind_param($types, ...$params);
    }

    if (!$statement->execute()) {
        echo "SQL error: " . $statement->error;
    } else {
        $result = $statement->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        if (empty($rows)) {
            echo "No tasks found.";
        }

        include '../views/projects/index.php';
        exit;
    }
}
 else {
    echo "Invalid action";
}
?>
