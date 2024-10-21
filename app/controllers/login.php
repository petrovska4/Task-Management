<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require '../models/db.php';  

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    // $remember = isset($_POST['remember']);

    $stmt = $db->prepare("SELECT id, username, password, role, email FROM user WHERE username = ?");
    if (!$stmt) {
        $_SESSION['login_error'] = "Database error: " . $db->error;
        header("Location: ../views/login_register/login_index.php");
        exit();
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id, $user_name, $hashed_password, $role, $email);
    $stmt->fetch(); 

    if (password_verify($password, $hashed_password)) {
        session_regenerate_id(true); // Avoid session fixation

        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $user_name;
        $_SESSION['role'] = $role;
        $_SESSION['email'] = $email; 

        setcookie('username', $username, time() + (86400 * 30), "/");
        setcookie('user_id', $user_id, time() + (86400 * 30), "/");

        header("Location: ../views/tasks/index.php");
        exit();
    } else {
        $_SESSION['login_error'] = "Invalid username or password.";
        header("Location: ../views/login_register/login_index.php");
        exit();    
    }

    $stmt->close();
    $db->close();  
}
?>
