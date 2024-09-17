<?php

function get_project($project_id) {
  global $db;
  $query = 'SELECT * FROM project
            WHERE id = :id';
  $statement = $db ->prepare($query);
  $statement->bindValue(":id", $project_id);
  $statement->execute();
  $project = $statement->fetch();
  $statement->closeCursor();
  return $project;
}

function delete_project($project_id) {
  global $db;
  $query = 'DELETE FROM project
            WHERE id = :id';
  $statement = $db->prepare($query);
  $statement->bindValue(':id', $project_id);
  $statement->execute();
  $statement->closeCursor();
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

?>