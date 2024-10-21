<?php
require_once(__DIR__ . '/../models/db.php');
require(__DIR__ . '/../models/task.php');  
require(__DIR__ . '/../models/project.php');
require(__DIR__ . '/../models/user.php');
require(__DIR__ . '/../libraries/taskLibrary.php');
require_once(__DIR__ . '/../../send_email.php');

$action = filter_input(INPUT_POST, 'action');

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     var_dump($_POST);  // This will show the submitted form data
// }

class taskController {

    public function index() {
        session_start();

    // ako ne si logiran te nosi tuka
    if (!isset($_SESSION['username'])) {
        echo $_SESSION['username'];
        header("Location: app/views/login_register/login_index.php");
        exit();
    }
        header("Location: app/views/tasks/index.php");
    }
}

$controller = new taskController();

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

    $created_by = $_COOKIE['user_id'];  

    add_task($title, $description, $priority, $due_date, $project_id, $created_by, $assigned_to);
    
    $task = [
        'title' => $title,
        'description' => $description,
        'due_date' => $due_date
    ];

    $email = get_user_email($assigned_to);

    send_email($task, $email);

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

    edit_task($id, $title, $description, $status, $priority, $due_date, $project_id, $assigned_to);

    header("Location: ../views/tasks/index.php");

} elseif ($action == 'filter') {
    // Debugging output
    echo "<pre>";
    print_r($_GET); // Print the filter parameters
    echo "</pre>";

    // Get filter inputs
    $taskName = filter_input(INPUT_GET, 'taskName', FILTER_SANITIZE_STRING);
    $dueDate = filter_input(INPUT_GET, 'dueDate', FILTER_SANITIZE_STRING);
    $priority = filter_input(INPUT_GET, 'priority', FILTER_SANITIZE_STRING);

    // Start with the base SQL query
    $sql = "SELECT * FROM task WHERE 1=1";
    $params = [];
    $types = ''; // String to hold types of the parameters

    // Add conditions based on user inputs
    if (!empty($taskName)) {
        $sql .= " AND title LIKE ?";
        $params[] = "%$taskName%"; // Add parameter
        $types .= 's'; // 's' for string
    }

    if (!empty($dueDate)) {
        $sql .= " AND due_date = ?";
        $params[] = $dueDate; // Add parameter
        $types .= 's'; // 's' for string
    }

    if (!empty($priority)) {
        $sql .= " AND status = ?";
        $params[] = $priority; // Add parameter
        $types .= 's'; // 's' for string
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
        include '../views/tasks/index.php'; // Adjust this path as necessary
        exit; // Exit after including the view
    }
} else echo "fail";