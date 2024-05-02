<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

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

<div class="top-bar">
  Create Assignment
</div>

<!-- Left Menu -->
<div class="left-menu">
    <ul class="list-group">
        <?php
        // Exception and error handling
        try {
            // Query to fetch display names for left menu
            $query_menu = "SELECT * FROM file_access WHERE role_id = 1 AND delete_flag = 0 AND in_menu = 0";
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





<div class="container">

  
  

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
    $file_name = "assignments.php"; // The current file name
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

        // Insert data into assignments table
        $assigned_date = date("Y-m-d"); // Current date
        $assigned_to = $_POST["assigned_to"];
        $product_name = $_POST["product_name"];
        $rm_pm = $_POST["rm_pm"];
        $created_by = $_SESSION['username'];
        $timestamp = date("Y-m-d H:i:s");

        $query = "INSERT INTO assignments (title, description, assigned_to, product_name, rm_pm, assigned_date, created_by, timestamp) VALUES (:title, :description, :assigned_to, :product_name, :rm_pm, :assigned_date, :created_by, :timestamp)";
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
