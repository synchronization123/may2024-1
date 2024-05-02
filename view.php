<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patches</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
       
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Assignment ID</th>
                        <th>Title</th>
                        <th>Certification Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Include the database connection file
                    require_once 'db_connect.php';

                    // Fetch data from patches table
                    $query = "SELECT * FROM patches";
                    $stmt = $db->query($query);
                    $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Loop through the fetched data and display in table
                    foreach ($assignments as $assignment) {
                        echo "<tr>";
                        echo "<td>{$assignment['assignment_id']}</td>";
                        echo "<td>{$assignment['title']}</td>";
                        echo "<td>";
                        echo "<select class='form-control status-dropdown' data-id='{$assignment['assignment_id']}'>";
                        echo "<option value='Not Started' " . ($assignment['certification_status'] == 'Not Started' ? 'selected' : '') . ">Not Started</option>";
                        echo "<option value='InProgress' " . ($assignment['certification_status'] == 'InProgress' ? 'selected' : '') . ">InProgress</option>";
                        echo "<option value='Completed' " . ($assignment['certification_status'] == 'Completed' ? 'selected' : '') . ">Completed</option>";
                        echo "</select>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function(){
            // When status dropdown value changes
            $('.status-dropdown').change(function(){
                var assignmentId = $(this).data('id');
                var status = $(this).val();

                // AJAX request to update status in database
                $.ajax({
                    url: 'update_status.php',
                    method: 'POST',
                    data: {assignment_id: assignmentId, certification_status: status},
                    success: function(response){
                        // Show success message or perform any other action
                        console.log(response);
                    }
                });
            });
        });
    </script>
</body>
</html>
