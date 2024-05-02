<?php
// Include database connection
require_once "db_connect.php";

// Exception and error handling
try {
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        throw new Exception("You are not logged in.");
    }

    // Check file access for the logged-in user
    // Assuming $db is your database connection
    $user_id = $_SESSION['user_id'];
    $file_name = "addsummary.php"; // The current file name
    $query = "SELECT * FROM file_access WHERE role_id IN (SELECT role_id FROM users WHERE user_id = :user_id) AND file_name = :file_name AND delete_flag = 0";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':file_name', $file_name);
    $stmt->execute();
    $file_access = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$file_access) {
        echo "You don't have access to this file.";
        exit();
    }

    // Fetch assignment_id from POST request
    if (!isset($_POST['assignment_id'])) {
        throw new Exception("Assignment ID is not set.");
    }
    $assignment_id = $_POST['assignment_id'];

    // Validate if assignment_id exists in patches table
    $query_assignment = "SELECT * FROM patches WHERE assignment_id = :assignment_id";
    $stmt_assignment = $db->prepare($query_assignment);
    $stmt_assignment->bindParam(':assignment_id', $assignment_id);
    $stmt_assignment->execute();
    $assignment_exists = $stmt_assignment->fetch(PDO::FETCH_ASSOC);
    if (!$assignment_exists) {
        echo "Assignment not found in patches table.";
        exit();
    }

    // Fetch patch details based on assignment_id
    $query_patch = "SELECT * FROM patches WHERE assignment_id = :assignment_id";
    $stmt_patch = $db->prepare($query_patch);
    $stmt_patch->bindParam(':assignment_id', $assignment_id);
    $stmt_patch->execute();
    $patch = $stmt_patch->fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $error_message = $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Summary</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <?php if (isset($error_message)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php else : ?>
        <h2>Add Summary</h2>
        <!-- Tab layout -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#total_changelogs">Total Changelogs</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#contrast_verification">Contrast Verification</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#env_setup_req">Env Setup Req.</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#conclusion">Conclusion</a>
            </li>
        </ul>

        <!-- Tab content -->
        <div class="tab-content">
            <!-- Total Changelogs Tab -->
            <div id="total_changelogs" class="container tab-pane active"><br>
                <h3>Total Changelogs</h3>
                <form method="post" action="add_summary_process.php">
                    <div class="form-group">
                        <label for="epic_count">Number of Epics:</label>
                        <input type="text" class="form-control" id="epic_count" name="epic_count" value="<?php echo $patch['epic_count']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="story_count">Number of Stories:</label>
                        <input type="text" class="form-control" id="story_count" name="story_count" value="<?php echo $patch['story_count']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="bug_count">Number of Bugs:</label>
                        <input type="text" class="form-control" id="bug_count" name="bug_count" value="<?php echo $patch['bug_count']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="tech_imp_count">Number of Technical Improvements:</label>
                        <input type="text" class="form-control" id="tech_imp_count" name="tech_imp_count" value="<?php echo $patch['tech_imp_count']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>

            <!-- Contrast Verification Tab -->
            <div id="contrast_verification" class="container tab-pane fade"><br>
                <h3>Contrast Verification</h3>
                <form method="post" action="add_summary_process.php">
                    <div class="form-group">
                        <label for="qa_servers">Number of QA servers visible in Contrast:</label>
                        <input type="text" class="form-control" id="qa_servers" name="qa_servers" value="<?php echo $patch['qa_servers']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="contrast_server_name">Contrast Server Names:</label>
                        <input type="text" class="form-control" id="contrast_server_name" name="contrast_server_name" value="<?php echo $patch['contrast_server_name']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>

            <!-- Env Setup Req. Tab -->
            <div id="env_setup_req" class="container tab-pane fade"><br>
                <h3>Env Setup Req.</h3>
                <form method="post" action="add_summary_process.php">
                    <div class="form-group">
                        <label for="qa_env_url">QA Env for security controls tests and contrast verification:</label>
                        <input type="text" class="form-control" id="qa_env_url" name="qa_env_url" value="<?php echo $patch['qa_env_url']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>

            <!-- Conclusion Tab -->
            <div id="conclusion" class="container tab-pane fade"><br>
                <h3>Conclusion</h3>
                <form method="post" action="add_summary_process.php">
                    <div class="form-group">
                        <label for="conclusion">Conclusion:</label>
                        <textarea class="form-control" id="conclusion" name="conclusion" rows="4"><?php echo $patch['conclusion']; ?></textarea>
                    </div>
                    <!-- Other form elements -->
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
