<?php
session_start();
require_once "../config/database.php";

/* 
 | PAGE PROTECTION
 | Only logged-in admins allowed
*/
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin") {
    header("Location: ../index.php");
    exit;
}

// Dashboard stats
$totalStudents = $db->query("SELECT COUNT(*) FROM students")->fetchColumn();
$totalTeachers = $db->query("SELECT COUNT(*) FROM users WHERE role='teacher'")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | Attendance</title>
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

        .navbar h2 {
            font-size: 20px;
        }

        .navbar span {
            font-size: 14px;
            opacity: 0.9;
        }

        .container {
            padding: 30px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: #fff;
            border-radius: 14px;
            padding: 25px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.08);
        }

        .card h3 {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 32px;
            font-weight: 700;
            color: #1e3c72;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .actions a {
            padding: 14px 26px;
            border-radius: 30px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            color: #fff;
            background: #2a5298;
            transition: 0.3s;
        }

        .actions a:hover {
            background: #1e3c72;
            transform: translateY(-2px);
        }

        .logout {
            background: #c0392b !important;
        }

        @media (max-width: 600px) {
            .navbar {
                flex-direction: column;
                align-items: flex-start;
                gap: 6px;
            }
        }
    </style>
</head>
<body>

<!-- TOP BAR -->
<div class="navbar">
    <div>
        <h2>Admin Dashboard</h2>
        <span>Welcome, <?= htmlspecialchars($_SESSION["user_name"]) ?></span>
    </div>
    <a href="../logout.php" style="color:#fff; text-decoration:none; font-weight:600;">Logout</a>
</div>

<!-- MAIN CONTENT -->
<div class="container">

    <!-- STATS -->
    <div class="cards">
        <div class="card">
            <h3>Total Students</h3>
            <p><?= $totalStudents ?></p>
        </div>

        <div class="card">
            <h3>Total Teachers</h3>
            <p><?= $totalTeachers ?></p>
        </div>
    </div>

    <!-- ACTION BUTTONS -->
    <div class="actions">
        <a href="add_student.php">➕ Add Students</a>
        <a href="#">📋 View Attendance</a>
        <a href="../logout.php" class="logout">🚪 Logout</a>
    </div>

</div>

</body>
</html>
