<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require '../app/models/db.php';  // Include your database connection

    // Get form data
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Prepare SQL query to fetch the user's details
    $stmt = $db->prepare("SELECT id, username, password, role FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id, $user_name, $hashed_password, $role);
    $stmt->fetch();

    // Verify the password entered by the user matches the hashed password in the database
    if (password_verify($password, $hashed_password)) {
        session_start();
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $user_name;
        $_SESSION['role'] = $role;

        echo "Login successful!";
        header("Location: ../app/views/tasks/index.php");
        // Optional: Redirect to a protected page
        // header("Location: dashboard.php");
    } else {
        echo "Invalid username or password!";
    }

    // Close connections
    $stmt->close();
    $db->close();  // Close the database connection
}
?>
