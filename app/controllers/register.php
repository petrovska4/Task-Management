<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require '../models/db.php';

    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $db->prepare("INSERT INTO user (first_name, last_name, username, email, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $first_name, $last_name, $username, $email, $hashed_password);

    if ($stmt->execute()) {
        header("Location: ../views/tasks/index.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    setcookie('username', $username, time() + (86400 * 30), "/");

    $stmt->close();
    $db->close();
}
?>
