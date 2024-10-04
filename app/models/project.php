<?php

function get_project($project_id) {
  global $db;
  $query = 'SELECT * FROM project
            WHERE id = ?';
  $statement = $db ->prepare($query);

  $statement->bind_param("i", $project_id);

  $statement->execute();
  $project = $statement->fetch();
  $statement->closeCursor();

  return $project;
}

function get_tasks_by_project($project_id) {
  global $db;
  $query = 'SELECT * FROM task 
            WHERE project_id = ?';
  $statement = $db->prepare($query);

  $statement->bind_param('i', $project_id);

  $statement->execute();
  $result = $statement->get_result();
  $tasks = $result->fetch_all(MYSQLI_ASSOC);

  $statement->close();

  return $tasks;
}

function delete_project($project_id) {
  global $db;
  $query = 'DELETE FROM project
            WHERE id = ?';
  $statement = $db->prepare($query);

  $statement->bind_param('i', $project_id);

  $statement->execute();
  $statement->close();
}

function add_project($name, $description, $created_by) {
  global $db;
  $query = 'INSERT INTO project
              (name, description, created_by)
            VALUES
              (?, ?, ?)';
  $statement = $db->prepare($query);

  $statement->bind_param('ssi', $name, $description, $created_by);

  $statement->execute();
  $statement->close();
}

function edit_project($id, $name, $description, $created_by) {
  global $db;
  $query = 'UPDATE project
            SET name = ?, description = ?, created_by = ?
            WHERE id = ?';
  
  $statement = $db->prepare($query);
  
  $statement->bind_param('ssii', $name, $description, $created_by, $id);
  
  $statement->execute();
  
  $statement->close();
}
?>