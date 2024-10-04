<div class="modal-content">
  <div class="modal-header">
    <h4 class="modal-title">Add task</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
  </div>
  <div class="modal-body">
    <form method="POST" action="../../controllers/taskController.php">
      <input type="hidden" name="action" value="add">
      <div class="form-group">
        <label>Task Name</label>
        <input type="text" required name="task" class="form-control">
        <label>Description</label>
        <input type="text" required name="description" class="form-control">
        <label>Priority</label>
        <select name="priority" class="form-control">
          <option value="Low">Low</option>
          <option value="Medium">Medium</option>
          <option value="High">High</option>
        </select>
        <label>Due date</label>
        <input type="datetime-local" required name="due_date" class="form-control">
        <label>Project</label>
        <select required name="project" class="form-control">
          <option value="" disabled selected>Select a project</option> <!-- Optional placeholder -->
          <?php
          while ($project = $projects->fetch_assoc()) { ?>
              <option value="<?php echo $project['id']; ?>"><?php echo htmlspecialchars($project['name']); ?></option>
          <?php } ?>
        </select>
        <label>Assign to</label>
        <input type="text" required name="assigned_to" class="form-control">
      </div>
      <input type="submit" name="add" value="Add task" class="btn btn-success">
    </form>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  </div>
</div>