<?php
// Include database connection
require_once "db_connect.php";

// Exception and error handling
try {
    session_start();

    // Check if the user is already logged in
    if (isset($_SESSION['user_id'])) {
        header("Location: dashboard.php"); // Redirect to dashboard if already logged in
        exit();
    }

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate form inputs
        $required_fields = ['username', 'password', 'ufname', 'ulname', 'email'];
        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                throw new Exception(ucfirst($field) . " is required.");
            }
        }

        // Fetch input values
        $username = $_POST["username"];
        $password = $_POST["password"];
        $ufname = $_POST["ufname"];
        $ulname = $_POST["ulname"];
        $email = $_POST["email"];
        $role_id = 5; // Assuming default role ID for registered users

        // Check if username already exists
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            throw new Exception("Username already exists. Please choose a different one.");
        }

        // Encrypt password using bcrypt
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        // Insert new user into the database
        $query = "INSERT INTO users (username, password_hash, ufname, ulname, email, role_id) VALUES (:username, :password_hash, :ufname, :ulname, :email, :role_id)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password_hash', $password_hash);
        $stmt->bindParam(':ufname', $ufname);
        $stmt->bindParam(':ulname', $ulname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role_id', $role_id);
        $stmt->execute();

        // Redirect to login page after successful registration
        header("Location: login.php");
        exit();
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
    <title>Register</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Register</h2>
    <?php if (isset($error_message)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>
    <form method="post">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="ufname">First Name:</label>
            <input type="text" class="form-control" id="ufname" name="ufname" required>
        </div>
        <div class="form-group">
            <label for="ulname">Last Name:</label>
            <input type="text" class="form-control" id="ulname" name="ulname" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
