


<!DOCTYPE html>
<html>
<head>
    <title>Mentor Review</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            border: 1px solid #ccc;
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
            background-color: #f9f9f9;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
    </style>
	
		  <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #jiralist, #jiralist * {
                visibility: visible;
            }
            #jiralist {
                position: center;
                left: 100;
                top: 100;
            }
            table {
                width: 80%;
                border-collapse: collapse;
            }
            th, td {
                border: 4px solid #ddd;
                padding: 8px;
                text-align: left;
            }
            img {
                width: 200px;
                height: 200px;
            }
        }
    </style>
	
	<style>
    /* CSS for the top bar */
    .top-bar {
        background-color: skyblue;
        padding: 10px 20px; /* Adjust padding as needed */
        color: white;
        text-align: right; /* Align text to the right */
    }

    /* CSS for dropdown menu */
    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 160px;
        z-index: 1;
        right: 0; /* Align dropdown to the right */
    }

    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {
        background-color: #f1f1f1;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }
</style>


</head>
<body>

<?php
session_start();

// Include your database connection file
include_once "db_connect.php";

// Exception and error handling
try {
    // Query to fetch user's role
    $user_id = $_SESSION['user_id'];
    $query = "SELECT role_id FROM users WHERE user_id = :user_id AND delete_flag = 0";
    $stmt = $db->prepare($query);
    $stmt->execute(['user_id' => $user_id]);
    $user = $stmt->fetch();

    // Check if the user has access to the file
    $query_access = "SELECT * FROM file_access WHERE role_id = :role_id AND delete_flag = 0";
    $stmt_access = $db->prepare($query_access);
    $stmt_access->execute(['role_id' => $user['role_id']]);
    $access_files = $stmt_access->fetchAll();

    if (!$access_files) {
        throw new Exception("You don't have access to any files.");
    }

    // Fetch data for the dashboard
    $today = date('Y-m-d');
    $tomorrow = date('Y-m-d', strtotime('+1 day'));

    // Query to fetch data from patches table for today's ETA
    $query_today = "SELECT p.*, u.ufname, u.ulname FROM patches p
                    LEFT JOIN users u ON p.assigned_to = u.user_id
                    WHERE p.assigned_to = :user_id AND p.eta = :today AND p.delete_flag = 0";
    $stmt_today = $db->prepare($query_today);
    $stmt_today->execute(['user_id' => $user_id, 'today' => $today]);
    $patches_today = $stmt_today->fetchAll();

    // Query to fetch data from patches table for tomorrow's ETA
    $query_tomorrow = "SELECT p.*, u.ufname, u.ulname FROM patches p
                       LEFT JOIN users u ON p.assigned_to = u.user_id
                       WHERE p.assigned_to = :user_id AND p.eta = :tomorrow AND p.delete_flag = 0";
    $stmt_tomorrow = $db->prepare($query_tomorrow);
    $stmt_tomorrow->execute(['user_id' => $user_id, 'tomorrow' => $tomorrow]);
    $patches_tomorrow = $stmt_tomorrow->fetchAll();

    // Query to fetch data from patches table where ETA is not set
    $query_not_set = "SELECT p.*, u.ufname, u.ulname FROM patches p
                      LEFT JOIN users u ON p.assigned_to = u.user_id
                      WHERE p.assigned_to = :user_id AND p.eta IS NULL AND p.delete_flag = 0";
    $stmt_not_set = $db->prepare($query_not_set);
    $stmt_not_set->execute(['user_id' => $user_id]);
    $patches_not_set = $stmt_not_set->fetchAll();
} catch (Exception $e) {
    // Display error message
    $error_message = $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
   <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa; /* Light gray background */
        }

        .top-bar {
            background-color: #173E58; /* Sky blue color */
            height: 50px;
            padding: 10px 20px;
            color: white;
        }

        .left-menu {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100%;
            background-color: ; /* Dark gray color */
            padding-top: 50px; /* Space for top bar */
        }

        .menu-item {
            margin-bottom: 10px;
        }

        .main-content {
            margin-left: 250px; /* Same width as left menu */
            padding: 20px;
        }

        .card {
            margin-bottom: 20px;
        }
		
		.btn-3d {
    display: block;
    width: 100%;
    border: none;
    background: linear-gradient(145deg, #87CEEB, #87CEEB); /* Sky blue gradient */
    color: white;
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 8px;
    box-shadow: 3px 3px 7px rgba(0, 0, 0, 0.3), 
                -3px -3px 7px rgba(255, 255, 255, 0.6);
    transition: all 0.2s;
    text-align: left; /* Align text to the left */
}

.btn-3d:hover {
    background: linear-gradient(145deg, #9acfea, #9acfea); /* Lighter sky blue gradient */
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3), 
                -2px -2px 5px rgba(255, 255, 255, 0.6);
    transform: translate(1px, 1px);
}

		
    </style> 
	
	
	
</head>
<body>
    <!-- Top bar -->
    <div class="top-bar" align="left">
        <p align="left">Print Report</p>
    </div>
	<!-- Left Menu -->
<div class="left-menu">
    <ul class="list-group">
        <?php
        // Exception and error handling
        try {
            // Query to fetch display names for left menu
           
    $query_menu = "SELECT * FROM file_access WHERE role_id = 5 AND delete_flag = 0 AND in_menu = 0 ORDER BY order_by ASC";
            $stmt_menu = $db->query($query_menu);
            $access_files = $stmt_menu->fetchAll();

            // Check if any display names are available
            if (!$access_files) {
                throw new Exception("No files available");
            }

            // Render display names as menu items
            foreach ($access_files as $file) {
                echo '<li class="list-group-item menu-item">';
                echo '<a href="' . $file['file_name'] . '" class="btn btn-primary btn-3d menu-link">' . $file['display_name'] . '</a>';
                echo '</li>';
            }
        } catch (Exception $e) {
            // Display error message
            echo '<li class="list-group-item">' . $e->getMessage() . '</li>';
        }
        ?>
    </ul>
</div>


    <!-- Main Content -->
    <div class="main-content">
       
	  <form id="backForm" action="addpatchdetails.php" method="post">
    <!-- Hidden input to pass assignment_id -->
    <input type="hidden" name="assignment_id" id="assignment_id" value="">
    <button type="submit">Back</button>
</form>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Function to extract parameter value from URL
        function getParameterByName(name, url) {
            if (!url) url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }

        // Get assignment_id from URL
        var assignmentId = getParameterByName('assignment_id');
        // Set assignment_id value to the hidden input field
        document.getElementById('assignment_id').value = assignmentId;

        // Submit form when the button is clicked
        document.querySelector('button[type="submit"]').addEventListener('click', function() {
            document.getElementById('backForm').submit();
        });
    });
