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

/*
 | FETCH ATTENDANCE MARKED BY THIS TEACHER
*/
$stmt = $db->prepare("
    SELECT 
        attendance.date,
        attendance.status,
        students.student_name
    FROM attendance
    JOIN students ON attendance.student_id = students.id
    WHERE attendance.marked_by = ?
    ORDER BY attendance.date DESC
");

$stmt->execute([$_SESSION["user_id"]]);
$records = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Attendance | Teacher</title>
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
            max-width: 1000px;
            margin: auto;
        }

        .card {
            background: #fff;
            padding: 25px;
            border-radius: 14px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.08);
        }

        h3 {
            margin-bottom: 20px;
            color: #1e3c72;
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

        .present {
            color: green;
            font-weight: 600;
        }

        .absent {
            color: red;
            font-weight: 600;
        }
    </style>
</head>
<body>

<!-- TOP BAR -->
<div class="navbar">
    <strong>My Attendance</strong>
    <a href="dashboard.php">Dashboard</a>
</div>

<div class="container">
    <div class="card">
        <h3>Attendance Records You Marked</h3>

        <table>
            <tr>
                <th>Date</th>
                <th>Student Name</th>
                <th>Status</th>
            </tr>

            <?php if (count($records) === 0): ?>
                <tr>
                    <td colspan="3">No attendance records found.</td>
                </tr>
            <?php endif; ?>

            <?php foreach ($records as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row["date"]) ?></td>
                    <td><?= htmlspecialchars($row["student_name"]) ?></td>
                    <td class="<?= strtolower($row["status"]) ?>">
                        <?= htmlspecialchars($row["status"]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

</body>
</html>
