<?php
require_once 'includes/functions.php';
require_login();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Active Life</title>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p>You are successfully logged in to Fitness Tracker.</p>
    
    <nav>
        <a href="auth/logout.php">Logout</a>
    </nav>
</body>
</html>