<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meeting Notes Tracker</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/ckeditor5/33.0.0/classic/ckeditor.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h2 class="text-center mb-4">Meeting Notes Tracker</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="notes">Notes:</label>
                        <textarea class="form-control" id="notes" name="notes" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" name="save_notes">Save Notes</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        ClassicEditor
            .create(document.querySelector('#notes'))
            .catch(error => {
                console.error(error);
            });
    </script>

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
        echo "<script>alert('Notes saved successfully');</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }

    // Close connection
    mysqli_close($conn);
}
?>

</body>
</html>
