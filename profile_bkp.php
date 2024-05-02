<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Menu and Content</title>
<style>
    /* CSS for the top bar */
    .top-bar {
        background-color: skyblue;
        padding: 10px 20px; /* Adjust padding as needed */
        color: white;
        text-align: center;
    }
</style>
<style>
    /* CSS for the top bar */
    .top-bar {
        background-color: skyblue;
        padding: 10px 20px; /* Adjust padding as needed */
        color: white;
        text-align: right; /* Align text to the right */
    }

    /* CSS for dropdown menu */
    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        z-index: 1;
        right: 0; /* Align dropdown to the right */
    }

    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {
        background-color: #f1f1f1;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }
</style>



<style>
  /* Basic styling for the layout */
  body {
    margin: 0;
    font-family: Arial, sans-serif;
  }
  .container {
    display: flex;
  }
  #left-menu {
    width: 200px;
    background-color: #f2f2f2;
    padding: 5px;
  }
  #content {
    flex-grow: 1;
    padding: 50px;
    margin-left: 70px; /* Add a margin to prevent overlapping with the left menu */
  }
</style>
</head>
<body>

<div class="top-bar">
    <div class="dropdown"  align=="right">
        <span>Menu</span>
        <div class="dropdown-content">
            <a href="profile.php">Profile</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
</div>

<div class="top-bar">
  
</div>

<div class="container">
  <div id="left-menu">
    <?php include('leftmenu.php'); ?>
  </div>
  
  
  

  <div id="content">
 




 
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	
	<style>
	/* CSS for left menu */
#left-menu {
    position: fixed; /* Fixed position */
    top: 0; /* Position from the top */
    left: 0; /* Position from the left */
    width: 200px; /* Set the width */
    height: 100%; /* Full height */
    background-color: #f8f9fa; /* Background color */
    padding: 20px; /* Padding */
    border-right: 1px solid #dee2e6; /* Right border */
}

/* CSS for menu items */
.menu-item {
    margin-bottom: 10px; /* Margin between menu items */
}

.menu-link {
    color: #007bff; /* Link color */
    text-decoration: none; /* Remove underline */
}

.menu-link:hover {
    text-decoration: underline; /* Add underline on hover */
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    /* CSS for the delete button */
    .delete-button {
        background-color: gray;
        color: white;
        border: none;
        border-radius: 50%; /* Makes the button round */
        padding: 2px; /* Adjust padding as needed */
        cursor: pointer;
    }
</style>
<style>
    /* CSS for the edit button */
    .edit-button {
        background-color: gray;
        color: white;
        border: none;
        border-radius: 50%; /* Makes the button round */
        padding: 2px; /* Adjust padding as needed */
        cursor: pointer;
    }
</style>

	
</head>
<body>
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
                <input type="password_hash" class="form-control" id="old_password" name="old_password" required>
            </div>
            <div class="form-group">
                <label for="new_password">New Password:</label>
                <input type="password_hash" class="form-control" id="new_password" name="new_password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm New Password:</label>
                <input type="password_hash" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Change Password</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
