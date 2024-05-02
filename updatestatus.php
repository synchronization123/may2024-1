<?php
// Include database connection file
include_once "db_connect.php";

// Handle POST request to update assignment status
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get POST data
    $assignmentId = $_POST['assignment_id'];
    $newStatus = $_POST['status'];
    
    // Prepare and execute SQL statement to update status
    $sql = "UPDATE patches SET status = ? WHERE assignment_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $newStatus, $assignmentId);
    if ($stmt->execute()) {
        // Status updated successfully
        echo "Status updated successfully!";
    } else {
        // Error updating status
        echo "Error updating status: " . $conn->error;
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
}
?>
