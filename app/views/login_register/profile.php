<?php
session_start();
require '../../models/db.php'; // Include database connection
include '../header.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Get user information from the database
$user_id = $_SESSION['user_id'];
$stmt = $db->prepare("SELECT first_name, last_name, username, email FROM user WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($first_name, $last_name, $username, $email);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .profile-container {
            margin-top: 5%;
        }
        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container profile-container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="text-center mb-4">User Profile</h2>
                        <form action="../../controllers/update_profile.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="first_name" class="form-label">First Name:</label>
                                <input 
                                    type="text" 
                                    id="first_name" 
                                    name="first_name" 
                                    class="form-control" 
                                    value="<?php echo htmlspecialchars($first_name); ?>" 
                                    required
                                >
                            </div>

                            <div class="form-group mb-3">
                                <label for="last_name" class="form-label">Last Name:</label>
                                <input 
                                    type="text" 
                                    id="last_name" 
                                    name="last_name" 
                                    class="form-control" 
                                    value="<?php echo htmlspecialchars($last_name); ?>" 
                                    required
                                >
                            </div>

                            <div class="form-group mb-3">
                                <label for="username" class="form-label">Username:</label>
                                <input 
                                    type="text" 
                                    id="username" 
                                    name="username" 
                                    class="form-control" 
                                    value="<?php echo htmlspecialchars($username); ?>" 
                                    required
                                >
                            </div>

                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    class="form-control" 
                                    value="<?php echo htmlspecialchars($email); ?>" 
                                    required
                                >
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">Update Profile</button>
                                <a href="../../controllers/logout.php" class="btn btn-outline-danger btn-lg btn-block">Logout</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php include_once "../footer.php"; ?>
