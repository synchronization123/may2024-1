<?php
// Exception and error handling
try {
    session_start();

    // Include database connection
    require_once "db_connect.php";

    // Check if the user is already logged in
    if (isset($_SESSION['user_id'])) {
        header("Location: dashboard.php"); // Redirect to dashboard if already logged in
        exit();
    }

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate username and password
        if (empty($_POST["username"]) || empty($_POST["password"])) {
            throw new Exception("Username and password are required.");
        }

        // Retrieve username and password from the form
        $username = $_POST["username"];
        $password = $_POST["password"];

        // Query to fetch user details based on username
        $query = "SELECT * FROM users WHERE username = :username";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify password using password_verify
        if ($user && password_verify($password, $user['password_hash'])) {
            // Login successful, set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            
            // Redirect to dashboard or any other page after successful login
            header("Location: dashboard.php");
            exit();
        } else {
            throw new Exception("Invalid username or password.");
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
  <title>Login</title>
  <!-- Bootstrap CSS -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome for icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
  <style>
    /* Custom styles */
    body {
      background-color: #f8f9fa;
    }
    .login-box {
      margin-top: 100px;
    }
    .card {
      border: none;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .card-header {
      background-color: #007bff;
      color: #fff;
      border-radius: 10px 10px 0 0;
    }
    .card-body {
      padding: 30px;
    }
    .form-group {
      margin-bottom: 20px;
    }
    .form-control {
      border-radius: 20px;
    }
    .btn-primary {
      background-color: #007bff;
      border-color: #007bff;
      border-radius: 20px;
      padding: 10px 20px;
    }
    .btn-primary:hover {
      background-color: #0056b3;
      border-color: #0056b3;
    }
  </style>
</head>

<body>
<div class="container mt-5">
    <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 login-box">
        <div class="card">
          <div class="card-header text-center">
            <h4>Login</h4>
			</div>
    <?php if (isset($error_message)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>
	 <div class="card-body">
    <form method="post">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
