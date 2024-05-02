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
        Add Analysis
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
$error_message = "";
$success_message = "";
try {
    if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

 if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, redirect to login.php
    header("Location: login.php");
    exit; // Make sure to exit after redirection
}


    // Check file access for the logged-in user
    // Assuming $db is your database connection
    $user_id = $_SESSION['user_id'];
    $file_name = "addanalysis.php"; // The current file name
    $query = "SELECT * FROM file_access WHERE role_id IN (SELECT role_id FROM users WHERE user_id = :user_id) AND file_name = :file_name AND delete_flag = 0";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':file_name', $file_name);
    $stmt->execute();
    $file_access = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$file_access) {
        throw new Exception("You don't have access to this file.");
    }

    // Fetch assignment_id from URL
    if (!isset($_GET['assignment_id'])) {
        throw new Exception("Assignment ID is not provided.");
    }
    $assignment_id = $_GET['assignment_id'];

    // Fetch assignment details from patches table
    $query_assignment = "SELECT * FROM patches WHERE assignment_id = :assignment_id AND delete_flag = 0";
    $stmt_assignment = $db->prepare($query_assignment);
    $stmt_assignment->bindParam(':assignment_id', $assignment_id);
    $stmt_assignment->execute();
    $assignment_details = $stmt_assignment->fetch(PDO::FETCH_ASSOC);

    // Check if assignment_id exists in patches table
    if (!$assignment_details) {
        throw new Exception("Assignment not found in the patches table.");
    }

    // Fetch existing analysis data for the assignment_id
    $query_analysis = "SELECT * FROM analysis WHERE assignment_id = :assignment_id";
    $stmt_analysis = $db->prepare($query_analysis);
    $stmt_analysis->bindParam(':assignment_id', $assignment_id);
    $stmt_analysis->execute();
    $existing_analysis = $stmt_analysis->fetchAll(PDO::FETCH_ASSOC);

    // Process form submission to add new analysis
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_analysis'])) {
        // Fetch form data
        $jira_id = $_POST['jira_id'];
        $category = $_POST['category'];
        $jira_type = $_POST['jira_type'];
        $SonarQube = $_POST['SonarQube'];
        $Contrast = $_POST['Contrast'];
        $Dep_Check = $_POST['Dep_Check'];
        $Manual_Secure_Code_Review = $_POST['Manual_Secure_Code_Review'];
        $Manual_Security_Testing = $_POST['Manual_Security_Testing'];
        $remark = $_POST['remark'];

        // Validate form fields
        if (empty($jira_id) || empty($remark)) {
            throw new Exception("Jira ID and Remark cannot be empty.");
        }

        // Insert new analysis record
        $insert_query = "
    INSERT INTO analysis (assignment_id, jira_id, category, jira_type, SonarQube, Contrast, Dep_Check, Manual_Secure_Code_Review, Manual_Security_Testing, remark, created_by) 
    SELECT :assignment_id, :jira_id, :category, :jira_type, :SonarQube, :Contrast, :Dep_Check, :Manual_Secure_Code_Review, :Manual_Security_Testing, :remark, :created_by
    FROM patches
    WHERE assignment_id = :assignment_id AND delete_flag = 0  LIMIT 1";
        $stmt_insert = $db->prepare($insert_query);
        $stmt_insert->bindParam(':assignment_id', $assignment_id);
        $stmt_insert->bindParam(':jira_id', $jira_id);
        $stmt_insert->bindParam(':category', $category);
        $stmt_insert->bindParam(':jira_type', $jira_type);
        $stmt_insert->bindParam(':SonarQube', $SonarQube);
        $stmt_insert->bindParam(':Contrast', $Contrast);
        $stmt_insert->bindParam(':Dep_Check', $Dep_Check);
        $stmt_insert->bindParam(':Manual_Secure_Code_Review', $Manual_Secure_Code_Review);
        $stmt_insert->bindParam(':Manual_Security_Testing', $Manual_Security_Testing);
        $stmt_insert->bindParam(':remark', $remark);
        $stmt_insert->bindParam(':created_by', $user_id);
        $stmt_insert->execute();

        // Set success message
        $success_message = "Analysis added successfully.";

        // Redirect to avoid form resubmission
        header("Location: addanalysis.php?assignment_id=$assignment_id");
        exit();
    }
} catch (Exception $e) {
    $error_message = $e->getMessage();
}
?>

