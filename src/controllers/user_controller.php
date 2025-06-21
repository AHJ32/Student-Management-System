<?php
include_once __DIR__ . '/../models/User.php';
include_once __DIR__ . '/helpers.php';

function handle_user_actions($db, $action, $method) {
    $user_model = new User($db);
    $user_id = $_SESSION['user_id'];

    if ($method == 'POST' && $_POST['action'] == 'update_profile') {
        $username = sanitize($_POST['username']);
        $email = sanitize($_POST['email']);
        
        $image_path = null;
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
            // Get old profile to delete the image
            $current_profile = $user_model->get_profile($user_id);
            $old_image_path = $current_profile['profile_image'];

            $image_path = uploadImage($_FILES['profile_image'], 'uploads/profiles/');

            // If upload is successful and there was an old image, delete it
            if ($image_path && $old_image_path) {
                $full_old_path = __DIR__ . '/../../public/' . $old_image_path;
                if (file_exists($full_old_path)) {
                    unlink($full_old_path);
                }
            }
        }
        
        if ($user_model->update_profile($user_id, $username, $email, $image_path)) {
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['success'] = "Profile updated successfully!";
        } else {
            $_SESSION['error'] = "Failed to update profile.";
        }
        header("Location: index.php?action=profile");
        exit;
    }
}
?> 