<?php
session_start();
require_once "../config/database.php";

/*
 | PROTECT PAGE
 | Only logged-in teachers allowed
*/
if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "teacher") {
    header("Location: ../index.php");
    exit;
}

// Today date
$today = date("Y-m-d");

// Count students
$totalStudents = $db->query("SELECT COUNT(*) FROM students")->fetchColumn();

// Count today attendance marked by this teacher
$stmt = $db->prepare("
    SELECT COUNT(*) FROM attendance 
    WHERE marked_by = ? AND date = ?
");
$stmt->execute([$_SESSION["user_id"], $today]);
$todayAttendance = $stmt->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Dashboard | Attendance</title>
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
            max-width: 900px;
            margin: auto;
        }

        .welcome {
            margin-bottom: 25px;
        }

        .welcome h2 {
            color: #1e3c72;
        }

        .welcome p {
            font-size: 14px;
            color: #555;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: #fff;
            padding: 25px;
            border-radius: 14px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.08);
        }

        .card h3 {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 30px;
            font-weight: 700;
            color: #1e3c72;
        }

        .actions {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .actions a {
            padding: 14px 28px;
            background: #2a5298;
            color: #fff;
            border-radius: 30px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: 0.3s;
        }

        .actions a:hover {
            background: #1e3c72;
            transform: translateY(-2px);
        }

        .logout {
            background: #c0392b !important;
        }
    </style>
</head>
<body>

<!-- TOP BAR -->
<div class="navbar">
    <strong>Teacher Dashboard</strong>
    <a href="../logout.php">Logout</a>
</div>

<div class="container">

    <!-- WELCOME -->
    <div class="welcome">
        <h2>Welcome, <?= htmlspecialchars($_SESSION["user_name"]) ?></h2>
        <p>Today is <?= date("l, F j, Y") ?></p>
    </div>

    <!-- STATS -->
    <div class="cards">
        <div class="card">
            <h3>Total Students</h3>
            <p><?= $totalStudents ?></p>
        </div>

        <div class="card">
            <h3>Attendance Marked Today</h3>
            <p><?= $todayAttendance ?></p>
        </div>
    </div>

    <!-- ACTION BUTTONS -->
    <div class="actions">
        <a href="mark_attendance.php">📋 Mark Attendance</a>
        <a href="../logout.php" class="logout">🚪 Logout</a>
    </div>

</div>

</body>
</html>
