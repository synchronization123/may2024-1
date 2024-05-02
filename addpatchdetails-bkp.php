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
    $file_name = "addpatchdetails.php"; // The current file name
    $query = "SELECT * FROM file_access WHERE role_id IN (SELECT role_id FROM users WHERE user_id = :user_id) AND file_name = :file_name AND delete_flag = 0";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':file_name', $file_name);
    $stmt->execute();
    $file_access = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$file_access) {
        throw new Exception("You don't have access to this file.");
    }

    // Fetch assignment_id from POST request
    if (!isset($_POST['assignment_id'])) {
        throw new Exception("Assignment ID is not set.");
    }
    $assignment_id = $_POST['assignment_id'];

    // Validate if assignment_id exists in assignments table
    $query_assignment = "SELECT * FROM assignments WHERE assignment_id = :assignment_id AND delete_flag = 0";
    $stmt_assignment = $db->prepare($query_assignment);
    $stmt_assignment->bindParam(':assignment_id', $assignment_id);
    $stmt_assignment->execute();
    $assignment_exists = $stmt_assignment->fetch(PDO::FETCH_ASSOC);
    if (!$assignment_exists) {
        throw new Exception("Assignment not found.");
    }

    // Fetch patch details based on assignment_id
    $query_patch = "SELECT * FROM patches WHERE assignment_id = :assignment_id";
    $stmt_patch = $db->prepare($query_patch);
    $stmt_patch->bindParam(':assignment_id', $assignment_id);
    $stmt_patch->execute();
    $patch = $stmt_patch->fetch(PDO::FETCH_ASSOC);



