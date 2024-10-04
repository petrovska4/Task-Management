<?php

include '../../models/db.php';

?>

<div class="modal-content">
  <div class="modal-header">
    <h4 class="modal-title">Edit Project</h4>
    <button type="button" class="close" data-dismiss="modal">&times;</button>
  </div>
  <div class="modal-body">
    <form method="POST" action="../../controllers/projectController.php">
      <input type="hidden" name="action" value="edit">
      <input type="hidden" id="editProjectId" name="id">
      <div class="form-group">
        <label>Project Name</label>
        <input type="text" id="editProjectName" required name="name" class="form-control"> 
        <label>Description</label>
        <textarea id="editProjectDescription" required name="description" class="form-control"></textarea>
        <label>Created by</label>
        <input type="text" id="editProjectCreatedBy" required name="created_by" class="form-control"> 
      </div>
      <input type="submit" name="save" value="Save" class="btn btn-success">
    </form>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  </div>
</div>

<script>
  // function createArrayFromDiv() {
  //   const div = document.getElementById('editProjectTasks');
    
  //   const paragraphs = div.getElementsByTagName('p');

  //   const itemList = [];

  //   for (let p of paragraphs) {
  //     itemList.push(p.textContent);
  //   }

  //   return itemList; 
  // }

  // const selectedTasks = createArrayFromDiv();

  // // Function to set selected options
  // function setSelectedTasks() {
  //   const selectElement = document.getElementById('taskSelect');
  //   const options = selectElement.options;

  //   for (let i = 0; i < options.length; i++) {
  //     // Check if itemsArray includes the option text
  //     if (selectedTasks.includes(options[i].text)) {
  //       options[i].selected = true; // Set as selected if found
  //     }
  //   }
  // }

  // // Call the function after the DOM is loaded
  // document.addEventListener('DOMContentLoaded', setSelectedTasks);
</script>