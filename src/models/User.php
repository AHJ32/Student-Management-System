<?php
class User {
    private $conn;
    private $table_name = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    function register($username, $email, $institution_name, $password) {
        $query = "INSERT INTO " . $this->table_name . " (username, email, institution_name, password) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        return $stmt->execute([$username, $email, $institution_name, $hashed_password]);
    }

    function login($username, $password) {
        $query = "SELECT id, username, email, password FROM " . $this->table_name . " WHERE username = ? OR email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
    
    function get_profile($user_id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    function update_profile($user_id, $username, $email, $image_path = null) {
        if ($image_path) {
            $stmt = $this->conn->prepare("UPDATE users SET username = ?, email = ?, profile_image = ? WHERE id = ?");
            return $stmt->execute([$username, $email, $image_path, $user_id]);
        } else {
            $stmt = $this->conn->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
            return $stmt->execute([$username, $email, $user_id]);
        }
    }

    function user_exists($username, $email) {
        $stmt = $this->conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        return $stmt->rowCount() > 0;
    }
}
?> 