<?php
session_start();
require '../models/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);

    if (empty($first_name) || empty($last_name) || empty($username) || empty($email)) {
        $_SESSION['profile_update_error'] = "All fields are required.";
        header("Location: ../views/login_register/profile.php");
        exit;
    }

    $stmt = $db->prepare("UPDATE user SET first_name = ?, last_name = ?, username = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $first_name, $last_name, $username, $email, $user_id);

    if ($stmt->execute()) {
        header("Location: ../views/tasks/index.php");
        exit;
    } else {
        header("Location: ../views/login_register/profile.php");
        exit;
    }

    $stmt->close();
    $db->close();
}
