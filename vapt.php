<?php
// Include database connection
require_once "db_connect.php";
include_once 'leftmenu.php';

// Exception and error handling
try {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        throw new Exception("You are not logged in.");
    }

    // Check if assignment_id is set and assigned to the user
    if (!isset($_POST['assignment_id'])) {
        throw new Exception("Assignment ID is not provided.");
    }

    // Fetch user role and assigned assignment_id
    $user_id = $_SESSION['user_id'];
    $assignment_id = $_POST['assignment_id'];

    // Check if the user has access to the assignment_id
    $query_access = "SELECT * FROM assignments WHERE assignment_id = :assignment_id AND assigned_to = :user_id";
    $stmt_access = $db->prepare($query_access);
    $stmt_access->bindParam(':assignment_id', $assignment_id);
    $stmt_access->bindParam(':user_id', $user_id);
    $stmt_access->execute();
    $assignment = $stmt_access->fetch(PDO::FETCH_ASSOC);

    if (!$assignment) {
        throw new Exception("You don't have access to this assignment.");
    }

    // Fetch data for the assignment from vapt table
    $query_vapt = "SELECT * FROM vapt WHERE assignment_id = :assignment_id";
    $stmt_vapt = $db->prepare($query_vapt);
    $stmt_vapt->bindParam(':assignment_id', $assignment_id);
    $stmt_vapt->execute();
    $vapt_data = $stmt_vapt->fetch(PDO::FETCH_ASSOC);

    // Update vapt table if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    }
} catch (Exception $e) {
    $error_message = $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vulnerability Assessment and Penetration Testing (VAPT)</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <?php if (isset($error_message)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php else: ?>
        <h2>Vulnerability Assessment and Penetration Testing (VAPT)</h2>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#assignment_details">Assignment Details</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#information_gathering">Information Gathering</a>
            </li>
            <!-- Add other tabs as needed -->
        </ul>

        <div class="tab-content mt-3">
            <div id="assignment_details" class="tab-pane fade show active">
                <!-- Display assignment details here -->
            </div>
            <div id="information_gathering" class="tab-pane fade">
                <h3>Information Gathering</h3>
                <!-- Subtab 1: Information Gathering Form -->
                <div class="tab-pane fade show active">
                    <h4>Subtab 1: Information Gathering Form</h4>
                    <form method="post" action="">
                        <input type="hidden" name="assignment_id" value="<?php echo $assignment_id; ?>">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Test Case</th>
                                        <td><input type="text" class="form-control" name="test_case" value="<?php echo $vapt_data['Test_Case_1']; ?>" readonly></td>
                                    </tr>
                                    <tr>
                                        <th>Manual Testing</th>
                                        <td>
                                            <select class="form-control" name="manual_testing">
                                                <option value="Yes" <?php if ($vapt_data['manual_testing_Test_Case_1'] === "Yes") echo "selected"; ?>>Yes</option>
                                                <option value="No" <?php if ($vapt_data['manual_testing_Test_Case_1'] === "No") echo "selected"; ?>>No</option>
                                                <option value="Not Applicable" <?php if ($vapt_data['manual_testing_Test_Case_1'] === "Not Applicable") echo "selected"; ?>>Not Applicable</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Code Review</th>
                                        <td>
                                            <select class="form-control" name="code_review">
                                                <option value="Yes" <?php if ($vapt_data['code_review_Test_Case_1'] === "Yes") echo "selected"; ?>>Yes</option>
                                                <option value="No" <?php if ($vapt_data['code_review_Test_Case_1'] === "No") echo "selected"; ?>>No</option>
                                                <option value="Not Applicable" <?php if ($vapt_data['code_review_Test_Case_1'] === "Not Applicable") echo "selected"; ?>>Not Applicable</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Notes</th>
                                        <td><textarea class="form-control" name="notes" rows="3"><?php echo $vapt_data['notes_Test_Case_1']; ?></textarea></td>
                                    </tr>
                                    <tr>
                                        <th>Time taken (In minutes)</th>
                                        <td><input type="number" class="form-control" name="time_taken" value="<?php echo $vapt_data['timetaken_Test_Case_1']; ?>"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
            <!-- Add other tab content here -->
        </div>
    <?php endif; ?>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
