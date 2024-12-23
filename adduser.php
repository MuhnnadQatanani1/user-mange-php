<?php
session_start();
include("db_connection.php");

// التحقق من أن المستخدم هو أدمن
if ($_SESSION['privilege'] != 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // لتشفير كلمة المرور
    $privilege = $_POST['privilege'];

    // معالجة الصورة
    $photo = $_FILES['photo']['name'];
    $target_dir = "uploads/";  // مسار مجلد رفع الصور
    $target_file = $target_dir . basename($photo);

    // رفع الصورة
    if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
        // إدخال البيانات في قاعدة البيانات
        $sql = "INSERT INTO users (username, email, password, privilege, photo) 
                VALUES ('$username', '$email', '$password', '$privilege', '$photo')";
        if ($conn->query($sql) === TRUE) {
            echo "User added successfully!";
            header("Location: admin_dashboard.php"); // العودة إلى لوحة التحكم
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Failed to upload the image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="form-container">
        <h1>Add User</h1>
        <form method="post" enctype="multipart/form-data">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="email" name="email" placeholder="Email" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <select name="privilege">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select><br>
            <input type="file" name="photo" required><br>
            <button type="submit" name="add_user">Add User</button>
        </form>
    </div>

</body>
</html>
