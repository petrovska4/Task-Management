<?php

include '../../models/db.php';

$sql = "select * from project";

$projects = $db->query($sql);

?>
<div class="modal-content">
  <div class="modal-header">
    <h4 class="modal-title">Edit task</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
  </div>
  <div class="modal-body">
    <form method="POST" action="../../controllers/taskController.php">
      <input type="hidden" name="action" value="edit">
      <input type="hidden" id="editTaskId" name="id">
      <div class="form-group">
        <label>Task Name</label>
        <input type="text" id="editTaskName" required name="task" class="form-control">
        <label>Description</label>
        <input type="text" id="editDescription" required name="description" class="form-control">
        <label>Due date</label>
        <input type="datetime-local" id="editDueDate" required name="due_date" class="form-control">
        <label>Project</label>
        <input type="text" id="editProject" required name="project" class="form-control">
        <label>Assign to</label>
        <input type="text" id="editAssignedTo" required name="assigned_to" class="form-control">
      </div>
      <input type="submit" name="add" value="Save" class="btn btn-success">
    </form>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  </div>
</div>