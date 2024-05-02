<?php
// Include database connection
require_once "db_connect.php";

// Exception and error handling
try {
    session_start();

    

    // Generate a unique session ID for the user
    $session_id = session_id();

    // Check file access for the logged-in user
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM file_access WHERE role_id IN (SELECT role_id FROM users WHERE user_id = :user_id) AND in_menu = 'yes' AND delete_flag = 0";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $file_access = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!$file_access) {
        throw new Exception("You don't have access to any menu items.");
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
    <title>Left Menu</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <?php if (isset($error_message)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php else : ?>
                <div class="list-group">
            <?php foreach ($file_access as $access) : ?>
                <a href="<?php echo $access['file_name']; ?>" class="list-group-item list-group-item-action"><?php echo $access['display_name']; ?></a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
