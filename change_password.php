<?php
session_start();
include("db_connection.php");

// If no session exists, redirect to login
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];

// If admin wants to change a user's password, get the user ID
if (isset($_GET['change_password'])) {
    if ($_SESSION['privilege'] == 'admin') {
        $user_id = $_GET['change_password'];
    }
}

if (isset($_POST['change_password'])) {
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $sql = "UPDATE users SET password = '$new_password' WHERE id = $user_id";
    if ($conn->query($sql) === TRUE) {
        echo "Password updated successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="form-container">
        <h2>Change Password</h2>
        <form action="" method="post">
            <input type="password" name="new_password" placeholder="New Password" required>
            <button type="submit" name="change_password">Change Password</button>
        </form>
    </div>

</body>
</html>
