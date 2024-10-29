<?php 
include '../../models/db.php';
include '../../models/project.php';
include '../../models/user.php';

session_start(); 

$projectName = filter_input(INPUT_GET, 'projectName', FILTER_SANITIZE_STRING);
$createdBy = filter_input(INPUT_GET, 'createdBy', FILTER_SANITIZE_STRING); 

$sql = "SELECT * FROM project WHERE 1=1";

if ($projectName) {
    $sql .= " AND name LIKE '%" . $db->real_escape_string($projectName) . "%'";
}

if ($createdBy) {
    $sql .= " AND created_by = '" . $db->real_escape_string($createdBy) . "'";
}
$rows = $db->query($sql);

?>

<?php include '../header.php'; ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<div class="container">
  <div class="column">
    <div class="row" style="margin-top: 70px;">
      <div>
        <?php if (isset($_SESSION['username'])): ?>
          <button type="button" data-target="#addProject" data-toggle="modal" class="btn btn-success">
            <i class="bi bi-plus-lg me-2"></i> Add Project
          </button>
        <?php endif; ?>
        <div id="addProject" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <?php include 'add.php'; ?>
          </div>
        </div>
        <table class="table">
          <hr>
          <form action="" method="GET">
            <div class="form-group">
              <label for="name">Name:</label>
              <input type="text" id="name" class="form-control" name="projectName" placeholder="Project Name">
            </div>
            <div class="form-group">
              <label for="created_by">Created By:</label>
              <input type="text" id="created_by" name="createdBy" class="form-control" placeholder="Created By">
            </div>
            <button type="submit" class="btn btn-outline-info">Filter</button>
          </form>
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
                <th></th>
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
                              <i class="bi bi-pencil me-2"></i> Edit
                          </button>
                      <?php endif; ?>
                  </td>
                  <td>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin'): ?>
                      <form action="../../controllers/projectController.php" method="POST">
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
  }
</script>
<?php include '../footer.php'; ?>