</script>

   <div class="container mt-3" id="jiralist">
      <h2></h2>

    <?php
    // Connect to the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "myappsec";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get assignment_id from URL parameter
    if (isset($_GET['assignment_id'])) {
        $assignment_id = $_GET['assignment_id'];

        // Retrieve title for the specified assignment_id
        $sql_title = "SELECT title, eta FROM patches WHERE delete_flag='0' AND assignment_id = $assignment_id";
        $result_title = $conn->query($sql_title);

        // Display title at the top
        if ($result_title->num_rows > 0) {
            $row_title = $result_title->fetch_assoc();
            echo "<h3>Name: " . $row_title["title"] . "</h3>";
			echo "<h3>Date: " . $row_title["eta"] . "</h3>";
        } else {
            echo "<p>No patch found for the specified ID</p>";
        }




 // Retrieve findings for the specified assignment_id
        $sql_findings5 = "SELECT sql_injection, xss, path_traversal, command_injection, xxe, readline, header_injection, insecure_deserial, session_test, out_of_band, sensitive_info_querystring, vul_crypto_algo, sensitive_info_logs, tbv, sensitive_info_response, hardcoded_cred, csv_injection, unrestricted_fileupload, unnecessary_file_distribution, ssrf, vul_components, root_detection, improper_error_handling, reverse_tabnabbing, weak_access_control, weak_random_number, sessionless_js, removal_jcryption_files, log_injection FROM patches WHERE delete_flag='0' AND assignment_id = $assignment_id";
        $result_title5 = $conn->query($sql_findings5);

// Display title and comments in tabular format
if ($result_title5->num_rows > 0) {
	echo "<br>";
    echo "<h6><u>Risk Register</u></h6>";
    echo "<table>";
    while ($row_report = $result_title5->fetch_assoc()) {
        echo "<tr>";
        echo "<td>sql_injection</td>";
        echo "<td>" . $row_report["sql_injection"] . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>xss</td>";
        echo "<td>" . $row_report["xss"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>path_traversal</td>";
        echo "<td>" . $row_report["path_traversal"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>command_injection</td>";
        echo "<td>" . $row_report["command_injection"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>xxe</td>";
        echo "<td>" . $row_report["xxe"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>readline</td>";
        echo "<td>" . $row_report["readline"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>header_injection</td>";
        echo "<td>" . $row_report["header_injection"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>insecure_deserial</td>";
        echo "<td>" . $row_report["insecure_deserial"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>session_test</td>";
        echo "<td>" . $row_report["session_test"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>out_of_band</td>";
        echo "<td>" . $row_report["out_of_band"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>sensitive_info_querystring</td>";
        echo "<td>" . $row_report["sensitive_info_querystring"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>vul_crypto_algo</td>";
        echo "<td>" . $row_report["vul_crypto_algo"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>sensitive_info_logs</td>";
        echo "<td>" . $row_report["sensitive_info_logs"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>tbv</td>";
        echo "<td>" . $row_report["tbv"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>sensitive_info_response</td>";
        echo "<td>" . $row_report["sensitive_info_response"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>hardcoded_cred</td>";
        echo "<td>" . $row_report["hardcoded_cred"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>csv_injection</td>";
        echo "<td>" . $row_report["csv_injection"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>unrestricted_fileupload</td>";
        echo "<td>" . $row_report["unrestricted_fileupload"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>unnecessary_file_distribution</td>";
        echo "<td>" . $row_report["unnecessary_file_distribution"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>ssrf</td>";
        echo "<td>" . $row_report["ssrf"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>vul_components</td>";
        echo "<td>" . $row_report["vul_components"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>root_detection</td>";
        echo "<td>" . $row_report["root_detection"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>improper_error_handling</td>";
        echo "<td>" . $row_report["improper_error_handling"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>reverse_tabnabbing</td>";
        echo "<td>" . $row_report["reverse_tabnabbing"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>weak_access_control</td>";
        echo "<td>" . $row_report["weak_access_control"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>weak_random_number</td>";
        echo "<td>" . $row_report["weak_random_number"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>sessionless_js</td>";
        echo "<td>" . $row_report["sessionless_js"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>removal_jcryption_files</td>";
        echo "<td>" . $row_report["removal_jcryption_files"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>log_injection</td>";
        echo "<td>" . $row_report["log_injection"] . "</td>";
        echo "</tr>";
		
        
    }
    echo "</table>";
}











        // Retrieve findings for the specified assignment_id
        $sql_findings = "SELECT title, epic_count, story_count, bug_count,tech_imp_count FROM patches WHERE delete_flag='0' AND assignment_id = $assignment_id";
        $result_title = $conn->query($sql_findings);



// Display title and comments in tabular format
        if ($result_title->num_rows > 0) {
			echo "<br>";
            echo "<h6><u>Total Changelogs</u></h6>";
            echo "<table>";
            echo "<tr><th>Number of Epic(s)</th><th>Number of Storie(s)</th><th>Number of Bug(s)</th><th>Number of Technical Improvement(s)</th></tr>";
            while ($row_report = $result_title->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row_report["epic_count"] . "</td>";
                echo "<td>" . $row_report["story_count"] . "</td>";
				echo "<td>" . $row_report["bug_count"] . "</td>";
				echo "<td>" . $row_report["tech_imp_count"] . "</td>";
				echo "</tr>";
            }

            echo "</table>";
		}


// Retrieve findings for the specified assignment_id
$sql_findings4 = "SELECT title, total_no_of_jiras, no_of_jiras_tested, total_time_taken, changelog_reviewers FROM patches WHERE delete_flag='0' AND assignment_id = $assignment_id";
$result_title4 = $conn->query($sql_findings4);

// Display title and comments in tabular format
if ($result_title4->num_rows > 0) {
    echo "<h6><u>Analysis</u></h6>";
    echo "<table>";
    echo "<tr><th>Total No. of Jiras</th><th>No. of Jiras tested</th><th>Changelog reviewers</th><th>Total Time Taken</th></tr>";
    
    // Loop through the results and display each row
    while ($row_report = $result_title4->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row_report["total_no_of_jiras"] . "</td>";
        echo "<td>" . $row_report["no_of_jiras_tested"] . "</td>";
        echo "<td>" . $row_report["changelog_reviewers"] . "</td>";
        echo "<td>" . $row_report["total_time_taken"] . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No results found.";
}








        // Retrieve findings for the specified assignment_id
        $sql_findings1 = "SELECT qa_servers, contrast_server_name FROM patches WHERE delete_flag='0' AND assignment_id = $assignment_id";
        $result_title1 = $conn->query($sql_findings1);



// Display title and comments in tabular format
        if ($result_title1->num_rows > 0) {
            echo "<h6><u>Contrast Verification:</u></h6>";
            echo "<table>";
            echo "<tr><th>QA Servers</th><th>Contrast Server Name</th></tr>";
            while ($row_report = $result_title1->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row_report["qa_servers"] . "</td>";
                echo "<td>" . $row_report["contrast_server_name"] . "</td>";
				
				echo "</tr>";
            }

            echo "</table>";
		}



        // Retrieve findings for the specified assignment_id
        $sql_findings2 = "SELECT qa_env_url FROM patches WHERE delete_flag='0' AND assignment_id = $assignment_id";
        $result_title2 = $conn->query($sql_findings2);



// Display title and comments in tabular format
        if ($result_title2->num_rows > 0) {
            echo "<h6><u>Environmental Setup requirement</u></h6>";
            echo "<table>";
            echo "<tr><th>QA Env for Security Control tests and Contrast Verification </th></tr>";
            while ($row_report = $result_title2->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row_report["qa_env_url"] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
		}



        // Retrieve findings for the specified assignment_id
        $sql_findings3 = "SELECT conclusion,secure_code_review,sonar_verified,contrast_verified, third_party_verified, security_validation_status, comments FROM patches WHERE delete_flag='0' AND assignment_id = $assignment_id";
        $result_title3 = $conn->query($sql_findings3);



// Display title and comments in tabular format
        if ($result_title3->num_rows > 0) {
            echo "<h6><u>Conclusion</u></h6>";
            echo "<table>";
            echo "<tr><th>Conclusion</th><th>Secure Code Review</th><th>Sonar Verified</th><th>Contrast Verified</th><th>Third Party JAR/JS</th><th>Security Validation Status</th><th>Comments</th></tr>";
            while ($row_report = $result_title3->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row_report["conclusion"] . "</td>";
				echo "<td>" . $row_report["secure_code_review"] . "</td>";
				echo "<td>" . $row_report["sonar_verified"] . "</td>";
				echo "<td>" . $row_report["contrast_verified"] . "</td>";
				echo "<td>" . $row_report["third_party_verified"] . "</td>";
				echo "<td>" . $row_report["security_validation_status"] . "</td>";
				echo "<td>" . $row_report["comments"] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
		}









        // Retrieve title and comments for the specified assignment_id
        $sql_reports = "SELECT jira_id, category, jira_type, SonarQube, Contrast, Dep_Check, Manual_Secure_Code_Review, Manual_Security_Testing, Remark 
                FROM analysis 
                WHERE delete_flag='0' AND assignment_id = $assignment_id";



        $result_reports = $conn->query($sql_reports);

        // Display title and comments in tabular format
        if ($result_reports->num_rows > 0) {
            echo "<h3>Details</h3>";
            echo "<table>";
            echo "<tr><th>Jira ID</th><th>Category</th><th>Jira Type</th><th>SonarQube</th><th>Contrast</th><th>Dep. Check</th><th>Code Review</th><th>Manual Testing</th></th><th>Remark</th></tr>";
            while ($row_report = $result_reports->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row_report["jira_id"] . "</td>";
                echo "<td>" . $row_report["category"] . "</td>";
				echo "<td>" . $row_report["jira_type"] . "</td>";
				echo "<td>" . $row_report["SonarQube"] . "</td>";
				echo "<td>" . $row_report["Contrast"] . "</td>";
				echo "<td>" . $row_report["Dep_Check"] . "</td>";
				echo "<td>" . $row_report["Manual_Secure_Code_Review"] . "</td>";
				echo "<td>" . $row_report["Manual_Security_Testing"] . "</td>";
				echo "<td>" . $row_report["Remark"] . "</td>";
				echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No jira id found for the specified patch </p>";
        }
    } else {
        echo "<p>No jira ID specified</p>";
    }

    // Close database connection
    $conn->close();
    ?>
</div>

		            <button onclick="window.print()" class="btn btn-secondary">Print Preview</button>
		         
 
	   
	   
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function submitForm(assignment_id) {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = 'addpatchdetails.php';
            
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'assignment_id';
            input.value = assignment_id;
            form.appendChild(input);

            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>
</html>
