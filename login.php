<?php
session_start();
include("db_connection.php");

if (isset($_SESSION['id'])) {
    // If the user is already logged in, redirect to the appropriate dashboard
    if ($_SESSION['privilege'] == 'admin') {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: user_dashboard.php");
    }
    exit();
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute the query to fetch user data based on username
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        // Fetch the user data
        $user_data = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user_data['password'])) {
            // Start the session and store user data in the session
            $_SESSION['id'] = $user_data['id'];
            $_SESSION['username'] = $user_data['username'];
            $_SESSION['privilege'] = $user_data['privilege'];

            // Redirect to the appropriate dashboard based on user privilege
            if ($user_data['privilege'] == 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: user_dashboard.php");
            }
            exit();
        } else {
            $error = "Invalid username or password!";
        }
    } else {
        $error = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="login-container">
        <h2>Login</h2>

        <?php
        if (isset($error)) {
            echo "<p class='error'>$error</p>";
        }
        ?>

        <form action="login.php" method="POST">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>

            <button type="submit" name="login">Login</button>
        </form>
        
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>

</body>
</html>
