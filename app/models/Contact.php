<?php
class Contact {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
//userId parameter optional
    public function saveMessage($userId =null,$name, $email, $message) {
         if ($userId) {
            $stmt = $this->conn->prepare("INSERT INTO contact_messages (user_id, name, email, message) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('isss', $userId, $name, $email, $message);
        } else {
            $stmt = $this->conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
            $stmt->bind_param('sss', $name, $email, $message);
        }

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    

    public function getAllMessages() {
        $result = $this->conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
