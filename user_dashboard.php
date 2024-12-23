<?php
session_start();
include("db_connection.php");

// If no session exists, redirect to login
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];

// Fetch the logged-in user's details
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = $conn->query($sql);
$user_data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="dashboard-container">
        <h1>User Dashboard</h1>
        <p>Welcome, <?php echo $user_data['username']; ?>! Here are your details:</p>
        <table>
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Privilege</th>
                <th>Photo</th>
            </tr>
            <tr>
                <td><?php echo $user_data['username']; ?></td>
                <td><?php echo $user_data['email']; ?></td>
                <td><?php echo $user_data['privilege']; ?></td>
                <td><img src="uploads/<?php echo $user_data['photo']; ?>" alt="User Photo" width="50" height="50"></td>
            </tr>
        </table>

        <h2>Update Your Details</h2>
        <form action="update_user.php" method="post">
            <input type="text" name="username" value="<?php echo $user_data['username']; ?>" required>
            <input type="email" name="email" value="<?php echo $user_data['email']; ?>" required>
            <input type="file" name="photo">
            <button type="submit" name="update_details">Update Details</button>
        </form>

        <h2>Change Password</h2>
        <form action="change_password.php" method="post">
            <input type="password" name="new_password" placeholder="New Password" required>
            <button type="submit" name="change_password">Change Password</button>
        </form>

        <a href="logout.php" class="button">Logout</a>
    </div>

</body>
</html>
