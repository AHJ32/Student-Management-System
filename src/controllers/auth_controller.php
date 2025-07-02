<?php
include_once __DIR__ . '/../models/User.php';
include_once __DIR__ . '/helpers.php';

function handle_auth_actions($db, $action, $method) {
    $user = new User($db);

    if ($method == 'POST') {
        switch ($_POST['action']) {
            case 'register':
                $username = sanitize($_POST['username']);
                $email = sanitize($_POST['email']);
                $institution_name = sanitize($_POST['institution_name']);
                $institution_type = sanitize($_POST['institution_type']);
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];
                
                $errors = [];
                if (strlen($username) < 3) $errors[] = "Username must be at least 3 characters";
                if (!validateEmail($email)) $errors[] = "Invalid email format";
                
                // New password policy validation
                $password_regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/";
                if (!preg_match($password_regex, $password)) {
                    $errors[] = "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one number.";
                }

                if ($password !== $confirm_password) $errors[] = "Passwords do not match";
                if ($user->user_exists($username, $email)) $errors[] = "Username or email already exists";

                if (empty($errors)) {
                    if ($user->register($username, $email, $institution_name, $institution_type, $password)) {
                        $_SESSION['success'] = "Registration successful! Please login.";
                        header("Location: index.php?action=login");
                        exit;
                    } else {
                        $errors[] = "Registration failed";
                    }
                }
                $_SESSION['errors'] = $errors;
                $_SESSION['post_data'] = $_POST;
                header("Location: index.php?action=register");
                exit;

            case 'forgot_password':
                $email = sanitize($_POST['email']);
                if ($user->user_exists('', $email)) {
                    $_SESSION['reset_email'] = $email;
                    header("Location: index.php?action=reset_password");
                    exit;
                } else {
                    $_SESSION['error'] = "No account found with that email address.";
                    header("Location: index.php?action=forgot_password");
                    exit;
                }

            case 'reset_password':
                $email = sanitize($_POST['email']);
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];

                // New password policy validation
                $password_regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/";
                if (!preg_match($password_regex, $password)) {
                    $_SESSION['error'] = "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one number.";
                    unset($_SESSION['reset_email']); // Clear the session
                    header("Location: index.php?action=forgot_password");
                    exit;
                }

                if ($password !== $confirm_password) {
                    $_SESSION['error'] = "Passwords do not match.";
                    unset($_SESSION['reset_email']); // Clear the session
                    header("Location: index.php?action=forgot_password");
                    exit;
                }

                if ($user->update_password_by_email($email, $password)) {
                    unset($_SESSION['reset_email']);
                    $_SESSION['success'] = "Your password has been reset successfully! Please login.";
                    header("Location: index.php?action=login");
                    exit;
                } else {
                    $_SESSION['error'] = "Failed to reset password. Please try again.";
                    unset($_SESSION['reset_email']);
                    header("Location: index.php?action=forgot_password");
                    exit;
                }

            case 'login':
                $username = sanitize($_POST['username']);
                $password = $_POST['password'];
                
                $logged_in_user = $user->login($username, $password);
                if ($logged_in_user) {
                    $_SESSION['user_id'] = $logged_in_user['id'];
                    $_SESSION['username'] = $logged_in_user['username'];
                    $_SESSION['email'] = $logged_in_user['email'];
                    header("Location: index.php?action=dashboard");
                    exit;
                } else {
                    $_SESSION['error'] = "Invalid username or password";
                    header("Location: index.php?action=login");
                    exit;
                }
        }
    } else { // GET
        if ($action == 'logout') {
            session_destroy();
            header("Location: index.php?action=login");
            exit;
        }
    }
}
?> 