<?php

function get_task($task_id) {
    global $db;
    $query = 'SELECT * FROM task
    WHERE id = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(":id", $task_id);
    $statement->execute();
    $task = $statement->fetch();
    $statement->closeCursor();
    return $task;
}

function delete_task($task_id) {
    global $db;
    $query = 'DELETE FROM task
    WHERE id = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(":id", $task_id);
    $statement->execute();
    $statement->closeCursor();
}

function add_task($title, $description, $status, $priority, $due_date, $project_id, $created_by, $qassigned_to) {
    global $db;
    $query = 'INSERT INTO task
    (title, description, status, priority, due_date, project_id, created_by, assigned_to)';
    $statement = $db->prepare($query);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':status', $status);
    $statement->bindValue(':priority', $priority);
    $statement->bindValue(':due_date', $due_date);
    $statement->bindValue(':project_id', $project_id);
    $statement->bindValue(':created_by', $created_by);
    $statement->bindValue(':assigned_to', $assigned_to);
    $statement->execute();
    $statement->closeCursor();
}
?>