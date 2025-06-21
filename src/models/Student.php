<?php
class Student {
    private $conn;
    private $table_name = "students";

    public function __construct($db) {
        $this->conn = $db;
    }

    function get_all_by_user($user_id) {
        $stmt = $this->conn->prepare("SELECT * FROM students WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function get_recent_by_user($user_id, $limit = 5) {
        $stmt = $this->conn->prepare("SELECT * FROM students WHERE user_id = ? ORDER BY created_at DESC LIMIT ?");
        $stmt->bindValue(1, $user_id, PDO::PARAM_INT);
        $stmt->bindValue(2, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function create($name, $email, $phone, $course, $image_path, $user_id) {
        $stmt = $this->conn->prepare("INSERT INTO students (name, email, phone, course, image, user_id) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$name, $email, $phone, $course, $image_path, $user_id]);
    }

    function get_single($id, $user_id) {
        $stmt = $this->conn->prepare("SELECT * FROM students WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, $user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function update($id, $name, $email, $phone, $course, $image_path, $user_id) {
        $stmt = $this->conn->prepare("UPDATE students SET name = ?, email = ?, phone = ?, course = ?, image = ? WHERE id = ? AND user_id = ?");
        return $stmt->execute([$name, $email, $phone, $course, $image_path, $id, $user_id]);
    }

    function delete($id, $user_id) {
        $stmt = $this->conn->prepare("DELETE FROM students WHERE id = ? AND user_id = ?");
        return $stmt->execute([$id, $user_id]);
    }
    
    function count_all($user_id){
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM students WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
    
    function count_courses($user_id){
        $stmt = $this->conn->prepare("SELECT COUNT(DISTINCT course) as total FROM students WHERE user_id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
}
?> 