// Form submission - update patch details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_patch'])) {
    // Process form submission and update patch details
    $eta = $_POST['eta'];
    $koc_date = $_POST['koc_date'];
    $security_jira = $_POST['security_jira'];
    $functional_jira = $_POST['functional_jira'];
    $notes = $_POST['notes'];
    $comment = $_POST['comment'];
    $emanager_ir = $_POST['emanager_ir'];
    $status = $_POST['status'];
    $certification_status = $_POST['certification_status'];
    $comments = $_POST['comments'];
    $security_validation_status = $_POST['security_validation_status'];
    $third_party_verified = $_POST['third_party_verified'];
    $contrast_verified = $_POST['contrast_verified'];
    $sonar_verified = $_POST['sonar_verified'];
    $secure_code_review = $_POST['secure_code_review'];
    $conclusion = $_POST['conclusion'];
    $qa_env_url = $_POST['qa_env_url'];
    $contrast_server_name = $_POST['contrast_server_name'];
    $qa_servers = $_POST['qa_servers'];
    $tech_imp_count = $_POST['tech_imp_count'];
    $bug_count = $_POST['bug_count'];
    $story_count = $_POST['story_count'];
    $epic_count = $_POST['epic_count'];

    // New columns
    $column_30 = $_POST['Column_30'];
    $column_31 = $_POST['Column_31'];
    $column_32 = $_POST['Column_32'];
    $column_33 = $_POST['Column_33'];
    $column_34=  $_POST['Column_34'];
    $column_35 = $_POST['Column_35'];
    $column_36 = $_POST['Column_36'];
    $column_37 = $_POST['Column_37'];
    $column_38 = $_POST['Column_38'];
    $column_39 = $_POST['Column_39'];
    $column_40 = $_POST['Column_40'];
    $column_41 = $_POST['Column_41'];
    $column_42 = $_POST['Column_42'];
    $column_43 = $_POST['Column_43'];
    $column_44 = $_POST['Column_44'];
    $column_45 = $_POST['Column_45'];
    $column_46 = $_POST['Column_46'];
    $column_47 = $_POST['Column_47'];
    $column_48 = $_POST['Column_48'];
    $column_49 = $_POST['Column_49'];
    $column_50 = $_POST['Column_50'];
	$column_51 = $_POST['Column_51'];
    $column_52 = $_POST['Column_52'];
    $column_53 = $_POST['Column_53'];
    $column_54 = $_POST['Column_54'];
    $column_55 = $_POST['Column_55'];
    $column_56 = $_POST['Column_56'];
    $column_57 = $_POST['Column_57'];
    $column_58 = $_POST['Column_58'];
	$column_59 = $_POST['Column_59'];
	
	$total_no_of_jiras = $_POST['total_no_of_jiras'];
	$no_of_jiras_tested = $_POST['no_of_jiras_tested'];
	$changelog_reviewers = $_POST['changelog_reviewers'];
	$total_time_taken = $_POST['total_time_taken'];
	$mentor_feedback = $_POST['mentor_feedback'];
	$lead_feedback = $_POST['lead_feedback'];
	$mentor_username = $_POST['mentor_username'];
	$lead_username = $_POST['lead_username'];
	
	
    // Log the bound parameters
    error_log("Bound parameters: 
        eta=$eta, 
        koc_date=$koc_date, 
        security_jira=$security_jira, 
        functional_jira=$functional_jira, 
        notes=$notes, 
        comment=$comment, 
        emanager_ir=$emanager_ir, 
        status=$status, 
        certification_status=$certification_status, 
        comments=$comments, 
        security_validation_status=$security_validation_status, 
        third_party_verified=$third_party_verified, 
        contrast_verified=$contrast_verified, 
        sonar_verified=$sonar_verified, 
        secure_code_review=$secure_code_review, 
        conclusion=$conclusion, 
        qa_env_url=$qa_env_url, 
        contrast_server_name=$contrast_server_name, 
        qa_servers=$qa_servers, 
        tech_imp_count=$tech_imp_count, 
        bug_count=$bug_count, 
        story_count=$story_count, 
        epic_count=$epic_count,
        column_30=$column_30, 
        column_31=$column_31, 
        column_32=$column_32, 
        column_33=$column_33,
        column_34=$column_34, 
        column_35=$column_35, 
        column_36=$column_36, 
        column_37=$column_37, 
        column_38=$column_38, 
        column_39=$column_39, 
        column_40=$column_40, 
        column_41=$column_41, 
        column_42=$column_42, 
        column_43=$column_43, 
        column_44=$column_44, 
        column_45=$column_45, 
        column_46=$column_46, 
        column_47=$column_47, 
        column_48=$column_48, 
        column_49=$column_49, 
        column_50=$column_50, 
        column_51=$column_51, 
        column_52=$column_52, 
        column_53=$column_53, 
        column_54=$column_54, 
        column_55=$column_55, 
        column_56=$column_56, 
        column_57=$column_57, 
		column_58=$column_58, 
        column_59=$column_59,
		total_no_of_jiras=$total_no_of_jiras,
		no_of_jiras_tested=$no_of_jiras_tested,
		changelog_reviewers=$changelog_reviewers,
		total_time_taken=$total_time_taken,
		mentor_feedback=$mentor_feedback,
		lead_feedback=$lead_feedback,
		mentor_username=$mentor_username,
		lead_username=$lead_username,
		");

    // Update query for patches table
    $update_query = "UPDATE patches SET 
        comments = :comments, 
        security_validation_status = :security_validation_status, 
        third_party_verified = :third_party_verified, 
        contrast_verified = :contrast_verified, 
        sonar_verified = :sonar_verified, 
        secure_code_review = :secure_code_review, 
        conclusion = :conclusion, 
        qa_env_url = :qa_env_url, 
        contrast_server_name = :contrast_server_name, 
        qa_servers = :qa_servers, 
        tech_imp_count = :tech_imp_count, 
        bug_count = :bug_count, 
        story_count = :story_count, 
        epic_count = :epic_count, 
        eta = :eta, 
        koc_date = :koc_date, 
        security_jira = :security_jira, 
        functional_jira = :functional_jira, 
        notes = :notes, 
        comment = :comment, 
        emanager_ir = :emanager_ir, 
        status = :status, 
        certification_status = :certification_status,
        column_30 = :column_30,
        column_31 = :column_31,
        column_32 = :column_32,
        column_33 = :column_33,
        column_34 = :column_34,
        column_35 = :column_35,
        column_36 = :column_36,
        column_37 = :column_37,
        column_38 = :column_38,
        column_39 = :column_39,
        column_40 = :column_40,
        column_41 = :column_41,
        column_42 = :column_42,
        column_43 = :column_43,
        column_44 = :column_44,
        column_45 = :column_45,
        column_46 = :column_46,
        column_47 = :column_47,
        column_48 = :column_48,
        column_49 = :column_49,
        column_50 = :column_50,
        column_51 = :column_51,
        column_52 = :column_52,
        column_53 = :column_53,
        column_54 = :column_54,
        column_55 = :column_55,
        column_56 = :column_56,
        column_57 = :column_57,
		column_58 = :column_58,
        column_59 = :column_59,
		total_no_of_jiras = :total_no_of_jiras,
		no_of_jiras_tested = :no_of_jiras_tested,
		changelog_reviewers = :changelog_reviewers,
		total_time_taken = :total_time_taken,
		mentor_feedback = :mentor_feedback,
		lead_feedback = :lead_feedback,
		mentor_username = :mentor_username,
		lead_username = :lead_username
		WHERE assignment_id = :assignment_id";

    $stmt_update = $db->prepare($update_query);
    $stmt_update->bindParam(':eta', $eta);
    $stmt_update->bindParam(':koc_date', $koc_date);
    $stmt_update->bindParam(':security_jira', $security_jira);
    $stmt_update->bindParam(':functional_jira', $functional_jira);
    $stmt_update->bindParam(':notes', $notes);
    $stmt_update->bindParam(':comment', $comment);
    $stmt_update->bindParam(':emanager_ir', $emanager_ir);
    $stmt_update->bindParam(':status', $status);
    $stmt_update->bindParam(':certification_status', $certification_status);
    $stmt_update->bindParam(':comments', $comments);
    $stmt_update->bindParam(':security_validation_status', $security_validation_status);
    $stmt_update->bindParam(':third_party_verified', $third_party_verified);
    $stmt_update->bindParam(':contrast_verified', $contrast_verified);
    $stmt_update->bindParam(':sonar_verified', $sonar_verified);
    $stmt_update->bindParam(':secure_code_review', $secure_code_review);
    $stmt_update->bindParam(':conclusion', $conclusion);
    $stmt_update->bindParam(':qa_env_url', $qa_env_url);
    $stmt_update->bindParam(':contrast_server_name', $contrast_server_name);
    $stmt_update->bindParam(':qa_servers', $qa_servers);
    $stmt_update->bindParam(':tech_imp_count', $tech_imp_count);
    $stmt_update->bindParam(':bug_count', $bug_count);
    $stmt_update->bindParam(':story_count', $story_count);
    $stmt_update->bindParam(':epic_count', $epic_count);
    $stmt_update->bindParam(':column_30', $column_30);
    $stmt_update->bindParam(':column_31', $column_31);
    $stmt_update->bindParam(':column_32', $column_32);
    $stmt_update->bindParam(':column_33', $column_33);
    $stmt_update->bindParam(':column_34', $column_34);
    $stmt_update->bindParam(':column_35', $column_35);
    $stmt_update->bindParam(':column_36', $column_36);
    $stmt_update->bindParam(':column_37', $column_37);
    $stmt_update->bindParam(':column_38', $column_38);
    $stmt_update->bindParam(':column_39', $column_39);
    $stmt_update->bindParam(':column_40', $column_40);
    $stmt_update->bindParam(':column_41', $column_41);
    $stmt_update->bindParam(':column_42', $column_42);
    $stmt_update->bindParam(':column_43', $column_43);
    $stmt_update->bindParam(':column_44', $column_44);
    $stmt_update->bindParam(':column_45', $column_45);
    $stmt_update->bindParam(':column_46', $column_46);
    $stmt_update->bindParam(':column_47', $column_47);
    $stmt_update->bindParam(':column_48', $column_48);
    $stmt_update->bindParam(':column_49', $column_49);
    $stmt_update->bindParam(':column_50', $column_50);
    $stmt_update->bindParam(':column_51', $column_51);
    $stmt_update->bindParam(':column_52', $column_52);
    $stmt_update->bindParam(':column_53', $column_53);
    $stmt_update->bindParam(':column_54', $column_54);
    $stmt_update->bindParam(':column_55', $column_55);
    $stmt_update->bindParam(':column_56', $column_56);
    $stmt_update->bindParam(':column_57', $column_57);
	$stmt_update->bindParam(':column_58', $column_58);
    $stmt_update->bindParam(':column_59', $column_59);
	$stmt_update->bindParam(':total_no_of_jiras', $total_no_of_jiras);
	$stmt_update->bindParam(':no_of_jiras_tested', $no_of_jiras_tested);
	$stmt_update->bindParam(':changelog_reviewers', $changelog_reviewers);
	$stmt_update->bindParam(':total_time_taken', $total_time_taken);
	$stmt_update->bindParam(':mentor_feedback', $mentor_feedback);
	$stmt_update->bindParam(':lead_feedback', $lead_feedback);
	$stmt_update->bindParam(':mentor_username', $mentor_username);
	$stmt_update->bindParam(':lead_username', $lead_username);
    $stmt_update->bindParam(':assignment_id', $assignment_id);
    $stmt_update->execute();

    // Redirect to view_assignments.php
    header("Location: dashboard.php");
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
    <title>Add Patch Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom CSS for tab layout */
        .nav-tabs {
            border-bottom: 2px solid #dee2e6;
        }

        .nav-tabs .nav-item {
            margin-bottom: -1px;
        }

        .nav-tabs .nav-link {
            border: none;
            border-radius: 0;
            padding: .5rem 1rem;
        }

        .nav-tabs .nav-link.active {
            background-color: #f8f9fa;
            border-bottom: 2px solid #007bff;
        }

        .tab-content {
            border: 1px solid #dee2e6;
            border-top: none;
            padding: 1rem;
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
	    <script src="https://cdn.ckeditor.com/ckeditor5/36.0.3/classic/ckeditor.js"></script>

	<script>
    ClassicEditor
        .create(document.querySelector('#mentor_feedback'), {
            toolbar: {
                items: [
                    'heading',
                    '|',
                    'bulletedList',
                    'numberedList',
                    '|',
                    'indent',
                    'outdent',
                    '|',
                    'insertTable',
                    'undo',
                    'redo',
                    '|',
                    'fontFamily',
                    'fontSize',
                    'fontColor',
                    'fontBackgroundColor',
                    '|',
                    'bold',
                    'italic',
                    'underline',
                    '|',
                    'alignment',
                    '|',
                    'highlight',
                    'removeFormat'
                ]
            },
            language: 'en',
            table: {
                contentToolbar: [
                    'tableColumn',
                    'tableRow',
                    'mergeTableCells'
                ]
            },
            licenseKey: '',
        })
        .then(mentor_feedback => {
            console.log(mentor_feedback);
        })
        .catch(error => {
            console.error(error);
        });
</script>
</head>
<body>



<div class="form-group">
    <?php if (isset($error_message)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php else : ?>
       
        <form method="post">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#assignment_details">Assignment Details</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#patch_details">Patch Details</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#notes">Notes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#status">Status</a>
                </li>
				<li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#changelogs">Changelogs</a>
                </li>
				<li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#contrast">Contrast</a>
                </li>
				<li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#other">Other</a>
                </li>
				<li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#riskregister">Risk Register</a>
                </li>
				<li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#mentorreview">Mentor Review</a>
				<li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#leadapproval">Lead Approval</a>
                </li>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <!-- Assignment Details Tab -->
               <!-- Assignment Details Tab -->
<div id="assignment_details" class="container tab-pane active"><br>
    <h3>Assignment Details</h3>
    <table class="table table-bordered">
        <tbody>
            <tr>
    <td>Assignment ID:</td>
    <td>
        <a href="addanalysis.php?assignment_id=<?php echo $patch['assignment_id']; ?>" class="assignment-link"><?php echo $patch['assignment_id']; ?></a>
    </td>
</tr>

			
                <td>Assigned On:</td>
                <td><?php echo $patch['assigned_date']; ?></td>
            </tr>
            <tr>
                <td>Aging:</td>
                <td><?php echo $patch['aging']; ?> day(s)</td>
            </tr>
            <tr>
                <td>ETA:</td>
                <td><input type="date" name="eta" value="<?php echo $patch['eta']; ?>"></td>
            </tr>
            <tr>
			
                <td>Title:</td>
                <td><b><u><?php echo $patch['title']; ?></u></b></td>
				 <a href="printpreview.php?assignment_id=<?php echo $patch['assignment_id']; ?>" class="assignment-link">Print Report</a>
            </tr>
            <tr>
                <td>Description:</td>
                <td><?php echo $patch['description']; ?></td>
            </tr>
            <?php
            // Fetch assigned_to user details from users table
            $assigned_to_id = $patch['assigned_to'];
            $query_user = "SELECT ufname, ulname FROM users WHERE user_id = :user_id";
            $stmt_user = $db->prepare($query_user);
            $stmt_user->bindParam(':user_id', $assigned_to_id);
            $stmt_user->execute();
            $user_details = $stmt_user->fetch(PDO::FETCH_ASSOC);
            ?>
            <tr>
                <td>Assigned To:</td>
                <td><?php echo $user_details['ufname'] . " " . $user_details['ulname']; ?></td>
            </tr>
            <tr>
                <td>Product Name:</td>
                <td><?php echo $patch['product_name']; ?></td>
            </tr>
			
			 <tr>
                <td>Total No. of Jiras:</td>
                <td><?php echo $patch['total_no_of_jiras']; ?></td>
            </tr>
			
			 <tr>
                <td>No. of Jiras Tested:</td>
                <td><input type="number" name="no_of_jiras_tested" value="<?php echo $patch['no_of_jiras_tested']; ?>"></td>
            </tr>
			
			 <tr>
                <td>Changelog Reviewers:</td>
                <td><input type="text" name="changelog_reviewers" value="<?php echo $patch['changelog_reviewers']; ?>"></td>
            </tr>
			
			 <tr>
                <td>Total Time Taken: (hh:mm:ss)</td>
                <td><input type="text" name="total_time_taken" value="<?php echo $patch['total_time_taken']; ?>"></td>
            </tr>
			
        </tbody>
    </table>
    <input type="hidden" name="assignment_id" value="<?php echo $assignment_id; ?>">
</div>

<!-- Patch Details Tab -->
<div id="patch_details" class="container tab-pane fade"><br>
    <h3>Patch Details</h3>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <td>Kickoff Date:</td>
                <td><input type="date" name="koc_date" value="<?php echo $patch['koc_date']; ?>"></td>
            </tr>
            <tr>
                <td>Security Jira Count:</td>
                <td><input type="number" name="security_jira" value="<?php echo $patch['security_jira']; ?>"></td>
            </tr>
            <tr>
                <td>Functional Jira Count:</td>
                <td><input type="number" name="functional_jira" value="<?php echo $patch['functional_jira']; ?>"></td>
            </tr>
            <tr>
                <td>Total Jira Count:</td>
                <td><?php echo $patch['total_jira']; ?></td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Notes Tab -->
<div id="notes" class="container tab-pane fade"><br>
    <h3>Notes</h3>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <td>Kickoff Call Notes:</td>
                <td><textarea name="notes" rows="4" cols="50"><?php echo $patch['notes']; ?></textarea></td>
            </tr>
            <tr>
                <td>Comments:</td>
                <td><textarea name="comment" rows="4" cols="50"><?php echo $patch['comment']; ?></textarea></td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Status Tab -->
<div id="status" class="container tab-pane fade"><br>
    <h3>Status</h3>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <td>eManager IR:</td>
                <td><input type="number" name="emanager_ir" value="<?php echo $patch['emanager_ir']; ?>"></td>
         <td>Status:</td>
<td>
    <select name="status">
        <?php
        // Get the role_id of the logged-in user
        $user_id = $_SESSION['user_id'];
        $query_user_role = "SELECT role_id FROM users WHERE user_id = :user_id";
        $stmt_user_role = $db->prepare($query_user_role);
        $stmt_user_role->bindParam(':user_id', $user_id);
        $stmt_user_role->execute();
        $user_role = $stmt_user_role->fetch(PDO::FETCH_ASSOC);

        // Check if user_role query was successful
        if ($user_role) {
            // Query to fetch all statuses
            $query = "SELECT status_name, role_id FROM status WHERE delete_flag = 0";
            $stmt = $db->prepare($query);
            $stmt->execute();

            // Check for errors
            if ($stmt) {
                $statuses = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Loop through status names and create dropdown options
                foreach ($statuses as $status) {
                    // Check if the current status is allowed for the user or if it matches the one in the patch
                    if ($status['role_id'] == $user_role['role_id'] || $status['status_name'] == $patch['status']) {
                        // If allowed, check if the current status matches the one in the patch
                        $selected = ($status['status_name'] == $patch['status']) ? 'selected' : '';

                        // Output the option with the status name and selected attribute if applicable
                        echo "<option value='{$status['status_name']}' $selected>{$status['status_name']}</option>";
                    } else {
                        // If not allowed, disable the option
                        echo "<option value='{$status['status_name']}' disabled>{$status['status_name']} (Not Allowed)</option>";
                    }
                }
            } else {
                // Handle the case where the query fails
                echo "<option value=''>Error retrieving statuses</option>";
            }
        } else {
            // Handle the case where the user_role query fails
            echo "<option value=''>Error retrieving user role</option>";
        }
        ?>
    </select>
</td>
        </tbody>
    </table>
</div>



<!-- Changelog Tab -->
<div id="changelogs" class="container tab-pane fade"><br>
    <h3>Changelogs</h3>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <td>Epic Count:</td>
                <td><input type="text" name="epic_count" value="<?php echo $patch['epic_count']; ?>"></td>
            </tr>
            <tr>
                <td>Story Count:</td>
                <td><input type="text" name="story_count" value="<?php echo $patch['story_count']; ?>"></td>
            </tr>
            <tr>
                <td>Bug Count:</td>
                <td><input type="text" name="bug_count" value="<?php echo $patch['bug_count']; ?>"></td>
            </tr>
			<tr>
                <td>Technical Improvement Count:</td>
                <td><input type="text" name="tech_imp_count" value="<?php echo $patch['tech_imp_count']; ?>"></td>
            </tr>
			
        </tbody>
    </table>
</div>




<!-- Contrast Tab -->
<div id="contrast" class="container tab-pane fade"><br>
    <h3>Contrast</h3>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <td>QA Servers:</td>
                <td><input type="text" name="qa_servers" value="<?php echo $patch['qa_servers']; ?>"></td>
            </tr>
            <tr>
                <td>Contrast Server Name:</td>
                <td><input type="text" name="contrast_server_name" value="<?php echo $patch['contrast_server_name']; ?>"></td>
            </tr>
            <tr>
                <td>QA Env URL:</td>
                <td><input type="text" name="qa_env_url" value="<?php echo $patch['qa_env_url']; ?>"></td>
            </tr>
			</tbody>
    </table>
</div>






<!-- Other Tab -->
<div id="other" class="container tab-pane fade"><br>
    <h3>Other</h3>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <td>Conclusion:</td>
                				<td><textarea name="conclusion" rows="4" cols="50"><?php echo $patch['conclusion']; ?></textarea></td>
				
				
            </tr>
            <tr>
                <td>Secure Code Review:</td>
                <td>
    <select name="secure_code_review">
        <option value="NA" <?php if ($patch['secure_code_review'] == "NA") echo "selected"; ?>>NA</option>
        <option value="Done" <?php if ($patch['secure_code_review'] == "Done") echo "selected"; ?>>Done</option>
        <option value="Not Done" <?php if ($patch['secure_code_review'] == "Not Done") echo "selected"; ?>>Not Done</option>
           </select>
</td>

            </tr>
            <tr>
                <td>Sonar Verified:</td>
				<td>
    <select name="sonar_verified">
        <option value="NA" <?php if ($patch['sonar_verified'] == "NA") echo "selected"; ?>>NA</option>
        <option value="Done" <?php if ($patch['sonar_verified'] == "Done") echo "selected"; ?>>Done</option>
        <option value="Not Done" <?php if ($patch['sonar_verified'] == "Not Done") echo "selected"; ?>>Not Done</option>
           </select></td>
            </tr>
			<tr>
                <td>Contrast Verified:</td>
                <td>
    <select name="contrast_verified">
        <option value="NA" <?php if ($patch['contrast_verified'] == "NA") echo "selected"; ?>>NA</option>
        <option value="Done" <?php if ($patch['contrast_verified'] == "Done") echo "selected"; ?>>Done</option>
        <option value="Not Done" <?php if ($patch['contrast_verified'] == "Not Done") echo "selected"; ?>>Not Done</option>
           </select></td>
				
            </tr>
			<tr>
                <td>Third Party Verified:</td>
                
				<td>
    <select name="third_party_verified">
        <option value="NA" <?php if ($patch['third_party_verified'] == "NA") echo "selected"; ?>>NA</option>
        <option value="Done" <?php if ($patch['third_party_verified'] == "Done") echo "selected"; ?>>Done</option>
        <option value="Not Done" <?php if ($patch['third_party_verified'] == "Not Done") echo "selected"; ?>>Not Done</option>
           </select></td>
				
				
				
				
				
            </tr>
			<tr>
                <td>Secure Validation Status:</td>
				
				
				<td>
    <select name="security_validation_status">
        <option value="NA" <?php if ($patch['security_validation_status'] == "NA") echo "selected"; ?>>NA</option>
        <option value="Done" <?php if ($patch['security_validation_status'] == "Done") echo "selected"; ?>>Done</option>
        <option value="Not Done" <?php if ($patch['security_validation_status'] == "Not Done") echo "selected"; ?>>Not Done</option>
           </select></td>
				
				
            </tr>
			<tr>
                <td>Comments:</td>

				
				<td><textarea name="comments" rows="4" cols="50"><?php echo $patch['comments']; ?></textarea></td>
				
            </tr>
			</tbody>
    </table>
</div>





<!-- Other Tab -->
<div id="riskregister" class="container tab-pane fade"><br>
    <h3>Risk Register</h3>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <td>Column30:</td>
                <td><input type="text" name="Column_30" value="<?php echo $patch['Column_30']; ?>"></td>
            </tr>
            <tr>
                <td>Column31:</td>
                <td><input type="text" name="Column_31" value="<?php echo $patch['Column_31']; ?>"></td>
            </tr>
			<tr>
                <td>Column32:</td>
                <td><input type="text" name="Column_32" value="<?php echo $patch['Column_32']; ?>"></td>
            </tr>
			<tr>
                <td>Column33:</td>
                <td><input type="text" name="Column_33" value="<?php echo $patch['Column_33']; ?>"></td>
            </tr>
			<tr>
                <td>Column34:</td>
                <td><input type="text" name="Column_34" value="<?php echo $patch['Column_34']; ?>"></td>
            </tr>
			<tr>
                <td>Column35:</td>
                <td><input type="text" name="Column_35" value="<?php echo $patch['Column_35']; ?>"></td>
            </tr>
			<tr>
                <td>Column36:</td>
                <td><input type="text" name="Column_36" value="<?php echo $patch['Column_36']; ?>"></td>
            </tr>
			<tr>
                <td>Column37:</td>
                <td><input type="text" name="Column_37" value="<?php echo $patch['Column_37']; ?>"></td>
            </tr>
			<tr>
                <td>Column38:</td>
                <td><input type="text" name="Column_38" value="<?php echo $patch['Column_38']; ?>"></td>
            </tr>
			<tr>
                <td>Column39:</td>
                <td><input type="text" name="Column_39" value="<?php echo $patch['Column_39']; ?>"></td>
            </tr>
			<tr>
                <td>Column40:</td>
                <td><input type="text" name="Column_40" value="<?php echo $patch['Column_40']; ?>"></td>
            </tr>
			<tr>
                <td>Column41:</td>
                <td><input type="text" name="Column_41" value="<?php echo $patch['Column_41']; ?>"></td>
            </tr>
			<tr>
                <td>Column42:</td>
                <td><input type="text" name="Column_42" value="<?php echo $patch['Column_42']; ?>"></td>
            </tr>
			<tr>
                <td>Column43:</td>
                <td><input type="text" name="Column_43" value="<?php echo $patch['Column_43']; ?>"></td>
            </tr>
			<tr>
                <td>Column44:</td>
                <td><input type="text" name="Column_44" value="<?php echo $patch['Column_44']; ?>"></td>
            </tr>
			<tr>
                <td>Column45:</td>
                <td><input type="text" name="Column_45" value="<?php echo $patch['Column_45']; ?>"></td>
            </tr>
			<tr>
                <td>Column46:</td>
                <td><input type="text" name="Column_46" value="<?php echo $patch['Column_46']; ?>"></td>
            </tr>
			<tr>
                <td>Column47:</td>
                <td><input type="text" name="Column_47" value="<?php echo $patch['Column_47']; ?>"></td>
            </tr>
			<tr>
                <td>Column48:</td>
                <td><input type="text" name="Column_48" value="<?php echo $patch['Column_48']; ?>"></td>
            </tr>
			<tr>
                <td>Column49:</td>
                <td><input type="text" name="Column_49" value="<?php echo $patch['Column_49']; ?>"></td>
            </tr>
			<tr>
                <td>Column50:</td>
                <td><input type="text" name="Column_50" value="<?php echo $patch['Column_50']; ?>"></td>
            </tr>
			<tr>
                <td>Column51:</td>
                <td><input type="text" name="Column_51" value="<?php echo $patch['Column_51']; ?>"></td>
            </tr>
			<tr>
                <td>Column52:</td>
                <td><input type="text" name="Column_52" value="<?php echo $patch['Column_52']; ?>"></td>
            </tr>
			<tr>
                <td>Column53:</td>
                <td><input type="text" name="Column_53" value="<?php echo $patch['Column_53']; ?>"></td>
            </tr>
			<tr>
                <td>Column54:</td>
                <td><input type="text" name="Column_54" value="<?php echo $patch['Column_54']; ?>"></td>
            </tr>
			<tr>
                <td>Column55:</td>
                <td><input type="text" name="Column_55" value="<?php echo $patch['Column_55']; ?>"></td>
            </tr>
			<tr>
                <td>Column56:</td>
                <td><input type="text" name="Column_56" value="<?php echo $patch['Column_56']; ?>"></td>
            </tr>
			<tr>
                <td>Column57:</td>
                <td><input type="text" name="Column_57" value="<?php echo $patch['Column_57']; ?>"></td>
            </tr>
			<tr>
                <td>Column58:</td>
                <td><input type="text" name="Column_58" value="<?php echo $patch['Column_58']; ?>"></td>
            </tr>
			<tr>
                <td>Column59:</td>
                <td><input type="text" name="Column_59" value="<?php echo $patch['Column_59']; ?>"></td>
            </tr>
			
	
			
			</tbody>
    </table>
</div>


<div id="mentorreview" class="container tab-pane fade"><br>
   
    <table class="table table-bordered">
        <tbody>
           		<tr>
                <td>eManager IR:</td>
                <td><?php echo $patch['emanager_ir']; ?></td>
            </tr>
            <tr>
                
				 <a href="mentorreview.php?assignment_id=<?php echo $patch['assignment_id']; ?>" class="assignment-link">Review Patch</a>
            </tr>
			<tr>
			    <td>Status:</td>
<td>
    <select name="status">
        <?php
        // Get the role_id of the logged-in user
        $user_id = $_SESSION['user_id'];
        $query_user_role = "SELECT role_id FROM users WHERE user_id = :user_id";
        $stmt_user_role = $db->prepare($query_user_role);
        $stmt_user_role->bindParam(':user_id', $user_id);
        $stmt_user_role->execute();
        $user_role = $stmt_user_role->fetch(PDO::FETCH_ASSOC);

        // Check if user_role query was successful
        if ($user_role) {
            // Query to fetch all statuses
            $query = "SELECT status_name, role_id FROM status WHERE delete_flag = 0";
            $stmt = $db->prepare($query);
            $stmt->execute();

            // Check for errors
            if ($stmt) {
                $statuses = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Loop through status names and create dropdown options
                foreach ($statuses as $status) {
                    // Check if the current status is allowed for the user or if it matches the one in the patch
                    if ($status['role_id'] == $user_role['role_id'] || $status['status_name'] == $patch['status']) {
                        // If allowed, check if the current status matches the one in the patch
                        $selected = ($status['status_name'] == $patch['status']) ? 'selected' : '';

                        // Output the option with the status name and selected attribute if applicable
                        echo "<option value='{$status['status_name']}' $selected>{$status['status_name']}</option>";
                    } else {
                        // If not allowed, disable the option
                        echo "<option value='{$status['status_name']}' disabled>{$status['status_name']} (Not Allowed)</option>";
                    }
                }
            } else {
                // Handle the case where the query fails
                echo "<option value=''>Error retrieving statuses</option>";
            }
        } else {
            // Handle the case where the user_role query fails
            echo "<option value=''>Error retrieving user role</option>";
        }
        ?>
    </select>
</td>
    <td>Reviewed by:</td>
    <td>
        <select name="mentor_username">
            <?php
            // Query to fetch users with role_id=4 and delete_flag=0
            $query = "SELECT user_id, ufname, ulname FROM users WHERE role_id = 4 AND delete_flag = 0";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Iterate over fetched users and populate the dropdown
            foreach ($users as $user) {
                $selected = ($user['user_id'] == $patch['mentor_username']) ? "selected" : "";
                echo "<option value='{$user['user_id']}' $selected>{$user['ufname']} {$user['ulname']}</option>";
            }
            ?>
        </select>
    </td>
</tr>

			
			
			<tr>
                <td>Feedback:</td>
                <td><textarea name="mentor_feedback" rows="4" cols="50"><?php echo $patch['mentor_feedback']; ?></textarea></td>
            </tr>
			<script>
        ClassicEditor
            .create(document.querySelector('#mentor_feedback'))
            .then(mentor_feedback => {
                console.log(mentor_feedback);
            })
            .catch(error => {
                console.error(error);
            });
    </script>
	

        </tbody>
    </table>
    <input type="hidden" name="assignment_id" value="<?php echo $assignment_id; ?>">
</div>





<div id="leadapproval" class="container tab-pane fade"><br>
   
    <table class="table table-bordered">
        <tbody>
           		
            <tr>
                
				 <a href="leadapproval.php?assignment_id=<?php echo $patch['assignment_id']; ?>" class="assignment-link">Preview details</a>
            </tr>
			<tr>
                <td>eManager IR:</td>
                <td><?php echo $patch['emanager_ir']; ?></td>
            
			
    <td>Approved by:</td>
    <td>
        <select name="lead_username">
            <?php
            // Query to fetch users with role_id=4 and delete_flag=0
            $query = "SELECT user_id, ufname, ulname FROM users WHERE role_id = 3 AND delete_flag = 0";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Iterate over fetched users and populate the dropdown
            foreach ($users as $user) {
                $selected = ($user['user_id'] == $patch['lead_username']) ? "selected" : "";
                echo "<option value='{$user['user_id']}' $selected>{$user['ufname']} {$user['ulname']}</option>";
            }
            ?>
        </select>
    </td>
</tr>
<tr>
			    <td>Status:</td>
<td>
    <select name="status">
        <?php
        // Get the role_id of the logged-in user
        $user_id = $_SESSION['user_id'];
        $query_user_role = "SELECT role_id FROM users WHERE user_id = :user_id";
        $stmt_user_role = $db->prepare($query_user_role);
        $stmt_user_role->bindParam(':user_id', $user_id);
        $stmt_user_role->execute();
        $user_role = $stmt_user_role->fetch(PDO::FETCH_ASSOC);

        // Check if user_role query was successful
        if ($user_role) {
            // Query to fetch all statuses
            $query = "SELECT status_name, role_id FROM status WHERE delete_flag = 0";
            $stmt = $db->prepare($query);
            $stmt->execute();

            // Check for errors
            if ($stmt) {
                $statuses = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Loop through status names and create dropdown options
                foreach ($statuses as $status) {
                    // Check if the current status is allowed for the user or if it matches the one in the patch
                    if ($status['role_id'] == $user_role['role_id'] || $status['status_name'] == $patch['status']) {
                        // If allowed, check if the current status matches the one in the patch
                        $selected = ($status['status_name'] == $patch['status']) ? 'selected' : '';

                        // Output the option with the status name and selected attribute if applicable
                        echo "<option value='{$status['status_name']}' $selected>{$status['status_name']}</option>";
                    } else {
                        // If not allowed, disable the option
                        echo "<option value='{$status['status_name']}' disabled>{$status['status_name']} (Not Allowed)</option>";
                    }
                }
            } else {
                // Handle the case where the query fails
                echo "<option value=''>Error retrieving statuses</option>";
            }
        } else {
            // Handle the case where the user_role query fails
            echo "<option value=''>Error retrieving user role</option>";
        }
        ?>
    </select>
</td>
			<tr>
                <td>Feedback:</td>
                <td><textarea name="lead_feedback" rows="4" cols="50"><?php echo $patch['lead_feedback']; ?></textarea></td>
            </tr>
			</td>


  <td>Certification Status:</td>
<td>
    <select name="certification_status">
        <option value="Approved" <?php if ($patch['certification_status'] == "Approved") echo "selected"; ?>>Approved</option>
        <option value="Approved with Exception" <?php if ($patch['certification_status'] == "Approved with Exception") echo "selected"; ?>>Approved with Exception</option>
        <option value="Rejected" <?php if ($patch['certification_status'] == "Rejected") echo "selected"; ?>>Rejected</option>
        <option value="OnHold" <?php if ($patch['certification_status'] == "OnHold") echo "selected"; ?>>OnHold</option>
    </select>
</td>


        </tbody>
    </table>
    <input type="hidden" name="assignment_id" value="<?php echo $assignment_id; ?>">
</div>













            <!-- Save button -->
            <button type="submit" class="btn btn-primary" name="update_patch">Save</button>
        </form>
    <?php endif; ?>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
