<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define a base path for the application
define('BASE_PATH', realpath(__DIR__ . '/..'));

require_once BASE_PATH . '/src/templates/header.php';
require_once BASE_PATH . '/src/controllers/auth_controller.php';
require_once BASE_PATH . '/src/controllers/student_controller.php';
require_once BASE_PATH . '/src/controllers/user_controller.php';

$action = $_GET['action'] ?? 'login';
$method = $_SERVER['REQUEST_METHOD'];

// Handle actions that don't require login
$public_actions = ['login', 'register', 'forgot_password', 'reset_password'];
if (in_array($action, $public_actions) || (isset($_POST['action']) && in_array($_POST['action'], $public_actions))) {
    handle_auth_actions($db, $action, $method);
}

// If user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    if (!in_array($action, $public_actions)) {
        header("Location: index.php?action=login");
        exit;
    }
} else {
    // These actions require a logged-in user
    handle_student_actions($db, $action, $method);
    handle_user_actions($db, $action, $method);
    
    if($action === 'logout'){
        handle_auth_actions($db, $action, $method);
    }
}


$view_file = BASE_PATH . '/views/' . $action . '.php';

// Main content
if (file_exists($view_file)) {
    include $view_file;
} else {
    // Default to dashboard if logged in, or login page if not
    if (isset($_SESSION['user_id'])) {
        include BASE_PATH . '/views/dashboard.php';
    } else {
        include BASE_PATH . '/views/login.php';
    }
}

require_once BASE_PATH . '/src/templates/footer.php';

?>