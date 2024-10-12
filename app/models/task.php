<?php

function get_task($task_id) {
    global $db;
    $query = 'SELECT * FROM task
    WHERE id = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(":id", $task_id);
    $statement->execute();
    $result = $statement->get_result();
    $task = $result->fetch_assoc();
    $statement->close();
    
    return $task;
}

function get_all_tasks() {
    global $db;
    $query = 'SELECT * FROM task';
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->get_result();
    $tasks = $result->fetch_assoc();
    $statement->close();
    
    return $tasks;
}

function delete_task($task_id) {
    global $db;
    $query = 'DELETE FROM task
    WHERE id = ?';
    $statement = $db->prepare($query);
    $statement->bind_param("i", $task_id);
    $statement->execute();
    $statement->close();
}

function add_task($title, $description, $priority, $due_date, $project_id, $created_by, $assigned_to) {
    global $db;
    $query = 'INSERT INTO task
                (title, description, priority, due_date, project_id, created_by, assigned_to)
                VALUES 
                (?, ?, ?, ?, ?, ?, ?)';
    
    $statement = $db->prepare($query);

    $statement->bind_param('ssssiis', $title, $description, $priority, $due_date, $project_id, $created_by, $assigned_to);

    $statement->execute();
    $statement->close();
}
function edit_task($task_id, $title, $description, $status, $priority, $due_date, $project_id, $assigned_to) {
    global $db;

    $query = 'UPDATE task SET title = ?, description = ?, status = ?, priority = ?, due_date = ?, project_id = ?, assigned_to = ?
              WHERE id = ?';
    
    $statement = $db->prepare($query);
    
    // Bind parameters
    $statement->bind_param('ssssssii', $title, $description, $status, $priority, $due_date, $project_id, $assigned_to, $task_id);
    
    // Execute the statement
    if ($statement->execute()) {
        // You might want to handle successful edit here, if needed
    }
    
    // Close the statement
    $statement->close();
}

?>