<?php
// Include the database connection file
require_once 'db_connect.php';

// Check if assignment_id and certification_status are set
if(isset($_POST['assignment_id']) && isset($_POST['certification_status'])){
    $assignmentId = $_POST['assignment_id'];
    $certification_status = $_POST['certification_status'];


    // Update certification_status in patches table
  $query = "UPDATE patches SET certification_status = :certification_status, status = 'Lead Approval Completed'  WHERE assignment_id = :assignment_id";

    $stmt = $db->prepare($query);
    $stmt->bindParam(':certification_status', $certification_status);
	$stmt->bindParam(':assignment_id', $assignmentId);
	

    if($stmt->execute()){
        echo "Certification status updated successfully.";
    }else{
        echo "Error updating certification status.";
    }
}else{
    echo "Assignment ID or certification status not provided.";
}
?>
