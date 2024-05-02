<?php
// Include database connection
require_once 'db_connect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_notes'])) {
    // Escape user inputs for security
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $notes = mysqli_real_escape_string($conn, $_POST['notes']);

    // Insert notes into database
    $sql = "INSERT INTO meeting_notes (title, notes) VALUES ('$title', '$notes')";
    if (mysqli_query($conn, $sql)) {
        echo "Notes saved successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close connection
    mysqli_close($conn);
}
?>
