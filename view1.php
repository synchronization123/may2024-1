<?php
// Start session
session_start();

// Include database connection
require_once 'db_connect.php';

// Check if emanager_ir is copied
if (isset($_POST['copy_ir']) && isset($_POST['assignment_id'])) {
    // Get the current username from session
    $lead_username = $_SESSION['username'];

    // Update the lead_username column in patches table for the specific assignment_id
    $assignment_id = $_POST['assignment_id'];
    $query = "UPDATE patches SET lead_username = :lead_username WHERE emanager_ir = :emanager_ir AND assignment_id = :assignment_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(array(':lead_username' => $lead_username, ':emanager_ir' => $_POST['copy_ir'], ':assignment_id' => $assignment_id));

    // Redirect back to view.php
    header("Location: view.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2>View Page</h2>
                <?php
                // Fetch emanager_ir values and assignment_id from patches table
                $query = "SELECT emanager_ir, assignment_id FROM patches";
                $stmt = $db->query($query);

                // Display emanager_ir values and assignment_id
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<div class="input-group mb-3">';
                    echo '<input type="text" class="form-control" value="' . $row['emanager_ir'] . '" readonly>';
                    echo '<div class="input-group-append">';
                    echo '<button class="btn btn-outline-secondary copy-btn" data-clipboard-text="' . $row['emanager_ir'] . '" data-assignment-id="' . $row['assignment_id'] . '">Copy</button>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <!-- Clipboard.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.8/clipboard.min.js"></script>
    
    <script>
        // Initialize Clipboard.js
        var clipboard = new ClipboardJS('.copy-btn');

        // Show tooltip on copy
        clipboard.on('success', function(e) {
            e.trigger.setAttribute('data-original-title', 'Copied!');
            $(e.trigger).tooltip('show');

            // Update lead_username in database
            var emanager_ir = e.text;
            var assignment_id = $(e.trigger).data('assignment-id');
            $.ajax({
                url: 'view.php',
                type: 'POST',
                data: {copy_ir: emanager_ir, assignment_id: assignment_id},
                success: function(response) {
                    console.log('Lead username updated.');
                }
            });

            // Hide tooltip after a short delay
            setTimeout(function() {
                $(e.trigger).tooltip('dispose');
            }, 1000);
        });

        // Hide tooltip on error
        clipboard.on('error', function(e) {
            e.trigger.setAttribute('data-original-title', 'Failed to copy!');
            $(e.trigger).tooltip('show');

            // Hide tooltip after a short delay
            setTimeout(function() {
                $(e.trigger).tooltip('dispose');
            }, 1000);
        });
    </script>
</body>
</html>
