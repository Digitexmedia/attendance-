<?php
session_start();
require_once "../config/database.php";

/*
 | PROTECT PAGE
 | Only admin can access
*/
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin") {
    header("Location: ../index.php");
    exit;
}

$message = "";

/*
 | HANDLE FORM SUBMISSION
*/
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $student_name = trim($_POST["student_name"]);

    if ($student_name !== "") {
        $stmt = $db->prepare("INSERT INTO students (student_name) VALUES (?)");
        $stmt->execute([$student_name]);
        $message = "Student added successfully";
    } else {
        $message = "Student name is required";
    }
}

// Fetch all students
$students = $db->query("SELECT * FROM students ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Students | Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #f1f4f8;
            min-height: 100vh;
        }

        .navbar {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: #fff;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            font-weight: 600;
        }

        .container {
            padding: 30px;
            max-width: 800px;
            margin: auto;
        }

        .card {
            background: #fff;
            padding: 25px;
            border-radius: 14px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.08);
            margin-bottom: 25px;
        }

        h3 {
            margin-bottom: 15px;
            color: #1e3c72;
        }

        input {
            width: 100%;
            padding: 13px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
            font-size: 14px;
        }

        button {
            background: #2a5298;
            color: #fff;
            border: none;
            padding: 12px 26px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        button:hover {
            background: #1e3c72;
        }

        .message {
            margin-bottom: 15px;
            font-size: 14px;
            color: green;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            text-align: left;
            font-size: 14px;
        }

        table th {
            background: #f8f9fc;
        }
    </style>
</head>
<body>

<!-- TOP BAR -->
<div class="navbar">
    <strong>Add Students</strong>
    <a href="dashboard.php">Dashboard</a>
</div>

<div class="container">

    <!-- ADD STUDENT FORM -->
    <div class="card">
        <h3>Add New Student</h3>

        <?php if ($message): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <form method="post">
            <input type="text" name="student_name" placeholder="Enter student full name" required>
            <button type="submit">Add Student</button>
        </form>
    </div>

    <!-- STUDENT LIST -->
    <div class="card">
        <h3>All Students</h3>

        <table>
            <tr>
                <th>#</th>
                <th>Student Name</th>
            </tr>

            <?php foreach ($students as $index => $student): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($student["student_name"]) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

</div>

</body>
</html>
