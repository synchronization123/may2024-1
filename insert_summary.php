<?php
// Include database connection
require_once "db_connect.php";

// Exception and error handling
try {
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        throw new Exception("You are not logged in.");
    }

    // Get form data
    $patches_id = $_POST['patches_id'];
    $assignment_id = $_POST['assignment_id'];
    $epic_count = $_POST['epic_count'];
    $story_count = $_POST['story_count'];
    $bug_count = $_POST['bug_count'];
    $tech_imp_count = $_POST['tech_imp_count'];
    $qa_servers = $_POST['qa_servers'];
    $contrast_server_name = $_POST['contrast_server_name'];
    $qa_env_url = $_POST['qa_env_url'];
    $conclusion = $_POST['conclusion'];
    $secure_code_review = $_POST['secure_code_review'];
    $sonar_verified = $_POST['sonar_verified'];
    $contrast_verified = $_POST['contrast_verified'];
    $third_party_verified = $_POST['third_party_verified'];
    $security_validation_status = $_POST['security_validation_status'];
    $comments = $_POST['comments'];

    // Check if patches_id and assignment_id exist in patches table
    $query_check_patches = "SELECT * FROM patches WHERE patches_id = :patches_id AND assignment_id = :assignment_id";
    $stmt_check_patches = $db->prepare($query_check_patches);
    $stmt_check_patches->bindParam(':patches_id', $patches_id);
    $stmt_check_patches->bindParam(':assignment_id', $assignment_id);
    $stmt_check_patches->execute();
    $patches = $stmt_check_patches->fetch(PDO::FETCH_ASSOC);
    if (!$patches) {
        throw new Exception("Invalid patches_id or assignment_id.");
    }

    // Insert data into summary table
    $query_insert_summary = "INSERT INTO summary (patches_id, assignment_id, epic_count, story_count, bug_count, tech_imp_count, qa_servers, contrast_server_name, qa_env_url, conclusion, secure_code_review, sonar_verified, contrast_verified, third_party_verified, security_validation_status, comments) 
    VALUES (:patches_id, :assignment_id, :epic_count, :story_count, :bug_count, :tech_imp_count, :qa_servers, :contrast_server_name, :qa_env_url, :conclusion, :secure_code_review, :sonar_verified, :contrast_verified, :third_party_verified, :security_validation_status, :comments)";
    $stmt_insert_summary = $db->prepare($query_insert_summary);
    $stmt_insert_summary->bindParam(':patches_id', $patches_id);
    $stmt_insert_summary->bindParam(':assignment_id', $assignment_id);
    $stmt_insert_summary->bindParam(':epic_count', $epic_count);
    $stmt_insert_summary->bindParam(':story_count', $story_count);
    $stmt_insert_summary->bindParam(':bug_count', $bug_count);
    $stmt_insert_summary->bindParam(':tech_imp_count', $tech_imp_count);
    $stmt_insert_summary->bindParam(':qa_servers', $qa_servers);
    $stmt_insert_summary->bindParam(':contrast_server_name', $contrast_server_name);
    $stmt_insert_summary->bindParam(':qa_env_url', $qa_env_url);
    $stmt_insert_summary->bindParam(':conclusion', $conclusion);
    $stmt_insert_summary->bindParam(':secure_code_review', $secure_code_review);
    $stmt_insert_summary->bindParam(':sonar_verified', $sonar_verified);
    $stmt_insert_summary->bindParam(':contrast_verified', $contrast_verified);
    $stmt_insert_summary->bindParam(':third_party_verified', $third_party_verified);
    $stmt_insert_summary->bindParam(':security_validation_status', $security_validation_status);
    $stmt_insert_summary->bindParam(':comments', $comments);
    $stmt_insert_summary->execute();

    // Redirect to view_assignments.php after successful insertion
    header("Location: view_assignments.php");
    exit();
} catch (Exception $e) {
    // Handle exceptions
    echo "Error: " . $e->getMessage();
}
?>
