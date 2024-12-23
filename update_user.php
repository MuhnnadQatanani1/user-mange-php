<?php
session_start();
include("db_connection.php");

// التحقق من أن المستخدم هو أدمن
if ($_SESSION['privilege'] != 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['edit_user'])) {
    $id = $_GET['edit_user'];
    $sql = "SELECT * FROM users WHERE id = $id";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
}

if (isset($_POST['update_user'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $privilege = $_POST['privilege'];

    // التحقق إذا كانت هناك صورة جديدة تم رفعها
    $photo = $_FILES['photo']['name'];
    if ($photo) {  // إذا تم رفع صورة جديدة
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($photo);
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
            $sql = "UPDATE users SET username='$username', email='$email', privilege='$privilege', photo='$photo' WHERE id=$id";
            $conn->query($sql);
        } else {
            echo "Failed to upload the image.";
        }
    } else {
        $sql = "UPDATE users SET username='$username', email='$email', privilege='$privilege' WHERE id=$id";
        $conn->query($sql);
    }
    header("Location: admin_dashboard.php"); // العودة إلى لوحة التحكم
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="form-container">
        <h1>Edit User</h1>
        <form method="post" enctype="multipart/form-data">
            <input type="text" name="username" value="<?php echo $user['username']; ?>" required><br>
            <input type="email" name="email" value="<?php echo $user['email']; ?>" required><br>
            <select name="privilege">
                <option value="user" <?php echo $user['privilege'] == 'user' ? 'selected' : ''; ?>>User</option>
                <option value="admin" <?php echo $user['privilege'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
            </select><br>
            <input type="file" name="photo"><br>
            <button type="submit" name="update_user">Update User</button>
        </form>
    </div>

</body>
</html>
