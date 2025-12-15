<?php
// config.php - Central configuration file with hardcoded credentials

// --- Database Credentials (Hardcoded from your previous input) ---
define('DB_SERVER',   'bbxadela8k44zpsqtbcx-mysql.services.clever-cloud.com'); 
define('DB_USERNAME', 'uwmi4721ekceqwhr');
define('DB_PASSWORD', 'HxYCSsUt0awQIr20dVTz'); 
define('DB_NAME',     'bbxadela8k44zpsqtbcx'); 
define('DB_PORT',     '3306'); 

// --- Attempt to connect to MySQL database ---
// Uses the constants defined above
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME, DB_PORT);

// Check connection
if ($conn === false) {
    // Log the error and hide the details from the public
    error_log("Database Connection Error: " . mysqli_connect_error());
    die("ERROR: The system is currently undergoing maintenance. Please try again shortly.");
}

// Set the charset to UTF-8
mysqli_set_charset($conn, "utf8mb4");

// Note: The variable $conn is now globally available when this file is included.
?>
