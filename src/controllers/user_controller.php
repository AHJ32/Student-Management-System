<?php
include_once __DIR__ . '/../models/User.php';
include_once __DIR__ . '/helpers.php';

function handle_user_actions($db, $action, $method) {
    $user_model = new User($db);
    $user_id = $_SESSION['user_id'];

    if ($method == 'POST' && $_POST['action'] == 'update_profile') {
        $username = sanitize($_POST['username']);
        $email = sanitize($_POST['email']);
        
        // Get the current profile to start with the existing image
        $current_profile = $user_model->get_profile($user_id);
        $image_path = $current_profile['profile_image'];

        // Check if a new image has been uploaded
        if (isset($_FILES['profile_image']) && !empty($_FILES['profile_image']['name']) && $_FILES['profile_image']['error'] == 0) {
            $new_image_path = uploadImage($_FILES['profile_image'], 'uploads/profiles/');

            if ($new_image_path) {
                if ($image_path && file_exists(__DIR__ . '/../../public/' . $image_path)) {
                    unlink(__DIR__ . '/../../public/' . $image_path);
                }
                $image_path = $new_image_path;
            } else {
                $_SESSION['error'] = "Image upload failed. Please use a valid image (JPG, PNG, GIF) under 5MB.";
                header("Location: index.php?action=profile");
                exit;
            }
        }
        
        // Now, update the profile with the correct image path (either the new one or the old one)
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