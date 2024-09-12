<?php  // ova treba da ide vo index.php


?>

<div class="modal-content">
  <div class="modal-header">
    <h4 class="modal-title">Add task</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
  </div>
  <div class="modal-body">
    <form method="post" action="index.php">
      <div class="form-group">
        <label>Task Name</label>
        <input type="text" required name="task" class="form-control">
        <label>Description</label>
        <input type="text" required name="description" class="form-control">
        <label>Due date</label>
        <input type="text" required name="due" class="form-control">
        <label>Project</label>
        <input type="text" required name="project" class="form-control">
        <label>Assign to</label>
        <input type="text" required name="assign" class="form-control">
      </div>
      <input type="submit" name="add" value="Add task" class="btn btn-success">
    </form>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  </div>
</div>