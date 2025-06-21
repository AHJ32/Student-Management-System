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
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];
                
                $errors = [];
                if (strlen($username) < 3) $errors[] = "Username must be at least 3 characters";
                if (!validateEmail($email)) $errors[] = "Invalid email format";
                if (strlen($password) < 6) $errors[] = "Password must be at least 6 characters";
                if ($password !== $confirm_password) $errors[] = "Passwords do not match";
                if ($user->user_exists($username, $email)) $errors[] = "Username or email already exists";

                if (empty($errors)) {
                    if ($user->register($username, $email, $password)) {
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