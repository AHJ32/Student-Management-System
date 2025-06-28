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
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <?php if ($user_logged_in): ?>
            <div class="nav">
                <h1><?php echo htmlspecialchars($user_profile['institution_name'] ?? 'Student Management'); ?></h1>
                <div class="nav-links">
                    <a href="index.php?action=dashboard" title="Dashboard"><i class="fas fa-tachometer-alt"></i></a>
                    <a href="index.php?action=students" title="Students"><i class="fas fa-users"></i></a>
                    <a href="index.php?action=profile" title="Profile">
                        <?php if (!empty($user_profile['profile_image'])): ?>
                            <img src="<?php echo htmlspecialchars($user_profile['profile_image']); ?>" alt="Profile" class="nav-profile-img">
                        <?php else: ?>
                            <i class="fas fa-user nav-profile-img" style="display: inline-block; width: 28px; height: 28px; text-align: center; line-height: 28px;"></i>
                        <?php endif; ?>
                    </a>
                    <a href="index.php?action=about" title="About Us"><i class="fas fa-info-circle"></i></a>
                    <a href="index.php?action=logout" title="Logout"><i class="fas fa-sign-out-alt"></i></a>
                </div>
            </div>
            <?php if (isset($_SESSION['success'])): ?>
                <div class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>
        <?php endif; ?> 