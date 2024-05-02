<?php
// Include database connection
require_once "db_connect.php";

// Exception and error handling
try {
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        throw new Exception("You are not logged in.");
    }

    // Generate a unique session ID for the user
    $session_id = session_id();

    // Check file access for the logged-in user
    // Assuming $db is your database connection
    $user_id = $_SESSION['user_id'];
    $file_name = "addusers.php"; // The current file name
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
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $active = isset($_POST['active']) ? 1 : 0;

        // Validate form data
        if (empty($firstname)) {
            $errors[] = "First name is required.";
        }
        if (empty($lastname)) {
            $errors[] = "Last name is required.";
        }
        if (empty($email)) {
            $errors[] = "Email is required.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }
        if (empty($username)) {
            $errors[] = "Username is required.";
        }
        if (empty($password)) {
            $errors[] = "Password is required.";
        } elseif (strlen($password) < 6) {
            $errors[] = "Password must be at least 6 characters long.";
        }
        if ($password !== $confirm_password) {
            $errors[] = "Passwords do not match.";
        }

        // If no errors, insert user into the database
        if (empty($errors)) {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user into the database
            $query_insert_user = "INSERT INTO users (ufname, ulname, email, username, password, active) 
                                  VALUES (:firstname, :lastname, :email, :username, :password, :active)";
            $stmt_insert_user = $db->prepare($query_insert_user);
            $stmt_insert_user->bindParam(':firstname', $firstname);
            $stmt_insert_user->bindParam(':lastname', $lastname);
            $stmt_insert_user->bindParam(':email', $email);
            $stmt_insert_user->bindParam(':username', $username);
            $stmt_insert_user->bindParam(':password', $hashed_password);
            $stmt_insert_user->bindParam(':active', $active);
            $stmt_insert_user->execute();

            // Redirect after successful submission
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
    <title>Add Users</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <?php if (isset($error_message)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php else : ?>
        <h2>Add Users</h2>
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
                <label for="firstname">First Name:</label>
                <input type="text" class="form-control" id="firstname" name="firstname" required>
            </div>
            <div class="form-group">
                <label for="lastname">Last Name:</label>
                <input type="text" class="form-control" id="lastname" name="lastname" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="active" name="active" value="1" checked>
                <label class="form-check-label" for="active">Active</label>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Submit</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
