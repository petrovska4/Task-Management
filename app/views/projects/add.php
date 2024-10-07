<div class="modal-content">
  <div class="modal-header">
    <h4 class="modal-title">Add project</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
  </div>
  <div class="modal-body">
    <form method="POST" action="../../controllers/projectController.php">
      <input type="hidden" name="action" value="add">
      <div class="form-group">
        <label>Project Name</label>
        <input type="text" required name="name" class="form-control">
        <label>Description</label>
        <input type="text" required name="description" class="form-control">
        <label>Created At</label>
        <input type="datetime-local" name="created_at" required class="form-control">

      </div>
      <input type="submit" name="add" value="Add project" class="btn btn-success">
    </form>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  </div>
</div>