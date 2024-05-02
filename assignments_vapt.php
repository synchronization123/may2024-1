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
    padding: 20px;
  }
  #content {
    flex-grow: 1;
    padding: 20px;
    margin-left: 70px; /* Add a margin to prevent overlapping with the left menu */
  }
</style>
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
	
</head>
<body>

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
//include_once 'leftmenu.php';

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
    $file_name = "assignments_vapt.php"; // The current file name
    $query = "SELECT * FROM file_access WHERE role_id IN (SELECT role_id FROM users WHERE user_id = :user_id) AND file_name = :file_name AND delete_flag = 0";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':file_name', $file_name);
    $stmt->execute();
    $file_access = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$file_access) {
        throw new Exception("You don't have access to this file.");
    }

    // Fetch users with role_id 5 and delete_flag 0 for the dropdown
    $query = "SELECT user_id, CONCAT(ufname, ' ', ulname) AS full_name FROM users WHERE role_id = 5 AND delete_flag = 0";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch products with delete_flag 0 for the dropdown
    $query = "SELECT product_name FROM products WHERE delete_flag = 0";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    // Server-side form validation to avoid manipulation
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate title
        if (empty($_POST["title"])) {
            throw new Exception("Title is required.");
        }
        $title = $_POST["title"];

        // Validate description
        if (empty($_POST["description"])) {
            throw new Exception("Description is required.");
        }
        $description = $_POST["description"];

        // Other form data validation...

        // Insert data into assignments_vapt table
        $assigned_date = date("Y-m-d"); // Current date
        $assigned_to = $_POST["assigned_to"];
        $product_name = $_POST["product_name"];
        $rm_pm = $_POST["rm_pm"];
        $created_by = $_SESSION['username'];
        $timestamp = date("Y-m-d H:i:s");

        $query = "INSERT INTO assignments_vapt (title, description, assigned_to, product_name, rm_pm, assigned_date, created_by, timestamp) VALUES (:title, :description, :assigned_to, :product_name, :rm_pm, :assigned_date, :created_by, :timestamp)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':assigned_to', $assigned_to);
        $stmt->bindParam(':product_name', $product_name);
        $stmt->bindParam(':rm_pm', $rm_pm);
        $stmt->bindParam(':assigned_date', $assigned_date);
        $stmt->bindParam(':created_by', $created_by);
        $stmt->bindParam(':timestamp', $timestamp);
        $stmt->execute();

        // Get the ID of the last inserted assignment
        $assignment_id = $db->lastInsertId();

        // Success message
        $success_message = "Assignment inserted successfully with ID: $assignment_id";
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
    <title>Create Assignment</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	
	
</head>
<body>



<div class="form-group">
    <?php if (isset($error_message)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php else: ?>
        
        <?php if (isset($success_message)) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        <form method="post">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="assigned_to">Assigned To:</label>
                <select class="form-control" id="assigned_to" name="assigned_to" required>
                    <option value="">Select User</option>
                    <?php foreach ($users as $user) : ?>
                        <option value="<?php echo $user['user_id']; ?>"><?php echo $user['full_name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="product_name">Product Name:</label>
                <select class="form-control" id="product_name" name="product_name" required>
                    <option value="">Select Product</option>
                    <?php foreach ($products as $product) : ?>
                        <option value="<?php echo $product; ?>"><?php echo $product; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="rm_pm">RM/PM:</label>
                <input type="text" class="form-control" id="rm_pm" name="rm_pm">
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    <?php endif; ?>
</div>

</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
</body>
</html>
