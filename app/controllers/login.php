<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require '../models/db.php';  

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $remember = isset($_POST['remember']);

    $stmt = $db->prepare("SELECT id, username, password, role FROM user WHERE username = ?");
    if (!$stmt) {
        echo "SQL preparation error: " . $db->error;
        exit();
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id, $user_name, $hashed_password, $role);
    $stmt->fetch();

    if (password_verify($password, $hashed_password)) {
        session_start();
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $user_name;
        $_SESSION['role'] = $role;

        if($remember) {
            setcookie('username', $username, time() + (86400 * 30), "/");
        }

        header("Location: ../views/tasks/index.php");
    } else {
        echo "Invalid username or password!";
    }

    $stmt->close();
    $db->close();  
}
?>
