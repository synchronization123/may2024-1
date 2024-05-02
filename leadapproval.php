


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

   <div class="container mt-3" id="jiralist">
      <h2></h2>
    <a href="view_assignments.php" class="btn btn-secondary">Back</a>

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
        $sql_findings5 = "SELECT Column_30, Column_31, Column_32, Column_33, Column_34, Column_35, Column_36, Column_37, Column_38, Column_39, Column_40, Column_41, Column_42, Column_43, Column_44, Column_45, Column_46, Column_47, Column_48, Column_49, Column_50, Column_51, Column_52, Column_53, Column_54, Column_55, Column_56, Column_57, Column_58, Column_59 FROM patches WHERE delete_flag='0' AND assignment_id = $assignment_id";
        $result_title5 = $conn->query($sql_findings5);

// Display title and comments in tabular format
if ($result_title5->num_rows > 0) {
	echo "<br>";
    echo "<h6><u>Risk Register</u></h6>";
    echo "<table>";
    while ($row_report = $result_title5->fetch_assoc()) {
        echo "<tr>";
        echo "<td>Column_30</td>";
        echo "<td>" . $row_report["Column_30"] . "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Column_31</td>";
        echo "<td>" . $row_report["Column_31"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>Column_32</td>";
        echo "<td>" . $row_report["Column_32"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>Column_33</td>";
        echo "<td>" . $row_report["Column_33"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>Column_34</td>";
        echo "<td>" . $row_report["Column_34"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>Column_35</td>";
        echo "<td>" . $row_report["Column_35"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>Column_36</td>";
        echo "<td>" . $row_report["Column_36"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>Column_37</td>";
        echo "<td>" . $row_report["Column_37"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>Column_38</td>";
        echo "<td>" . $row_report["Column_38"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>Column_39</td>";
        echo "<td>" . $row_report["Column_39"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>Column_40</td>";
        echo "<td>" . $row_report["Column_40"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>Column_41</td>";
        echo "<td>" . $row_report["Column_41"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>Column_42</td>";
        echo "<td>" . $row_report["Column_42"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>Column_43</td>";
        echo "<td>" . $row_report["Column_43"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>Column_44</td>";
        echo "<td>" . $row_report["Column_44"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>Column_45</td>";
        echo "<td>" . $row_report["Column_45"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>Column_46</td>";
        echo "<td>" . $row_report["Column_46"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>Column_47</td>";
        echo "<td>" . $row_report["Column_47"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>Column_48</td>";
        echo "<td>" . $row_report["Column_48"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>Column_49</td>";
        echo "<td>" . $row_report["Column_49"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>Column_50</td>";
        echo "<td>" . $row_report["Column_50"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>Column_51</td>";
        echo "<td>" . $row_report["Column_51"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>Column_52</td>";
        echo "<td>" . $row_report["Column_52"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>Column_53</td>";
        echo "<td>" . $row_report["Column_53"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>Column_54</td>";
        echo "<td>" . $row_report["Column_54"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>Column_55</td>";
        echo "<td>" . $row_report["Column_55"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>Column_56</td>";
        echo "<td>" . $row_report["Column_56"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>Column_57</td>";
        echo "<td>" . $row_report["Column_57"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>Column_58</td>";
        echo "<td>" . $row_report["Column_58"] . "</td>";
        echo "</tr>";
		
        echo "<tr>";
        echo "<td>Column_59</td>";
        echo "<td>" . $row_report["Column_59"] . "</td>";
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
        $sql_findings4 = "SELECT title, total_no_of_jiras, no_of_jiras_tested ,total_time_taken, changelog_reviewers FROM patches WHERE delete_flag='0' AND assignment_id = $assignment_id";
        $result_title4 = $conn->query($sql_findings4);

// Display title and comments in tabular format
        if ($result_title4->num_rows > 0) {
            echo "<h6><u>Analysis</u></h6>";
            echo "<table>";
            echo "<tr><th>Total No. of Jiras</th><th>No. of Jiras tested</th><th>Changelog reviewers</th><th>Total Time Taken</th></tr>";
            while ($row_report = $result_title4->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row_report["total_no_of_jiras"] . "</td>";
                echo "<td>" . $row_report["no_of_jiras_tested"] . "</td>";
				echo "<td>" . $row_report["changelog_reviewers"] . "</td>";
				echo "<td>" . $row_report["total_time_taken"] . "</td>";
				echo "</tr>";
            }

            echo "</table>";
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
            echo "<p>No reports found for the specified assignment ID</p>";
        }
    } else {
        echo "<p>No assignment ID specified</p>";
    }

    // Close database connection
    $conn->close();
    ?>
</div>

		         
</body>
</html>
