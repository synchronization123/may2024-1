<?php
// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the status mentor and assignment ID from the POST data
    if(isset($_POST['status_mentor']) && isset($_POST['assignment_id'])) {
        $status_mentor = $_POST['status_mentor'];
        $assignment_id = $_POST['assignment_id'];

        // Assuming you have a MySQL connection established
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "myappsec";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and execute the SQL update statement
        $sql = "UPDATE patches SET status_mentor = '$status_mentor' WHERE assignment_id = $assignment_id";

        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }

        $conn->close();
    } else {
        echo "status_mentor or assignment_id not set in POST data.";
    }
} else {
    echo "This script expects a POST request.";
}
?>
