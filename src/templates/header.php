<?php
session_start();
include_once __DIR__ . '/../../config/database.php';
include_once __DIR__ . '/../models/User.php';

$database = new Database();
$db = $database->getConnection();

$user_logged_in = isset($_SESSION['user_id']);
if ($user_logged_in) {
    $user = new User($db);
    $user_profile = $user->get_profile($_SESSION['user_id']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <?php if ($user_logged_in): ?>
            <div class="nav">
                <h1>Student Management System</h1>
                <div class="nav-links">
                    <a href="index.php?action=dashboard">Dashboard</a>
                    <a href="index.php?action=students">Students</a>
                    <a href="index.php?action=profile">Profile</a>
                    <a href="index.php?action=logout">Logout</a>
                </div>
            </div>
            <?php if (isset($_SESSION['success'])): ?>
                <div class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>
        <?php endif; ?> 