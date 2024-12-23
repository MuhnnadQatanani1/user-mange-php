<?php
$servername = "localhost";
$username = "root"; // اسم المستخدم
$password = ""; // كلمة المرور
$dbname = "resturant"; // اسم قاعدة البيانات

// إنشاء الاتصال
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
