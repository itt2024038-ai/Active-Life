<?php
session_start();
require_once 'includes/db.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM workouts WHERE user_id = ? AND workout_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) ORDER BY workout_date DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Active Life</title>
</head>
<body>
    <h1>Welcome to Dashboard!</h1>
    <a href="log-workout.php">+ Add New Workout</a> | 
    <a href="contact.php">Contact Us</a> | 
    <a href="auth/logout.php">Logout</a>

    <h2>Weekly Workout Schedule</h2>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Date</th>
            <th>Workout Type</th>
            <th>Duration (mins)</th>
            <th>Calories</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['workout_date']) ?></td>
                    <td><?= htmlspecialchars($row['workout_type']) ?></td>
                    <td><?= htmlspecialchars($row['duration']) ?></td>
                    <td><?= htmlspecialchars($row['calories']) ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="4">this week's workout has not been included yet.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>
