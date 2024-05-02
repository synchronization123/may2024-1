<?php
// Include the database connection file
require_once 'db_connect.php';

// Check if assignment_id and review_status are set
if(isset($_POST['assignment_id']) && isset($_POST['review_status'])){
    $assignmentId = $_POST['assignment_id'];
    $status = $_POST['review_status'];


    // Update review_status in patches table
  $query = "UPDATE patches SET review_status = :review_status, status = 'Lead Approval Pending' WHERE assignment_id = :assignment_id";

    $stmt = $db->prepare($query);
    $stmt->bindParam(':review_status', $status);
	$stmt->bindParam(':assignment_id', $assignmentId);
	

    if($stmt->execute()){
        echo "Review status updated successfully.";
    }else{
        echo "Error updating Review status.";
    }
}else{
    echo "Assignment ID or Review status not provided.";
}
?>
