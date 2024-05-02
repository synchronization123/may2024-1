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

    // Fetch assignments data (excluding soft-deleted assignments) assigned to the current session user
    $user_id = $_SESSION['user_id'];
    $query = "SELECT assignment_id, assigned_date, title, description, CONCAT(u.ufname, ' ', u.ulname) AS assigned_to, product_name, rm_pm 
              FROM patches a
              JOIN users u ON a.assigned_to = u.user_id
              WHERE a.delete_flag = 0 AND a.status = 'Mentor Review Pending'";

    $stmt = $db->prepare($query);
    $stmt->execute();
    $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    $error_message = $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Assignments</title>
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



</head>
<body>


<div class="form-group">
    <?php if (isset($error_message)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php else : ?>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Assignment ID</th>
                    <th>Assigned On</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Assigned To (User ID)</th>
                    <th>Product Name</th>
                    <th>RM PM</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($assignments as $assignment) : ?>
                    <tr>
                        <td><?php echo $assignment['assignment_id']; ?></td>
                        <td><?php echo $assignment['assigned_date']; ?></td>
                        <td>
                            <form method="post" action="addpatchdetails.php">
                                <input type="hidden" name="assignment_id" value="<?php echo $assignment['assignment_id']; ?>">
                                <button type="submit" class="btn btn-link"><?php echo $assignment['title']; ?></button>
                            </form>
                        </td>
                        <td><?php echo $assignment['description']; ?></td>
                        <td><?php echo $assignment['assigned_to']; ?> (<?php echo $user_id; ?>)</td>
                        <td><?php echo $assignment['product_name']; ?></td>
                        <td><?php echo $assignment['rm_pm']; ?></td>
                        <td>
                            <button type="button" class="edit-button" data-toggle="modal" data-target="#editModal<?php echo $assignment['assignment_id']; ?>">
                                <i class="fas fa-pencil-alt"></i></button>
                            <button type="button" class="delete-button" data-toggle="modal" data-target="#deleteModal<?php echo $assignment['assignment_id']; ?>">
                                <i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>

<!-- Edit Modal -->
                    <div class="modal fade" id="editModal<?php echo $assignment['assignment_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form method="post">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel">Edit Assignment</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="title">Title:</label>
                                            <input type="text" class="form-control" id="title" name="title" value="<?php echo $assignment['title']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description:</label>
                                            <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $assignment['description']; ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="assigned_to">Assigned To:</label>
                                            <!-- Fetch and display assigned_to options -->
                                            <select class="form-control" id="assigned_to" name="assigned_to" required>
                                                <?php
                                                // Fetch users with role_id 4 (assuming this is the role for assigned_to)
                                                $query_users = "SELECT user_id, CONCAT(ufname, ' ', ulname) AS full_name FROM users WHERE role_id = 4 AND delete_flag = 0";
                                                $stmt_users = $db->prepare($query_users);
                                                $stmt_users->execute();
                                                $users = $stmt_users->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($users as $user) {
                                                    $selected = ($user['user_id'] == $assignment['assigned_to']) ? "selected" : "";
                                                    echo "<option value='{$user['user_id']}' $selected>{$user['full_name']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="product_name">Product Name:</label>
                                            <!-- Fetch and display product_name options -->
                                            <select class="form-control" id="product_name" name="product_name" required>
                                                <?php
                                                // Fetch product_name options
                                                $query_products = "SELECT DISTINCT product_name FROM products WHERE delete_flag = 0";
                                                $stmt_products = $db->prepare($query_products);
                                                $stmt_products->execute();
                                                $products = $stmt_products->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($products as $product) {
                                                    $selected = ($product['product_name'] == $assignment['product_name']) ? "selected" : "";
                                                    echo "<option value='{$product['product_name']}' $selected>{$product['product_name']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="rm_pm">RM PM:</label>
                                            <input type="text" class="form-control" id="rm_pm" name="rm_pm" value="<?php echo $assignment['rm_pm']; ?>">
                                        </div>
                                        <!-- Add other input fields for editing -->
                                        <input type="hidden" name="assignment_id" value="<?php echo $assignment['assignment_id']; ?>">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" name="edit_assignment">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
					
					
					
					
                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal<?php echo $assignment['assignment_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form method="post">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Delete Assignment</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete this assignment?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="small-button" data-dismiss="modal">Close</button>
                                        <input type="hidden" name="assignment_id" value="<?php echo $assignment['assignment_id']; ?>">
                                        <button class="small-button" type="submit" class="btn btn-danger" name="delete_assignment">Delete</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
