<?php 
include '../../models/db.php';
include '../../models/project.php';
include '../../models/user.php';
session_start(); 
//$sql = "select * from project";
// Check for filter parameters
$projectName = filter_input(INPUT_GET, 'projectName', FILTER_SANITIZE_STRING);
$createdBy = filter_input(INPUT_GET, 'createdBy', FILTER_SANITIZE_STRING); // If you want to filter by user

$sql = "SELECT * FROM project WHERE 1=1"; // Start with a base SQL query

if ($projectName) {
    $sql .= " AND name LIKE '%" . $db->real_escape_string($projectName) . "%'";
}

if ($createdBy) {
    $sql .= " AND created_by = '" . $db->real_escape_string($createdBy) . "'"; // Adjust as needed
}
$rows = $db->query($sql);

?>

<?php include '../header.php'; ?>
<div class="container">
  <div class="column">
    <div class="row" style="margin-top: 70px;">
      <div>
        <table class="table">
          <hr>
          <form action="" method="GET"> <!-- Adjust the action URL accordingly -->
            <div class="form-group">
              <label for="name">Name:</label>
              <input type="text" id="name" class="form-control" name="projectName" placeholder="Project Name">
            </div>
            <div class="form-group">
              <label for="created_by">Created By:</label>
              <input type="text" id="created_by" name="createdBy" class="form-control" placeholder="Created By"> <!-- Optional filter -->
            </div>
            <button type="submit" class="btn btn-outline-info">Filter</button>
          </form>

          <div id="addProject" class="modal fade" role="dialog">
            <div class="modal-dialog">
              <?php include 'add.php'; ?>
            </div>
          </div>

          <table class="table">
            <thead>
              <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Assigned tasks</th>
                <th scope="col">Documentation</th>
                <th scope="col">Created by</th>
                <th scope="col">Created at</th>
                <th></th>
                <th>
                    <?php if (isset($_SESSION['username'])): ?>
                        <button type="button" data-target="#addProject" data-toggle="modal" class="btn btn-outline-success">Add Project</button>
                    <?php endif; ?>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php while($row = $rows->fetch_assoc()): ?>
                <tr>
                  <td class="col-1"><?php echo $row['id'] ?></td>
                  <td class="col-2"><?php echo $row['name'] ?></td>
                  <td class="col-4"><?php echo $row['description'] ?></td>
                  <td class="col-4">
                  <?php 
                    $tasks = get_tasks_by_project($row['id']);
                    if (!empty($tasks)) {
                        $taskTitles = '';
                        foreach ($tasks as $index => $task) {
                            if ($index > 0) {
                                $taskTitles .= ', ';
                            }
                            $taskTitles .= htmlspecialchars($task['title']);
                        }
                        echo "<p>$taskTitles</p>";
                    } else {
                        echo "<p>No tasks found for this project.</p>";
                    }
                  ?>
                  </td>
                  <td class="col-2">
                    <?php if (!empty($row['file_path'])): ?>
                      <a href="../../controllers/download.php?file_path=<?php echo urlencode($row['file_path']); ?>" download>Download here...</a>
                    <?php else: ?>
                      <span>No file available</span>
                    <?php endif; ?>
                  </td>
                  <td  class="col-2">
                    <?php $user = get_user($row['created_by']);
                        echo htmlspecialchars($user['first_name']) . " " . htmlspecialchars($user['last_name'])?>
                  </td>
                  <td class="col-2"><?php echo $row['created_at'] ?></td>
                  <td>
                      <?php if (isset($_SESSION['username'])): ?>
                          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#editProject" onclick="populateEditModal(
                              <?php echo $row['id']; ?>,
                              '<?php echo htmlspecialchars($row['name']); ?>',
                              '<?php echo htmlspecialchars($row['description']); ?>',
                              '<?php echo htmlspecialchars($row['created_by']); ?>'
                          )">
                              Edit
                          </button>
                      <?php endif; ?>
                  </td>
                  <td>
                      <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin'): ?>
                          <form action="../../controllers/projectController.php" method="POST">
                              <input type="hidden" name="action" value="delete">
                              <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                              <input type="submit" class="btn btn-danger" value="Delete">
                          </form>
                      <?php endif; ?>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </table>
      </div>
    </div>
  </div>
  
  <div id="editProject" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <?php include 'edit.php'; ?>
    </div>
  </div>

</div>
<script>
  function populateEditModal(projectId, name, description, created_by) {
    document.getElementById('editProjectId').value = projectId;
    document.getElementById('editProjectName').value = name;
    document.getElementById('editProjectDescription').value = description;
    document.getElementById('editProjectCreatedBy').value = created_by;

    // let tasks = JSON.parse(tasksJson);

    // let tasksContainer = document.getElementById('editProjectTasks');
    // tasksContainer.innerHTML = '';

    // if (tasks.length > 0) {
    //   tasks.forEach(task => {
    //     let taskElement = document.createElement('p');
    //     taskElement.textContent = task.title;
    //     tasksContainer.appendChild(taskElement);
    //   });
    // } else {
    //   tasksContainer.textContent = 'No tasks found for this project.';
    // }
  }
</script>
<?php include '../footer.php'; ?>