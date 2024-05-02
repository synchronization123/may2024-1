<?php
// Include database connection
require_once "db_connect.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch assignment_id from the form
    $assignment_id = $_POST['assignment_id'];

    // Validate if assignment_id exists in patches table
    $query_assignment = "SELECT * FROM patches WHERE assignment_id = :assignment_id";
    $stmt_assignment = $db->prepare($query_assignment);
    $stmt_assignment->bindParam(':assignment_id', $assignment_id);
    $stmt_assignment->execute();
    $assignment_exists = $stmt_assignment->fetch(PDO::FETCH_ASSOC);
    if (!$assignment_exists) {
        echo "Assignment not found in patches table.";
        exit();
    }

    // Update or insert data into the patches table based on assignment_id
    // Adjust column names in the SQL queries according to your patches table schema

    // Total Changelogs
    $epic_count = $_POST['epic_count'];
    $story_count = $_POST['story_count'];
    $bug_count = $_POST['bug_count'];
    $tech_imp_count = $_POST['tech_imp_count'];
    $total_changelogs_query = "UPDATE patches SET epic_count = :epic_count, story_count = :story_count, bug_count = :bug_count, tech_imp_count = :tech_imp_count WHERE assignment_id = :assignment_id";
    $stmt_total_changelogs = $db->prepare($total_changelogs_query);
    $stmt_total_changelogs->bindParam(':epic_count', $epic_count);
    $stmt_total_changelogs->bindParam(':story_count', $story_count);
    $stmt_total_changelogs->bindParam(':bug_count', $bug_count);
    $stmt_total_changelogs->bindParam(':tech_imp_count', $tech_imp_count);
    $stmt_total_changelogs->bindParam(':assignment_id', $assignment_id);
    $stmt_total_changelogs->execute();

    // Contrast Verification
    $qa_servers = $_POST['qa_servers'];
    $contrast_server_name = $_POST['contrast_server_name'];
    $contrast_verification_query = "UPDATE patches SET qa_servers = :qa_servers, contrast_server_name = :contrast_server_name WHERE assignment_id = :assignment_id";
    $stmt_contrast_verification = $db->prepare($contrast_verification_query);
    $stmt_contrast_verification->bindParam(':qa_servers', $qa_servers);
    $stmt_contrast_verification->bindParam(':contrast_server_name', $contrast_server_name);
    $stmt_contrast_verification->bindParam(':assignment_id', $assignment_id);
    $stmt_contrast_verification->execute();

    // Env Setup Req.
    $qa_env_url = $_POST['qa_env_url'];
    $env_setup_req_query = "UPDATE patches SET qa_env_url = :qa_env_url WHERE assignment_id = :assignment_id";
    $stmt_env_setup_req = $db->prepare($env_setup_req_query);
    $stmt_env_setup_req->bindParam(':qa_env_url', $qa_env_url);
    $stmt_env_setup_req->bindParam(':assignment_id', $assignment_id);
    $stmt_env_setup_req->execute();

    // Conclusion
    $conclusion = $_POST['conclusion'];
    $conclusion_query = "UPDATE patches SET conclusion = :conclusion WHERE assignment_id = :assignment_id";
    $stmt_conclusion = $db->prepare($conclusion_query);
    $stmt_conclusion->bindParam(':conclusion', $conclusion);
    $stmt_conclusion->bindParam(':assignment_id', $assignment_id);
    $stmt_conclusion->execute();

    // Redirect to a success page or back to the form page
    header("Location: success.php");
    exit();
} else {
    // Redirect to an error page if accessed without form submission
    header("Location: error.php");
    exit();
}
?>
