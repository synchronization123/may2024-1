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
        View Assignment
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

    // Fetch assignments data (excluding soft-deleted assignments) assigned to the current session user
    $user_id = $_SESSION['user_id'];
    $query = "SELECT a.assignment_id, a.assigned_date, a.title, a.aging, CONCAT(u.ufname, ' ', u.ulname) AS assigned_to, a.status, a.security_jira, a.functional_jira, a.koc_date, a.eta 
              FROM patches a
              JOIN users u ON a.assigned_to = u.user_id
              WHERE a.delete_flag = 0 AND a.assigned_to = :user_id ORDER BY assignment_id DESC";




    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    $error_message = $e->getMessage();
}
?>



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
					<th>Status</th>
					<th>Title</th>
					<th>Security Jira</th>
					<th>Functional Jira</th>
					<th>Assigned To</th>
                    <th>Assigned On</th>
					<th>aging</th>
                    <th>KickOff Date</th>
                    <th>ETA</th>
                    
                </tr>
                </thead>
                <tbody>
                <?php foreach ($assignments as $assignment) : ?>
                    <tr>
                        <td><?php echo $assignment['assignment_id']; ?></td>
                        <td><?php echo $assignment['status']; ?></td>
                        <td>
                            <form method="post" action="addpatchdetails.php">
                                <input type="hidden" name="assignment_id" value="<?php echo $assignment['assignment_id']; ?>">
                                <button type="submit" class="btn btn-link"><?php echo $assignment['title']; ?></button>
                            </form>
                        </td>
						<td><?php echo $assignment['security_jira']; ?></td>
						<td><?php echo $assignment['functional_jira']; ?></td>
						<td><?php echo $assignment['assigned_to']; ?></td>
						<td><?php echo $assignment['assigned_date']; ?></td>
                        <td><?php echo $assignment['aging']; ?></td>
                        
                        <td><?php echo $assignment['koc_date']; ?></td>
                        <td><?php echo $assignment['eta']; ?></td>
                    
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
                                            <label for="aging">aging:</label>
                                            <textarea class="form-control" id="aging" name="aging" rows="3" required><?php echo $assignment['aging']; ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="assigned_to">Assigned To:</label>
                                            <!-- Fetch and display assigned_to options -->
                                            <select class="form-control" id="assigned_to" name="assigned_to" required>
                                                <?php
                                                // Fetch users with role_id 5 (assuming this is the role for assigned_to)
                                                $query_users = "SELECT user_id, CONCAT(ufname, ' ', ulname) AS full_name FROM users WHERE role_id = 5 AND delete_flag = 0";
                                                $stmt_users = $db->prepare($query_users);
                                                $stmt_users->execute();
                                                $users = $stmt_users->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($users as $user) {
                                                    $selected = ($user['user_id'] == $assignment['assigned_to']) ? "selected" : "";
                                                    echo "<option value='{$user['user_id']}' $selected>{$user['full_name']}</option>";
                                                }
                                                ?>
                                            </select>
                                        <div class="form-group">
                                            <label for="koc_date">RM PM:</label>
                                            <input type="date" class="form-control" id="koc_date" name="koc_date" value="<?php echo $assignment['koc_date']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="eta">RM PM:</label>
                                            <input type="text" class="form-control" id="eta" name="eta" value="<?php echo $assignment['eta']; ?>">
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
