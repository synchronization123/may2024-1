<?php
session_start();

// Include your database connection file
include_once "db_connect.php";

// Exception and error handling
try {
    // Query to fetch user's role
    $user_id = $_SESSION['user_id'];
    $query = "SELECT role_id FROM users WHERE user_id = :user_id AND delete_flag = 0";
    $stmt = $db->prepare($query);
    $stmt->execute(['user_id' => $user_id]);
    $user = $stmt->fetch();

    // Check if the user has access to the file
    $query_access = "SELECT * FROM file_access WHERE role_id = :role_id AND delete_flag = 0";
    $stmt_access = $db->prepare($query_access);
    $stmt_access->execute(['role_id' => $user['role_id']]);
    $access_files = $stmt_access->fetchAll();

    if (!$access_files) {
        throw new Exception("You don't have access to any files.");
    }

    // Fetch data for the dashboard
    $today = date('Y-m-d');
    $tomorrow = date('Y-m-d', strtotime('+1 day'));

    // Query to fetch data from patches table for today's ETA
    $query_today = "SELECT p.*, u.ufname, u.ulname FROM patches p
                    LEFT JOIN users u ON p.assigned_to = u.user_id
                    WHERE p.assigned_to = :user_id AND p.eta = :today AND p.delete_flag = 0";
    $stmt_today = $db->prepare($query_today);
    $stmt_today->execute(['user_id' => $user_id, 'today' => $today]);
    $patches_today = $stmt_today->fetchAll();

    // Query to fetch data from patches table for tomorrow's ETA
    $query_tomorrow = "SELECT p.*, u.ufname, u.ulname FROM patches p
                       LEFT JOIN users u ON p.assigned_to = u.user_id
                       WHERE p.assigned_to = :user_id AND p.eta = :tomorrow AND p.delete_flag = 0";
    $stmt_tomorrow = $db->prepare($query_tomorrow);
    $stmt_tomorrow->execute(['user_id' => $user_id, 'tomorrow' => $tomorrow]);
    $patches_tomorrow = $stmt_tomorrow->fetchAll();

    // Query to fetch data from patches table where ETA is not set
    $query_not_set = "SELECT p.*, u.ufname, u.ulname FROM patches p
                      LEFT JOIN users u ON p.assigned_to = u.user_id
                      WHERE p.assigned_to = :user_id AND p.eta IS NULL AND p.delete_flag = 0";
    $stmt_not_set = $db->prepare($query_not_set);
    $stmt_not_set->execute(['user_id' => $user_id]);
    $patches_not_set = $stmt_not_set->fetchAll();
} catch (Exception $e) {
    // Display error message
    $error_message = $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa; /* Light gray background */
        }

        .top-bar {
            background-color: #173E58; /* Sky blue color */
            height: 50px;
            padding: 10px 20px;
            color: white;
        }

        .left-menu {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100%;
            background-color: ; /* Dark gray color */
            padding-top: 50px; /* Space for top bar */
        }

        .menu-item {
            margin-bottom: 10px;
        }

        .main-content {
            margin-left: 250px; /* Same width as left menu */
            padding: 20px;
        }

        .card {
            margin-bottom: 20px;
        }
		
		.btn-3d {
    display: block;
    width: 100%;
    border: none;
    background: linear-gradient(145deg, #87CEEB, #87CEEB); /* Sky blue gradient */
    color: white;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 8px;
    box-shadow: 3px 3px 7px rgba(0, 0, 0, 0.3), 
                -3px -3px 7px rgba(255, 255, 255, 0.6);
    transition: all 0.2s;
    text-align: left; /* Align text to the left */
}

.btn-3d:hover {
    background: linear-gradient(145deg, #9acfea, #9acfea); /* Lighter sky blue gradient */
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3), 
                -2px -2px 5px rgba(255, 255, 255, 0.6);
    transform: translate(1px, 1px);
}

		
    </style>
	
	
	
</head>
<body>
    <!-- Top bar -->
    <div class="top-bar">
        Profile
    </div>
<!-- Left Menu -->
<div class="left-menu">
    <ul class="list-group">
       <?php
// Exception and error handling
try {
    // Retrieve the logged-in user's role_id based on user_id
    $logged_in_user_id = $_SESSION['user_id']; // Assuming you have stored the user's ID in a session variable
    $query_user_role = "SELECT role_id FROM users WHERE user_id = $logged_in_user_id";
    $stmt_user_role = $db->query($query_user_role);
    $user_role = $stmt_user_role->fetch(PDO::FETCH_ASSOC);

    if (!$user_role) {
        throw new Exception("User role not found");
    }

    // Use the retrieved role_id in the file access query
    $role_id = $user_role['role_id'];
    $query_menu = "SELECT * FROM file_access WHERE role_id = $role_id AND delete_flag = 0 AND in_menu = 0 ORDER BY order_by ASC";
    $stmt_menu = $db->query($query_menu);
    $access_files = $stmt_menu->fetchAll();

    // Check if any display names are available
    if (!$access_files) {
        throw new Exception("No files available");
    }

    // Render display names as menu items
    foreach ($access_files as $file) {
        echo '<li class="list-group-item menu-item">';
        echo '<a href="' . $file['file_name'] . '" class="btn btn-primary btn-3d menu-link">' . $file['display_name'] . '</a>';
        echo '</li>';
    }
} catch (Exception $e) {
    // Display error message
    echo '<li class="list-group-item">' . $e->getMessage() . '</li>';
}
?>

    </ul>
</div>


    <!-- Main Content -->
    <div class="main-content">


<?php

// Include database connection
require_once "db_connect.php";

// Exception and error handling
try {
    if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
 if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, redirect to login.php
    header("Location: login.php");
    exit; // Make sure to exit after redirection
}
    // Generate a unique session ID for the user
    $session_id = session_id();

    // Check file access for the logged-in user
    // Assuming $db is your database connection
    $user_id = $_SESSION['user_id'];
    $file_name = "profile.php"; // The current file name
    $query = "SELECT * FROM file_access WHERE role_id IN (SELECT role_id FROM users WHERE user_id = :user_id) AND file_name = :file_name AND delete_flag = 0";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':file_name', $file_name);
    $stmt->execute();
    $file_access = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$file_access) {
        throw new Exception("You don't have access to this file.");
    }

    // Initialize error array
    $errors = [];

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Validate form data
        if (empty($old_password) || empty($new_password) || empty($confirm_password)) {
            $errors[] = "All fields are required.";
        } else {
            // Retrieve current user's password hash
            $query_get_password = "SELECT password_hash FROM users WHERE user_id = :user_id";
            $stmt_get_password = $db->prepare($query_get_password);
            $stmt_get_password->bindParam(':user_id', $user_id);
            $stmt_get_password->execute();
            $user = $stmt_get_password->fetch(PDO::FETCH_ASSOC);

            // Verify old password
            if (!password_verify($old_password, $user['password_hash'])) {
                $errors[] = "Incorrect old password.";
            }

            // Check if new password matches confirm password
            if ($new_password !== $confirm_password) {
                $errors[] = "New password and confirm password do not match.";
            }
        }

        // If no errors, update the password
        if (empty($errors)) {
            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update user's password
            $query_update_password = "UPDATE users SET password_hash = :password_hash WHERE user_id = :user_id";
            $stmt_update_password = $db->prepare($query_update_password);
            $stmt_update_password->bindParam(':password_hash', $hashed_password);
            $stmt_update_password->bindParam(':user_id', $user_id);
            $stmt_update_password->execute();

            // Redirect after successful password update
            header("Location: success.php");
            exit();
        }
    }
} catch (Exception $e) {
    $error_message = $e->getMessage();
}
?>

<div class="container mt-5">
    <?php if (isset($error_message)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php else : ?>
        
        <?php if (!empty($errors)) : ?>
            <div class="alert alert-danger" role="alert">
                <ul>
                    <?php foreach ($errors as $error) : ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form method="post">
            <div class="form-group">
                <label for="old_password">Old Password:</label>
                <input type="password" class="form-control" id="old_password" name="old_password" required>
            </div>
            <div class="form-group">
                <label for="password">New Password:</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <div class="form-group">
                <label for="password">Confirm New Password:</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Change Password</button>
        </form>
    <?php endif; ?>
</div>






    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function submitForm(assignment_id) {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = 'addpatchdetails.php';
            
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'assignment_id';
            input.value = assignment_id;
            form.appendChild(input);

            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>
</html>
