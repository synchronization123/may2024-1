<?php
// Include database connection
require_once "db_connect.php";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Validate assignment_id
        if (!isset($_POST['assignment_id'])) {
            throw new Exception("Assignment ID is not provided.");
        }

        // Fetch assignment_id from form
        $assignment_id = $_POST['assignment_id'];

        // Fetch other form values
        $manual_testing = $_POST['manual_testing'];
        $code_review = $_POST['code_review'];
        $notes = $_POST['notes'];
        $time_taken = $_POST['time_taken'];

        // Update values in vapt table
        $query_update = "UPDATE vapt SET manual_testing_Test_Case_1 = :manual_testing, code_review_Test_Case_1 = :code_review, notes_Test_Case_1 = :notes, timetaken_Test_Case_1 = :time_taken WHERE assignment_id = :assignment_id";
        $stmt_update = $db->prepare($query_update);
        $stmt_update->bindParam(':manual_testing', $manual_testing);
        $stmt_update->bindParam(':code_review', $code_review);
        $stmt_update->bindParam(':notes', $notes);
        $stmt_update->bindParam(':time_taken', $time_taken);
        $stmt_update->bindParam(':assignment_id', $assignment_id);
        $stmt_update->execute();

        // Redirect back to vapt.php with success message
        header("Location: vapt.php?success=1");
        exit();
    } catch (Exception $e) {
        // Redirect back to vapt.php with error message
        header("Location: vapt.php?error=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    // Redirect back to vapt.php if form is not submitted
    header("Location: vapt.php");
    exit();
}
?>
