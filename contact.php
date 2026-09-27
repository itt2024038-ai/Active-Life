<?php
require_once 'includes/db.php'; 

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message_text = trim($_POST['message']);

    if (empty($name) || empty($email) || empty($message_text)) {
        $msg = "<p style='color:red;'>please submit all information.</p>";
    } else {
        $stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message_text);

        if ($stmt->execute()) {
            $msg = "<p style='color:green;'>your massage was sent successfully!</p>";
        } else {
            $msg = "<p style='color:red;'>unable to send the message
            .</p>";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Us - Active Life</title>
</head>
<body>
    <h2>Contact Us</h2>
    <?= $msg ?>

    <form action="contact.php" method="POST">
        <label>Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Message:</label><br>
        <textarea name="message" rows="5" required></textarea><br><br>

        <button type="submit">Send Message</button>
    </form>
    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
