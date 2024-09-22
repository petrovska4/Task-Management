<?php

function get_project($project_id) {
    global $db;
    $query = 'SELECT * FROM projects WHERE id = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(":id", $project_id, PDO::PARAM_INT); // Use PDO::PARAM_INT for integers
    $statement->execute();
    $project = $statement->fetch(PDO::FETCH_ASSOC); // Fetch as an associative array
    $statement->closeCursor();
    return $project;
}

function delete_project($project_id) {
    global $db;
    $query = 'DELETE FROM projects WHERE id = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(":id", $project_id, PDO::PARAM_INT); // Use PDO::PARAM_INT for integers
    $statement->execute();
    $statement->closeCursor();
}

function add_project($name, $description, $created_by, $created_at) {
    global $db;
    $query = 'INSERT INTO projects (name, description, created_by, created_at)
              VALUES (:name, :description, :created_by, :created_at)';
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':created_by', $created_by, PDO::PARAM_INT); // Use PDO::PARAM_INT for integers
    $statement->bindValue(':created_at', $created_at); // Assuming this is a string formatted date
    $statement->execute();
    $statement->closeCursor();
}

function edit_project($id, $name, $description, $created_by) {
    global $db;
    $query = 'UPDATE projects
              SET name = :name, description = :description, created_by = :created_by
              WHERE id = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':created_by', $created_by, PDO::PARAM_INT); // Use PDO::PARAM_INT for integers
    $statement->bindValue(':id', $id, PDO::PARAM_INT); // Use PDO::PARAM_INT for integers
    $statement->execute();
    $statement->closeCursor();
}
?>
