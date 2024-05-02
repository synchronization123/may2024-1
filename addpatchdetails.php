<?php
session_start();

// Include your database connection file
include_once "db_connect.php";

// Exception and error handling
try {
    // Query to fetch user's role
    $user_id = $_SESSION['user_id'];
	$db->query("SET @user_id := $user_id");

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
    $query_not_set = "SELECT p.*, u.ufname, u.ulname 
FROM patches p
LEFT JOIN users u ON p.assigned_to = u.user_id
WHERE p.assigned_to = :user_id 
AND (p.eta IS NULL OR p.eta = '0000-00-00') 
AND p.delete_flag = 0;
";
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
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

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
        Add Patch Details
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
    $query_assignment = "SELECT * FROM patches WHERE assignment_id = :assignment_id AND delete_flag = 0";
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
	$status_mentor = $_POST['status_mentor'];
	$status_lead = $_POST['status_lead'];
    // New columns
    $sql_injection = $_POST['sql_injection'];
    $xss = $_POST['xss'];
    $path_traversal = $_POST['path_traversal'];
    $command_injection = $_POST['command_injection'];
    $xxe=  $_POST['xxe'];
    $readline = $_POST['readline'];
    $header_injection = $_POST['header_injection'];
    $insecure_deserial = $_POST['insecure_deserial'];
    $session_test = $_POST['session_test'];
    $out_of_band = $_POST['out_of_band'];
    $sensitive_info_querystring = $_POST['sensitive_info_querystring'];
    $vul_crypto_algo = $_POST['vul_crypto_algo'];
    $sensitive_info_logs = $_POST['sensitive_info_logs'];
    $tbv = $_POST['tbv'];
    $sensitive_info_response = $_POST['sensitive_info_response'];
    $hardcoded_cred = $_POST['hardcoded_cred'];
    $csv_injection = $_POST['csv_injection'];
    $unrestricted_fileupload = $_POST['unrestricted_fileupload'];
    $unnecessary_file_distribution = $_POST['unnecessary_file_distribution'];
    $ssrf = $_POST['ssrf'];
    $vul_components = $_POST['vul_components'];
	$root_detection = $_POST['root_detection'];
    $improper_error_handling = $_POST['improper_error_handling'];
    $reverse_tabnabbing = $_POST['reverse_tabnabbing'];
    $weak_access_control = $_POST['weak_access_control'];
    $weak_random_number = $_POST['weak_random_number'];
    $sessionless_js = $_POST['sessionless_js'];
    $removal_jcryption_files = $_POST['removal_jcryption_files'];
    $log_injection = $_POST['log_injection'];
	
	
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
        sql_injection=$sql_injection, 
        xss=$xss, 
        path_traversal=$path_traversal, 
        command_injection=$command_injection,
        xxe=$xxe, 
        readline=$readline, 
        header_injection=$header_injection, 
        insecure_deserial=$insecure_deserial, 
        session_test=$session_test, 
        out_of_band=$out_of_band, 
        sensitive_info_querystring=$sensitive_info_querystring, 
        vul_crypto_algo=$vul_crypto_algo, 
        sensitive_info_logs=$sensitive_info_logs, 
        tbv=$tbv, 
        sensitive_info_response=$sensitive_info_response, 
        hardcoded_cred=$hardcoded_cred, 
        csv_injection=$csv_injection, 
        unrestricted_fileupload=$unrestricted_fileupload, 
        unnecessary_file_distribution=$unnecessary_file_distribution, 
        ssrf=$ssrf, 
        vul_components=$vul_components, 
        root_detection=$root_detection, 
        improper_error_handling=$improper_error_handling, 
        reverse_tabnabbing=$reverse_tabnabbing, 
        weak_access_control=$weak_access_control, 
        weak_random_number=$weak_random_number, 
        sessionless_js=$sessionless_js, 
        removal_jcryption_files=$removal_jcryption_files, 
		log_injection=$log_injection, 
        status_mentor=$status_mentor,
		status_lead=$status_lead,
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
        sql_injection = :sql_injection,
        xss = :xss,
        path_traversal = :path_traversal,
        command_injection = :command_injection,
        xxe = :xxe,
        readline = :readline,
        header_injection = :header_injection,
        insecure_deserial = :insecure_deserial,
        session_test = :session_test,
        out_of_band = :out_of_band,
        sensitive_info_querystring = :sensitive_info_querystring,
        vul_crypto_algo = :vul_crypto_algo,
        sensitive_info_logs = :sensitive_info_logs,
        tbv = :tbv,
        sensitive_info_response = :sensitive_info_response,
        hardcoded_cred = :hardcoded_cred,
        csv_injection = :csv_injection,
        unrestricted_fileupload = :unrestricted_fileupload,
        unnecessary_file_distribution = :unnecessary_file_distribution,
        ssrf = :ssrf,
        vul_components = :vul_components,
        root_detection = :root_detection,
        improper_error_handling = :improper_error_handling,
        reverse_tabnabbing = :reverse_tabnabbing,
        weak_access_control = :weak_access_control,
        weak_random_number = :weak_random_number,
        sessionless_js = :sessionless_js,
        removal_jcryption_files = :removal_jcryption_files,
		log_injection = :log_injection,
        total_no_of_jiras = :total_no_of_jiras,
		no_of_jiras_tested = :no_of_jiras_tested,
		changelog_reviewers = :changelog_reviewers,
		total_time_taken = :total_time_taken,
		mentor_feedback = :mentor_feedback,
		lead_feedback = :lead_feedback,
		mentor_username = :mentor_username,
		status_mentor = :status_mentor,
		status_lead = :status_lead,
		lead_username = :lead_username
		WHERE assignment_id = :assignment_id AND delete_flag = 0  LIMIT 1";

    $stmt_update = $db->prepare($update_query);
    $stmt_update->bindParam(':eta', $eta);
	$stmt_update->bindParam(':status_mentor', $status_mentor);
	$stmt_update->bindParam(':status_lead', $status_lead);
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
    $stmt_update->bindParam(':sql_injection', $sql_injection);
    $stmt_update->bindParam(':xss', $xss);
    $stmt_update->bindParam(':path_traversal', $path_traversal);
    $stmt_update->bindParam(':command_injection', $command_injection);
    $stmt_update->bindParam(':xxe', $xxe);
    $stmt_update->bindParam(':readline', $readline);
    $stmt_update->bindParam(':header_injection', $header_injection);
    $stmt_update->bindParam(':insecure_deserial', $insecure_deserial);
    $stmt_update->bindParam(':session_test', $session_test);
    $stmt_update->bindParam(':out_of_band', $out_of_band);
    $stmt_update->bindParam(':sensitive_info_querystring', $sensitive_info_querystring);
    $stmt_update->bindParam(':vul_crypto_algo', $vul_crypto_algo);
    $stmt_update->bindParam(':sensitive_info_logs', $sensitive_info_logs);
    $stmt_update->bindParam(':tbv', $tbv);
    $stmt_update->bindParam(':sensitive_info_response', $sensitive_info_response);
    $stmt_update->bindParam(':hardcoded_cred', $hardcoded_cred);
    $stmt_update->bindParam(':csv_injection', $csv_injection);
    $stmt_update->bindParam(':unrestricted_fileupload', $unrestricted_fileupload);
    $stmt_update->bindParam(':unnecessary_file_distribution', $unnecessary_file_distribution);
    $stmt_update->bindParam(':ssrf', $ssrf);
    $stmt_update->bindParam(':vul_components', $vul_components);
    $stmt_update->bindParam(':root_detection', $root_detection);
    $stmt_update->bindParam(':improper_error_handling', $improper_error_handling);
    $stmt_update->bindParam(':reverse_tabnabbing', $reverse_tabnabbing);
    $stmt_update->bindParam(':weak_access_control', $weak_access_control);
    $stmt_update->bindParam(':weak_random_number', $weak_random_number);
    $stmt_update->bindParam(':sessionless_js', $sessionless_js);
    $stmt_update->bindParam(':removal_jcryption_files', $removal_jcryption_files);
	$stmt_update->bindParam(':log_injection', $log_injection);
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



<div class="form-group">
    <?php if (isset($error_message)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php else : ?>
       
        <form method="post">
  <div class="container mt-5">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link active" id="assignment-tab" data-toggle="tab" href="#assignment_details">Assignment Details</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="patchdetails-tab" data-toggle="tab" href="#patch_details">Patch Details</a>
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
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#leadapproval">Lead Approval</a>
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
				 <a href="print.php?assignment_id=<?php echo $patch['assignment_id']; ?>" class="assignment-link">Print Report</a>
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
<td>
    <?php 
    if (is_array($user_details) && isset($user_details['ufname']) && isset($user_details['ulname'])) {
        echo $user_details['ufname'] . " " . $user_details['ulname']; 
    } else {
        echo "Unknown"; // Or handle the case where $user_details is not as expected
    }
    ?>
</td>

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
                <td>SQL Injection:</td>
                <td><select name="sql_injection">
        <option value="NA" <?php if ($patch['sql_injection'] == "NA") echo "selected"; ?>>NA</option>
        <option value="Found" <?php if ($patch['sql_injection'] == "Found") echo "selected"; ?>>Found</option>
        <option value="Not Found" <?php if ($patch['sql_injection'] == "Not Found") echo "selected"; ?>>Not Found</option>
           </select></td>
            </tr>	
			
			
<tr>
            <td>XSS-Cross Site Scripting</td>
                <td><select name="xss">
        <option value="NA" <?php if ($patch['xss'] == "NA") echo "selected"; ?>>NA</option>
        <option value="Found" <?php if ($patch['xss'] == "Found") echo "selected"; ?>>Found</option>
        <option value="Not Found" <?php if ($patch['xss'] == "Not Found") echo "selected"; ?>>Not Found</option>
           </select></td>
            </tr>	
			
			
			<tr>
                <td>Path Traversal:</td>
                <td><select name="path_traversal">
        <option value="NA" <?php if ($patch['path_traversal'] == "NA") echo "selected"; ?>>NA</option>
        <option value="Found" <?php if ($patch['path_traversal'] == "Found") echo "selected"; ?>>Found</option>
        <option value="Not Found" <?php if ($patch['path_traversal'] == "Not Found") echo "selected"; ?>>Not Found</option>
           </select></td>
            </tr>
			<tr>
                <td>Command Injection:</td>
               <td><select name="command_injection">
        <option value="NA" <?php if ($patch['command_injection'] == "NA") echo "selected"; ?>>NA</option>
        <option value="Found" <?php if ($patch['command_injection'] == "Found") echo "selected"; ?>>Found</option>
        <option value="Not Found" <?php if ($patch['command_injection'] == "Not Found") echo "selected"; ?>>Not Found</option>
           </select></td>
            </tr>
			<tr>
                <td>XXE:</td>
                <td><select name="xxe">
        <option value="NA" <?php if ($patch['xxe'] == "NA") echo "selected"; ?>>NA</option>
        <option value="Found" <?php if ($patch['xxe'] == "Found") echo "selected"; ?>>Found</option>
        <option value="Not Found" <?php if ($patch['xxe'] == "Not Found") echo "selected"; ?>>Not Found</option>
           </select></td>
            </tr>
			<tr>
                <td>ReadLine Vulnerability:</td>
               <td><select name="readline">
        <option value="NA" <?php if ($patch['readline'] == "NA") echo "selected"; ?>>NA</option>
        <option value="Found" <?php if ($patch['readline'] == "Found") echo "selected"; ?>>Found</option>
        <option value="Not Found" <?php if ($patch['readline'] == "Not Found") echo "selected"; ?>>Not Found</option>
           </select></td>
            </tr>
			<tr>
                <td>Header Injection:</td>
                <td><select name="header_injection">
        <option value="NA" <?php if ($patch['header_injection'] == "NA") echo "selected"; ?>>NA</option>
        <option value="Found" <?php if ($patch['header_injection'] == "Found") echo "selected"; ?>>Found</option>
        <option value="Not Found" <?php if ($patch['header_injection'] == "Not Found") echo "selected"; ?>>Not Found</option>
           </select></td>
            </tr>
			<tr>
                <td>Insecure deserialization:</td>
                <td><select name="insecure_deserial">
        <option value="NA" <?php if ($patch['insecure_deserial'] == "NA") echo "selected"; ?>>NA</option>
        <option value="Found" <?php if ($patch['insecure_deserial'] == "Found") echo "selected"; ?>>Found</option>
        <option value="Not Found" <?php if ($patch['insecure_deserial'] == "Not Found") echo "selected"; ?>>Not Found</option>
           </select></td>
            </tr>
			<tr>
                <td>Session test on the product:</td>
               <td><select name="session_test">
        <option value="NA" <?php if ($patch['session_test'] == "NA") echo "selected"; ?>>NA</option>
        <option value="Found" <?php if ($patch['session_test'] == "Found") echo "selected"; ?>>Found</option>
        <option value="Not Found" <?php if ($patch['session_test'] == "Not Found") echo "selected"; ?>>Not Found</option>
           </select></td>
            </tr>
			<tr>
                <td>Out of band communication:</td>
                <td><select name="out_of_band">
        <option value="NA" <?php if ($patch['out_of_band'] == "NA") echo "selected"; ?>>NA</option>
        <option value="Found" <?php if ($patch['out_of_band'] == "Found") echo "selected"; ?>>Found</option>
        <option value="Not Found" <?php if ($patch['out_of_band'] == "Not Found") echo "selected"; ?>>Not Found</option>
           </select></td>
            </tr>
			<tr>
                <td>Sensitive Information in QueryString:</td>
                <td><select name="sensitive_info_querystring">
        <option value="NA" <?php if ($patch['sensitive_info_querystring'] == "NA") echo "selected"; ?>>NA</option>
        <option value="Found" <?php if ($patch['sensitive_info_querystring'] == "Found") echo "selected"; ?>>Found</option>
        <option value="Not Found" <?php if ($patch['sensitive_info_querystring'] == "Not Found") echo "selected"; ?>>Not Found</option>
           </select></td>
            </tr>
			<tr>
                <td>Vulnerable Cryptographic Algorithms:</td>
                <td><select name="vul_crypto_algo">
        <option value="NA" <?php if ($patch['vul_crypto_algo'] == "NA") echo "selected"; ?>>NA</option>
        <option value="Found" <?php if ($patch['vul_crypto_algo'] == "Found") echo "selected"; ?>>Found</option>
        <option value="Not Found" <?php if ($patch['vul_crypto_algo'] == "Not Found") echo "selected"; ?>>Not Found</option>
           </select></td>
            </tr>
			<tr>
                <td>Sensitive Information in Logs:</td>
                <td><select name="sensitive_info_logs">
        <option value="NA" <?php if ($patch['sensitive_info_logs'] == "NA") echo "selected"; ?>>NA</option>
        <option value="Found" <?php if ($patch['sensitive_info_logs'] == "Found") echo "selected"; ?>>Found</option>
        <option value="Not Found" <?php if ($patch['sensitive_info_logs'] == "Not Found") echo "selected"; ?>>Not Found</option>
           </select></td>
            </tr>
			<tr>
                <td>Trust Boundary Violation:</td>
                <td><select name="tbv">
        <option value="NA" <?php if ($patch['tbv'] == "NA") echo "selected"; ?>>NA</option>
        <option value="Found" <?php if ($patch['tbv'] == "Found") echo "selected"; ?>>Found</option>
        <option value="Not Found" <?php if ($patch['tbv'] == "Not Found") echo "selected"; ?>>Not Found</option>
           </select></td>
            </tr>
			<tr>
                <td>Sensitive data disclosure in response:</td>
                <td><select name="sensitive_info_response">
        <option value="NA" <?php if ($patch['sensitive_info_response'] == "NA") echo "selected"; ?>>NA</option>
        <option value="Found" <?php if ($patch['sensitive_info_response'] == "Found") echo "selected"; ?>>Found</option>
        <option value="Not Found" <?php if ($patch['sensitive_info_response'] == "Not Found") echo "selected"; ?>>Not Found</option>
           </select></td>
            </tr>
			<tr>
                <td>Hardcoded Credentials:</td>
                <td><select name="hardcoded_cred">
        <option value="NA" <?php if ($patch['hardcoded_cred'] == "NA") echo "selected"; ?>>NA</option>
        <option value="Found" <?php if ($patch['hardcoded_cred'] == "Found") echo "selected"; ?>>Found</option>
        <option value="Not Found" <?php if ($patch['hardcoded_cred'] == "Not Found") echo "selected"; ?>>Not Found</option>
           </select></td>
            </tr>
			<tr>
                <td>CSV Injection:</td>
                <td><select name="csv_injection">
        <option value="NA" <?php if ($patch['csv_injection'] == "NA") echo "selected"; ?>>NA</option>
        <option value="Found" <?php if ($patch['csv_injection'] == "Found") echo "selected"; ?>>Found</option>
        <option value="Not Found" <?php if ($patch['csv_injection'] == "Not Found") echo "selected"; ?>>Not Found</option>
           </select></td>
            </tr>
			<tr>
                <td>Unrestricted File Upload:</td>
                <td><select name="unrestricted_fileupload">
        <option value="NA" <?php if ($patch['unrestricted_fileupload'] == "NA") echo "selected"; ?>>NA</option>
        <option value="Found" <?php if ($patch['unrestricted_fileupload'] == "Found") echo "selected"; ?>>Found</option>
        <option value="Not Found" <?php if ($patch['unrestricted_fileupload'] == "Not Found") echo "selected"; ?>>Not Found</option>
           </select></td>
            </tr>
			<tr>
                <td>Unnecessary files present in the distribution (Eg: .py, .exe, .rb):</td>
                <td><select name="unnecessary_file_distribution">
        <option value="NA" <?php if ($patch['unnecessary_file_distribution'] == "NA") echo "selected"; ?>>NA</option>
        <option value="Found" <?php if ($patch['unnecessary_file_distribution'] == "Found") echo "selected"; ?>>Found</option>
        <option value="Not Found" <?php if ($patch['unnecessary_file_distribution'] == "Not Found") echo "selected"; ?>>Not Found</option>
           </select></td>
            </tr>
			<tr>
                <td>Server-side request forgery:</td>
               <td><select name="ssrf">
        <option value="NA" <?php if ($patch['ssrf'] == "NA") echo "selected"; ?>>NA</option>
        <option value="Found" <?php if ($patch['ssrf'] == "Found") echo "selected"; ?>>Found</option>
        <option value="Not Found" <?php if ($patch['ssrf'] == "Not Found") echo "selected"; ?>>Not Found</option>
           </select></td>
            </tr>
			<tr>
                <td>Vulnerable Components(Jar/JS):</td>
                <td><select name="vul_components">
        <option value="NA" <?php if ($patch['vul_components'] == "NA") echo "selected"; ?>>NA</option>
        <option value="Found" <?php if ($patch['vul_components'] == "Found") echo "selected"; ?>>Found</option>
        <option value="Not Found" <?php if ($patch['vul_components'] == "Not Found") echo "selected"; ?>>Not Found</option>
           </select></td>
            </tr>
			<tr>
                <td>Root detection/Jailbreak detection bypass:</td>
                <td><select name="root_detection">
        <option value="NA" <?php if ($patch['root_detection'] == "NA") echo "selected"; ?>>NA</option>
        <option value="Found" <?php if ($patch['root_detection'] == "Found") echo "selected"; ?>>Found</option>
        <option value="Not Found" <?php if ($patch['root_detection'] == "Not Found") echo "selected"; ?>>Not Found</option>
           </select></td>
            </tr>
			<tr>
                <td>Improper Error Handling & Testing for Stack Traces:</td>
                <td><select name="improper_error_handling">
        <option value="NA" <?php if ($patch['improper_error_handling'] == "NA") echo "selected"; ?>>NA</option>
        <option value="Found" <?php if ($patch['improper_error_handling'] == "Found") echo "selected"; ?>>Found</option>
        <option value="Not Found" <?php if ($patch['improper_error_handling'] == "Not Found") echo "selected"; ?>>Not Found</option>
           </select></td>
            </tr>
			<tr>
                <td>Testing for Reverse Tabnabbing:</td>
                <td><select name="reverse_tabnabbing">
        <option value="NA" <?php if ($patch['reverse_tabnabbing'] == "NA") echo "selected"; ?>>NA</option>
        <option value="Found" <?php if ($patch['reverse_tabnabbing'] == "Found") echo "selected"; ?>>Found</option>
        <option value="Not Found" <?php if ($patch['reverse_tabnabbing'] == "Not Found") echo "selected"; ?>>Not Found</option>
           </select></td>
            </tr>
			<tr>
                <td>Weak Access Control:</td>
               <td><select name="weak_access_control">
        <option value="NA" <?php if ($patch['weak_access_control'] == "NA") echo "selected"; ?>>NA</option>
        <option value="Found" <?php if ($patch['weak_access_control'] == "Found") echo "selected"; ?>>Found</option>
        <option value="Not Found" <?php if ($patch['weak_access_control'] == "Not Found") echo "selected"; ?>>Not Found</option>
           </select></td>
            </tr>
			<tr>
                <td>Weak Random Number/Weak Random Generator:</td>
                <td><select name="weak_random_number">
        <option value="NA" <?php if ($patch['weak_random_number'] == "NA") echo "selected"; ?>>NA</option>
        <option value="Found" <?php if ($patch['weak_random_number'] == "Found") echo "selected"; ?>>Found</option>
        <option value="Not Found" <?php if ($patch['weak_random_number'] == "Not Found") echo "selected"; ?>>Not Found</option>
           </select></td>
            </tr>
			<tr>
                <td>Sessionless JS:</td>
                <td><select name="sessionless_js">
        <option value="NA" <?php if ($patch['sessionless_js'] == "NA") echo "selected"; ?>>NA</option>
        <option value="Found" <?php if ($patch['sessionless_js'] == "Found") echo "selected"; ?>>Found</option>
        <option value="Not Found" <?php if ($patch['sessionless_js'] == "Not Found") echo "selected"; ?>>Not Found</option>
           </select></td>
            </tr>
			<tr>
                <td>Removal of jcryption files:</td>
               <td><select name="removal_jcryption_files">
        <option value="NA" <?php if ($patch['removal_jcryption_files'] == "NA") echo "selected"; ?>>NA</option>
        <option value="Found" <?php if ($patch['removal_jcryption_files'] == "Found") echo "selected"; ?>>Found</option>
        <option value="Not Found" <?php if ($patch['removal_jcryption_files'] == "Not Found") echo "selected"; ?>>Not Found</option>
           </select></td>
            </tr>
			
			<tr>
                <td>Log Injection:</td>
               <td><select name="log_injection">
        <option value="NA" <?php if ($patch['log_injection'] == "NA") echo "selected"; ?>>NA</option>
        <option value="Found" <?php if ($patch['log_injection'] == "Found") echo "selected"; ?>>Found</option>
        <option value="Not Found" <?php if ($patch['log_injection'] == "Not Found") echo "selected"; ?>>Not Found</option>
           </select></td>
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

 <td>
 Mentor review status:
</td>
<td>
    <select name="status_mentor">
        <option value="" <?php if ($patch['status_mentor'] == "") echo "selected"; ?>></option>
        <option value="Passed" <?php if ($patch['status_mentor'] == "Passed") echo "selected"; ?>>Passed</option>
        <option value="Passed with Exception" <?php if ($patch['status_mentor'] == "Passed with Exception") echo "selected"; ?>>Passed with Exception</option>
        <option value="Failed" <?php if ($patch['status_mentor'] == "Failed") echo "selected"; ?>>Failed</option>
    </select>
	<br>
	<i>Reviewed by:<?php echo $patch['mentor_username']; ?></i>
	
	
	
	
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
                <td>eManager IR:</td>
                <td><?php echo $patch['emanager_ir']; ?></td>
            </tr>
            <tr>
                
				 <a href="mentorreview.php?assignment_id=<?php echo $patch['assignment_id']; ?>" class="assignment-link">Patch details</a>
            </tr>
			<tr>

 <td>
 Lead approval status:
</td>
<td>
    <select name="status_lead">
        <option value="" <?php if ($patch['status_lead'] == "") echo "selected"; ?>></option>
        <option value="Approved" <?php if ($patch['status_lead'] == "Approved") echo "selected"; ?>>Approved</option>
        <option value="Approved with Exception" <?php if ($patch['status_lead'] == "Approved with Exception") echo "selected"; ?>>Approved with Exception</option>
        <option value="Rejected" <?php if ($patch['status_lead'] == "Rejected") echo "selected"; ?>>Rejected</option>
    </select>
	<br>
	<i>Approved by:<?php echo $patch['lead_username']; ?></i>
	
	
	
	
</td>



</tr>

			
			
			<tr>
                <td>Feedback:</td>
                <td><textarea name="lead_feedback" rows="4" cols="50"><?php echo $patch['lead_feedback']; ?></textarea></td>
            </tr>
			<script>
        ClassicEditor
            .create(document.querySelector('#lead_feedback'))
            .then(lead_feedback => {
                console.log(lead_feedback);
            })
            .catch(error => {
                console.error(error);
            });
    </script>
	

        </tbody>
    </table>
    <input type="hidden" name="assignment_id" value="<?php echo $assignment_id; ?>">
</div>



        </tbody>
    </table>
    <input type="hidden" name="assignment_id" value="<?php echo $assignment_id; ?>">
</div>













            <!-- Save button -->
            <button type="submit" class="btn btn-primary" name="update_patch">Save</button>
        </form>
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
	<!-- Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
