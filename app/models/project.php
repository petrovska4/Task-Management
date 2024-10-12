<?php

function get_project($project_id) {
  global $db;
  $query = 'SELECT * FROM project WHERE id = ?';
  $statement = $db ->prepare($query);

  $statement->bind_param("i", $project_id);
  $statement->execute();
  $result = $statement->get_result();
  $project = $result->fetch_assoc();
  $statement->close();

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
    $query = 'DELETE FROM project WHERE id = ?';
    $statement = $db->prepare($query);
    $statement->bind_param('i', $project_id); 
    if (!$statement->execute()) {
      echo "Error: " . $statement->error; // Print error if execution fails
    }
    $statement->close();
}

function add_project($name, $description, $created_by) {
    global $db;
    $query = 'INSERT INTO project (name, description, created_by)
              VALUES (?, ?, ?)';
    $statement = $db->prepare($query);
    $statement->bind_param('ssi', $name, $description, $created_by);
    //$statement->execute();
    if (!$statement->execute()) {
      echo "Error: " . $statement->error;
  }

    $statement->close();
}

function edit_project($id, $name, $description) {
  global $db;
  $query = 'UPDATE project
            SET name = ?, description = ?
            WHERE id = ?';
  
  $statement = $db->prepare($query);
  
  $statement->bind_param('ssi', $name, $description, $id);
  
  $statement->execute();
  
  $statement->close();
}

function project_exists($project_id) {
  global $db;
  $query = 'SELECT COUNT(*) FROM project WHERE id = ?';

  $statement = $db->prepare($query);
  $statement->bind_param('i', $project_id);
  $statement->execute();
  $result = $statement->get_result();

  return $result->fetch_row()[0] > 0;
}
?>
