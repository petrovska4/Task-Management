<?php
session_start();
require '../models/db.php'; // Include database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get updated user information from the form
    $user_id = $_SESSION['user_id'];
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);

    // Prepare SQL query to update user information
    $stmt = $db->prepare("UPDATE user SET username = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $username, $email, $user_id);

    if ($stmt->execute()) {
        echo "Profile updated successfully!";
        // Optionally redirect to the profile page
        // header("Location: profile.php");
    } else {
        echo "Error updating profile: " . $stmt->error;
    }

    $stmt->close();
    $db->close(); // Close the database connection
}
?>
