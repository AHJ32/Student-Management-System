<?php
include_once __DIR__ . '/../models/Student.php';
include_once __DIR__ . '/helpers.php';

function handle_student_actions($db, $action, $method) {
    $student_model = new Student($db);
    $user_id = $_SESSION['user_id'];

    if ($method == 'POST') {
        $user = new User($db);
        $user_profile = $user->get_profile($user_id);
        $institution_type = $user_profile['institution_type'] ?? 'Polytechnic';
        switch ($_POST['action']) {
            case 'add_student':
                $name = sanitize($_POST['name']);
                $email = sanitize($_POST['email']);
                $phone = sanitize($_POST['phone']);
                $course = '';
                $dept = '';
                $sem = '';
                if ($institution_type === 'Polytechnic') {
                    $dept = sanitize($_POST['dept']);
                    $sem = sanitize($_POST['sem']);
                } else {
                    $course = sanitize($_POST['course']);
                }
                $image_path = null;
                if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                    $image_path = uploadImage($_FILES['image']);
                }
                if ($student_model->create($name, $email, $phone, $course, $dept, $sem, '', $image_path, $user_id)) {
                    $_SESSION['success'] = "Student added successfully!";
                } else {
                    $_SESSION['error'] = "Failed to add student";
                }
                header("Location: index.php?action=students");
                exit;

            case 'update_student':
                $id = $_POST['id'];
                $name = sanitize($_POST['name']);
                $email = sanitize($_POST['email']);
                $phone = sanitize($_POST['phone']);
                $course = '';
                $dept = '';
                $sem = '';
                if ($institution_type === 'Polytechnic') {
                    $dept = sanitize($_POST['dept']);
                    $sem = sanitize($_POST['sem']);
                } else {
                    $course = sanitize($_POST['course']);
                }
                $image_path = $_POST['current_image'];
                if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                    $new_image = uploadImage($_FILES['image']);
                    if ($new_image) {
                        $full_old_path = __DIR__ . '/../../public/' . $image_path;
                        if ($image_path && file_exists($full_old_path)) {
                            unlink($full_old_path);
                        }
                        $image_path = $new_image;
                    }
                }
                if ($student_model->update($id, $name, $email, $phone, $course, $dept, $sem, '', $image_path, $user_id)) {
                    $_SESSION['success'] = "Student updated successfully!";
                } else {
                    $_SESSION['error'] = "Failed to update student";
                }
                header("Location: index.php?action=students");
                exit;
        }

        if (isset($_GET['delete_student'])) {
            $id = $_GET['delete_student'];
            // First, get the student to find the image path
            $student = $student_model->get_single($id, $user_id);
            // Then, delete the student record
            if ($student_model->delete($id, $user_id)) {
                // If DB deletion is successful, delete the image file
                if ($student && $student['image']) {
                    $full_image_path = __DIR__ . '/../../public/' . $student['image'];
                    if (file_exists($full_image_path)) {
                        unlink($full_image_path);
                    }
                }
                $_SESSION['success'] = "Student deleted successfully!";
            } else {
                $_SESSION['error'] = "Failed to delete student";
            }
            header("Location: index.php?action=students");
            exit;
        }
    }
}
?> 