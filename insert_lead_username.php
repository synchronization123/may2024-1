<?php
// insert_lead_username.php

// Include the file that establishes the database connection
include 'db_connect.php';

// Start the session
session_start();

// Check if user_id is set in the session
if(isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Retrieve data from the AJAX request
    $assignmentId = $_POST['assignment_id'];
    $status = $_POST['certification_status']; // Retrieve certification status from AJAX request

    // Perform the insertion into the database
    try {
        // Update the lead_username and certification_status in the database
        $query = "UPDATE patches SET lead_username = :user_id, certification_status = :status WHERE assignment_id = :assignment_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':assignment_id', $assignmentId);
        $stmt->execute();

        // You can return a success message if needed
        echo "Lead username and certification status updated successfully";
    } catch (PDOException $e) {
        // Handle any database errors
        echo "Error updating lead username and certification status: " . $e->getMessage();
    }
} else {
    // If user_id is not set in session, return an error
    echo "Error: User ID not found in session";
}
?>
