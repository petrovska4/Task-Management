<?php include '../../models/db.php';

$sql = "select * from task";

$rows = $db->query($sql);

?>

<?php include '../header.php'; ?>

<div class="container">
  <div class="column">
    <div class="row" style="margin-top: 70px;">
      <div class="col-md-10 col-md-offset-1">
        <button type="button" data-target="#addTask" data-toggle="modal" class="btn btn-success">Add Task</button>
        <hr>
        <p>filteri</p>

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
              <th scope="col">Priority</th>
              <th scope="col">Due date</th>
              <th scope="col">Project</th>
              <th scope="col">Created by</th>
              <th scope="col">Assigned to</th>
              <th scope="col">Created at</th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php while($row = $rows->fetch_assoc()): ?>
              <tr>
                <td scope="row"><?php echo $row['id'] ?></td>
                <td class="col-md-10"><?php echo $row['title'] ?></td>
                <td class="col-md-10"><?php echo $row['description'] ?></td>
                <td scope="row"><?php echo $row['status'] ?></td>
                <td scope="row"><?php echo $row['priority'] ?></td>
                <td scope="row"><?php echo $row['due_date'] ?></td>
                <td scope="row"><?php echo $row['project_id'] ?></td>
                <td scope="row"><?php echo $row['created_by'] ?></td>
                <td scope="row"><?php echo $row['assigned_to'] ?></td>
                <td scope="row"><?php echo $row['created_at'] ?></td>
                <td>
                  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#editTask" onclick="populateEditModal(
                    <?php echo $row['id']; ?>, 
                    '<?php echo htmlspecialchars($row['title']); ?>', 
                    '<?php echo htmlspecialchars($row['description']); ?>', 
                    '<?php echo htmlspecialchars($row['due_date']); ?>',
                    <?php echo $row['project_id']; ?>, 
                    <?php echo $row['assigned_to']; ?>
                    )">Edit
                  </button>
                </td>
                <td> 
                  <form action="../../controllers/taskController.php" method="POST">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?php echo $row['id'];?>">
                    <input type="submit" class="btn btn-danger" value="Delete">
                  </form>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script>
  function populateEditModal(taskId, title, description, dueDate, projectId, assignedTo) {
    document.getElementById('editTaskId').value = taskId;
    document.getElementById('editTaskName').value = title;
    document.getElementById('editDescription').value = description;

    const dueDateTime = new Date(dueDate).toISOString().slice(0, 16);
    document.getElementById('editDueDate').value = dueDateTime;

    let projectSelect = document.getElementById('editProject');
    projectSelect.value = projectId; 

    let assignedToSelect = document.getElementById('editAssignedTo');
    assignedToSelect.value = assignedTo; 
  }
</script>
<?php include '../footer.php'; ?>
