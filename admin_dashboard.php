<?php
session_start();
include("db_connection.php");

// Redirect to login if the user is not logged in or not an admin
if (!isset($_SESSION['id']) || $_SESSION['privilege'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Admin can see all users and their own profile
$sql = "SELECT * FROM users WHERE privilege = 'user' OR id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error preparing the SQL statement: " . $conn->error);
}

// Bind the logged-in admin's ID to the query
$stmt->bind_param("i", $_SESSION['id']);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <div class="dashboard-container">
        <h1>Admin Dashboard</h1>
        <p>Welcome Admin! Here you can manage all users.</p>
        <a href="adduser.php" class="button">Add New User</a>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Privilege</th>
                <th>Photo</th>
                <th>Actions</th>
            </tr>
            <?php while ($user = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['privilege']); ?></td>
                    <td>
                        <?php if (!empty($user['photo'])): ?>
                            <img src="uploads/<?php echo htmlspecialchars($user['photo']); ?>" alt="User Photo" width="50"
                                height="50">
                        <?php else: ?>
                            <span>No photo</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="update_user.php?edit_user=<?php echo $user['id']; ?>" class="button">Edit</a>
                        <a href="delete_user.php?delete_user=<?php echo $user['id']; ?>" class="button"
                            onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                        <a href="change_password.php?change_password=<?php echo $user['id']; ?>" class="button">Change
                            Password</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        <a href="logout.php" class="button">Logout</a>
    </div>

</body>

</html>