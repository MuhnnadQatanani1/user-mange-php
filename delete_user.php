<?php
session_start();
include("db_connection.php");

if (!isset($_SESSION['id']) || $_SESSION['privilege'] != 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['delete_user'])) {
    $user_id = $_GET['delete_user'];
    $sql = "DELETE FROM users WHERE id = $user_id";
    
    if ($conn->query($sql) === TRUE) {
        echo "User deleted successfully!";
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
