<?php
include 'app/models/db.php';

$first_name = 'Admin';
$username = 'admin';
$password = password_hash('admin', PASSWORD_DEFAULT);
$role = 'Admin';

$sql = "INSERT INTO user (username, password, role, first_name) VALUES (?, ?, ?, ?)";
$stmt = $db->prepare($sql);
$stmt->bind_param('ssss', $username, $password, $role, $first_name);

if ($stmt->execute()) {
    echo "Admin user created successfully.";
} else {
    echo "Error: " . $stmt->error;
}
