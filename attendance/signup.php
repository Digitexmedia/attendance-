<?php
session_start();
require_once "config/database.php";

/*
 | SIGNUP PROCESS
 | - Receives form data from signup.html
 | - Validates input
 | - Hashes password
 | - Saves teacher account
 | - Redirects to login
*/

// Only allow POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: signup.html");
    exit;
}

// Get form data
$name     = trim($_POST["name"] ?? "");
$email    = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";

// Basic validation
if ($name === "" || $email === "" || $password === "") {
    die("All fields are required.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email address.");
}

// Check if email already exists
$check = $db->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
$check->execute([$email]);

if ($check->fetch()) {
    die("This email is already registered.");
}

// Hash password (SECURITY)
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert user as TEACHER
$insert = $db->prepare("
    INSERT INTO users (name, email, password, role)
    VALUES (?, ?, ?, 'teacher')
");

$insert->execute([
    $name,
    $email,
    $hashedPassword
]);

// Redirect to login page
header("Location: index.php");
exit;
