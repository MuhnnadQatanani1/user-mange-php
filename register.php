<?php
session_start();
include("db_connection.php");

// If the user is already logged in, redirect them to their dashboard
if (isset($_SESSION['id'])) {
    if ($_SESSION['privilege'] == 'admin') {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: user_dashboard.php");
    }
    exit();
}

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);  // Hash the password for security

    // Check if the username already exists in the database
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $error = "Username already exists!";
    } else {
        // Insert the new user into the database with 'user' privilege
        $sql = "INSERT INTO users (username, password, email, privilege) 
                VALUES ('$username', '$hashed_password', '$email', 'user')";
        
        if ($conn->query($sql) === TRUE) {
            header("Location: login.php");  // Redirect to login page after successful registration
            exit();
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="register-container">
        <h2>Register as a User</h2>

        <?php
        if (isset($error)) {
            echo "<p class='error'>$error</p>";
        }
        ?>

        <form action="register.php" method="POST">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>

            <button type="submit" name="register">Register</button>
        </form>
        
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>

</body>
</html>
