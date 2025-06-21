<?php
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function uploadImage($file, $folder = 'uploads/') {
    // Correct the path to be relative to the public directory
    $base_dir = __DIR__ . '/../../public/';
    $upload_dir = $base_dir . $folder;

    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $filename = $file['name'];
    $filetype = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    
    if (!in_array($filetype, $allowed)) {
        return false;
    }
    
    if ($file['size'] > 5000000) { // 5MB limit
        return false;
    }
    
    $newname = uniqid() . '.' . $filetype;
    $destination = $upload_dir . $newname;
    
    if (move_uploaded_file($file['tmp_name'], $destination)) {
        // Return the web-accessible path
        return $folder . $newname;
    }
    
    return false;
}
?> 