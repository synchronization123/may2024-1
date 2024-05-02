<?php
// Database configuration
$host = "localhost"; // Change this to your database host
$dbname = "myappsec"; // Change this to your database name
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password

// PDO connection
try {
    $db  = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
