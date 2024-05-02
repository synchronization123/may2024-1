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
    $query_assignment = "SELECT * FROM patches WHERE assignment_id = :assignment_id";
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
        $insert_query = "INSERT INTO analysis (assignment_id, jira_id, category, jira_type, SonarQube, Contrast, Dep_Check, Manual_Secure_Code_Review, Manual_Security_Testing, remark, created_by) VALUES (:assignment_id, :jira_id, :category, :jira_type, :SonarQube, :Contrast, :Dep_Check, :Manual_Secure_Code_Review, :Manual_Security_Testing, :remark, :created_by)";
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Analysis</title>
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
	
</head>
<body>
 
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

    <h3>Existing Analysis</h3>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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

</body>
</html>