<div class="form-group">
    <?php if ($error_message) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <?php if ($success_message) : ?>
        <div class="alert alert-success" role="alert">
            <?php echo $success_message; ?>
        </div>
    <?php endif; ?>

    <form id="backForm" action="addpatchdetails.php" method="post">
        <!-- Hidden input to pass assignment_id -->
        <input type="hidden" name="assignment_id" value="<?php echo $assignment_id; ?>">
        <button type="submit">Back</button>
    </form>
	
	<script>
        document.querySelector('button[type="submit"]').addEventListener('click', function() {
            document.getElementById('backForm').submit();
        });
    </script>
    
    <table class="table">
        <tbody>
            <tr>
                <td>Assignment ID:</td>
                <td><?php echo $assignment_id; ?></td>
            </tr>
            <!-- Include other assignment details here -->
			
			
			       
			
        </tbody>
    </table>

    <hr>

    <h3>Add New Analysis</h3>
    <form method="post" onsubmit="return validateForm()">
        <table class="table">
            <tbody>
                <tr>
                    <td>Jira ID:</td>
                    <td><input type="text" name="jira_id" id="jira_id"></td>
                </tr>
                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">
                            <option value="Security jira">Security Jira</option>
                            <option value="Functional jira">Functional Jira</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Jira Type:</td>
                    <td>
                        <select name="jira_type">
                            <option value="epic">Epic</option>
                            <option value="story">Story</option>
                            <option value="Bug">Bug</option>
                            <option value="TI">TI (Technical Improvement)</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>SonarQube:</td>
                    <td>
                        <select name="SonarQube">
                            <option value="Pass">Pass</option>
                            <option value="Fail">Fail</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Contrast:</td>
                    <td>
                        <select name="Contrast">
                            <option value="Pass">Pass</option>
                            <option value="Fail">Fail</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Dep_Check:</td>
                    <td>
                        <select name="Dep_Check">
                            <option value="Pass">Pass</option>
                            <option value="Fail">Fail</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Manual_Secure_Code_Review:</td>
                    <td>
                        <select name="Manual_Secure_Code_Review">
                            <option value="Pass">Pass</option>
                            <option value="Fail">Fail</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Manual_Security_Testing:</td>
                    <td>
                        <select name="Manual_Security_Testing">
                            <option value="Pass">Pass</option>
                            <option value="Fail">Fail</option>
                        </select>
                    </td>
                </tr>
                <!-- Include other analysis fields here -->
                <tr>
                    <td>Remark:</td>
                    <td><textarea name="remark" id="remark" rows="4" cols="50"></textarea></td>
                </tr>
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary" name="add_analysis">Add Analysis</button>
    </form>

    <hr>

    <h3> Analysis</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Jira ID</th>
                <th>Category</th>
                <th>Jira Type</th>
                <th>Created By</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($existing_analysis as $analysis) : ?>
                <tr>
                    <td><?php echo $analysis['jira_id']; ?></td>
                    <td><?php echo $analysis['category']; ?></td>
                    <td><?php echo $analysis['jira_type']; ?></td>
                    <!-- Include other analysis data here -->
                    <td><?php echo $analysis['created_by']; ?></td>
                    <td><?php echo $analysis['timestamp']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
   
	   
	   
	   
	   
	   
	   
	   
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<script>
    function validateForm() {
        var jiraId = document.getElementById("jira_id").value.trim();
        var remark = document.getElementById("remark").value.trim();

        if (jiraId === "" || remark === "") {
            alert("Jira ID and Remark cannot be empty.");
            return false;
        }
        return true;
    }
</script>




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
