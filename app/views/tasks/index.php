<?php 
include '../../models/db.php'; 
include '../../models/project.php'; 
include '../../models/user.php';
session_start();

$taskName = filter_input(INPUT_GET, 'taskName', FILTER_SANITIZE_STRING);
$dueDate = filter_input(INPUT_GET, 'dueDate', FILTER_SANITIZE_STRING);
$priority = filter_input(INPUT_GET, 'priority', FILTER_SANITIZE_STRING);

$sql = "SELECT * FROM task WHERE 1=1";

if ($taskName) {
    $sql .= " AND title LIKE '%" . $db->real_escape_string($taskName) . "%'";
}
if ($dueDate) {
    $sql .= " AND due_date = '" . $db->real_escape_string($dueDate) . "'";
}
if ($priority) {
    $sql .= " AND priority = '" . $db->real_escape_string($priority) . "'";
}

$rows = $db->query($sql);
?>

<?php
$sql2 = "SELECT name, id FROM project";
$projects = $db->query($sql2);

$sql3 = "SELECT username, id FROM user";
$users = $db->query($sql3);

if (isset($_SESSION['error_message'])) {
    echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error_message'] . '</div>';
    unset($_SESSION['error_message']);
}

?>

<?php include '../header.php'; ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="container">
    <div class="column">
        <div class="row" style="margin-top: 70px;">
            <div>
            <?php
                if (isset($_SESSION['role'])){
                    echo '<button type="button" data-target="#addTask" data-toggle="modal" class="btn btn-success">
                    <i class="bi bi-plus-lg"></i> Add Task
                    </button>';
                }
            ?>
                <hr>
                <form action="" method="GET">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" class="form-control" name="taskName" placeholder="Task Name" value="<?php echo htmlspecialchars($taskName); ?>">
                    </div>
                    <div class="form-group">
                        <label for="date_time">Date and Time:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fa fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="datetime-local" id="date_time" name="dueDate" class="form-control" value="<?php echo htmlspecialchars($dueDate); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="priority">Priority:</label>
                        <select id="priority" class="form-control" name="priority">
                            <option value="">Select Priority</option>
                            <option value="Low" <?php echo ($priority == 'Low') ? 'selected' : ''; ?>>Low</option>
                            <option value="Medium" <?php echo ($priority == 'Medium') ? 'selected' : ''; ?>>Medium</option>
                            <option value="High" <?php echo ($priority == 'High') ? 'selected' : ''; ?>>High</option>
                        </select>
                    </div>
                    <input type="hidden" name="action" value="filter">
                    <button type="submit" class="btn btn-outline-info">Filter</button>
                </form>

                <div id="addTask" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <?php include 'add.php'; ?>
                    </div>
                </div>

                <div id="editTask" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <?php include 'edit.php'; ?>
                    </div>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Title</th>
                            <th scope="col">Description</th>
                            <th scope="col">Status</th>
                            <th scope="col">Due date</th>
                            <th scope="col">Project</th>
                            <th scope="col">Created by</th>
                            <th scope="col">Assigned to</th>
                            <th scope="col">Priority</th>
                            <th scope="col">Created at</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($rows->num_rows > 0): ?>
                            <?php while($row = $rows->fetch_assoc()): ?>
                                <tr>
                                    <td scope="row"><?php echo $row['id'] ?></td>
                                    <td class="col-2"><?php echo $row['title'] ?></td>
                                    <td class="col-4"><?php echo $row['description'] ?></td>
                                    <td scope="row"><?php echo $row['status'] ?></td>
                                    <td scope="row"><?php echo $row['due_date'] ?></td>
                                    <td scope="row">
                                        <?php $project = get_project($row['project_id']); 
                                        echo htmlspecialchars($project['name']) ?>
                                    </td>
                                    <td scope="row">
                                        <?php $user = get_user($row['created_by']); 
                                        echo htmlspecialchars($user['first_name']) . " " . htmlspecialchars($user['last_name'])?>
                                    </td>
                                    <td scope="row">
                                        <?php $user = get_user($row['assigned_to']); 
                                        echo htmlspecialchars($user['first_name']) . " " . htmlspecialchars($user['last_name'])?>
                                    </td>
                                    <td scope="row" style="background-color: 
                                        <?php 
                                            if ($row['priority'] == 'Low') {
                                                echo '#fff176';
                                            } elseif ($row['priority'] == 'Medium') {
                                                echo '#ffb74d';
                                            } elseif ($row['priority'] == 'High') {
                                                echo '#ff8a65';
                                            } else {
                                                echo 'transparent';
                                            } 
                                        ?>;">
                                        <?php echo htmlspecialchars($row['priority']); ?>
                                    </td>
                                    <td scope="row"><?php echo $row['created_at'] ?></td>
                                    <td>
                                        <?php if (isset($_SESSION['role'])): ?>
                                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#editTask" onclick="populateEditModal(
                                                <?php echo $row['id']; ?>, 
                                                '<?php echo htmlspecialchars($row['title']); ?>', 
                                                '<?php echo htmlspecialchars($row['description']); ?>', 
                                                '<?php echo htmlspecialchars($row['status']); ?>',
                                                '<?php echo htmlspecialchars($row['priority']); ?>',
                                                '<?php echo htmlspecialchars($row['due_date']); ?>',
                                                <?php echo $row['project_id']; ?>, 
                                                <?php echo $row['assigned_to']; ?>
                                            )"><i class="bi bi-pencil me-2"></i> Edit</button>
                                        <?php endif; ?>
                                    </td>
                                    <td> 
                                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin'): ?>
                                            <form action="../../controllers/taskController.php" method="POST">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" class="btn btn-danger">
                                                <i class="bi bi-trash3"></i> Delete
                                            </button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="12">No tasks found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function populateEditModal(taskId, title, description, status, priority, dueDate, projectId, assignedTo) {
        document.getElementById('editTaskId').value = taskId;
        document.getElementById('editTaskName').value = title;
        document.getElementById('editDescription').value = description;
        document.getElementById('editTaskStatus').value = status;
        document.getElementById('editTaskPriority').value = priority;

        const dueDateTime = new Date(dueDate).toISOString().slice(0, 16);
        document.getElementById('editDueDate').value = dueDateTime;

        let projectSelect = document.getElementById('editProject');
        projectSelect.value = projectId; 

        let assignedToSelect = document.getElementById('editAssignedTo');
        assignedToSelect.value = assignedTo; 
    }
</script>

<?php include '../footer.php'; ?>
