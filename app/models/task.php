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
                WHERE id = ?';

    $statement = $db->prepare($query);

    $statement->bind_param('i', $task_id);

    $statement->execute();
    $statement->close();
}

function add_task($title, $description, $status, $priority, $due_date, $project_id, $created_by, $assigned_to) {
    global $db;
    $query = 'INSERT INTO task
                (title, description, status, priority, due_date, project_id, created_by, assigned_to)
                VALUES 
                (?, ?, ?, ?, ?, ?, ?, ?)';
    
    $statement = $db->prepare($query);

    $statement->bind_param('sssssiis', $title, $description, $status, $priority, $due_date, $project_id, $created_by, $assigned_to);

    $statement->execute();
    $statement->close();
}
?>