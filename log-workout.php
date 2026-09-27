<?php
session_start();
require_once 'includes/db.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $workout_type = trim($_POST['workout_type']);
    $duration = trim($_POST['duration']);
    $calories = trim($_POST['calories']);
    $workout_date = trim($_POST['workout_date']);

    if (empty($workout_type) || empty($duration) || empty($workout_date)) {
        $message = "<p style='color:red;'> please provide the mandatory information!</p>";
    } elseif (!is_numeric($duration) || $duration <= 0) {
        $message = "<p style='color:red;'>enter the number greater than 0 for the duration.</p>";
    } else {
        $stmt = $conn->prepare("INSERT INTO workouts (user_id, workout_type, duration, calories, workout_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("isids", $user_id, $workout_type, $duration, $calories, $workout_date);

        if ($stmt->execute()) {
            $message = "<p style='color:green;'>Workout save scussful!</p>";
        } else {
            $message = "<p style='color:red;'>can't save.</p>";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Log Workout - Active Life</title>
    <script>
        function validateWorkout() {
            let duration = document.getElementById('duration').value;
            if (duration <= 0) {
                alert("number is greater than 0 for the duration!");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
    <h2>Log Your Workout</h2>
    <?= $message ?>
    
    <form action="log-workout.php" method="POST" onsubmit="return validateWorkout()">
        <label>Workout Type:</label><br>
        <input type="text" name="workout_type" id="workout_type" placeholder="eg: Running, Pushups" required><br><br>

        <label>Duration (Minutes):</label><br>
        <input type="number" id="duration" name="duration" required><br><br>

        <label>Calories Burned:</label><br>
        <input type="number" name="calories"><br><br>

        <label>Date:</label><br>
        <input type="date" name="workout_date" required><br><br>

        <button type="submit">Save Workout</button>
    </form>
    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>