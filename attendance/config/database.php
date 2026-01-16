<?php
/*
 | DATABASE CONNECTION FILE
 | Used by all PHP files in the project
 | DO NOT put HTML here
*/

// Database credentials (from cPanel)
$host = "localhost";
$dbname = "YOUR_DATABASE_NAME";
$dbuser = "YOUR_DATABASE_USER";
$dbpass = "YOUR_DATABASE_PASSWORD";

try {
    $db = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $dbuser,
        $dbpass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    // Stop execution if DB fails
    die("Database connection failed");
}
