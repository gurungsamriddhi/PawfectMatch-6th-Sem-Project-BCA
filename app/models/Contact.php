<?php
class Contact
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    //userId parameter optional
    public function saveMessage($userId = null, $name, $email, $message)
    {
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


    public function getAllMessages()
    {
        $sql = "SELECT message_id, user_id, name, email, message,reply_message, submitted_at, 
                   CASE WHEN user_id IS NULL THEN 0 ELSE 1 END AS is_verified 
            FROM contact_messages ORDER BY submitted_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function markAsReplied($messageId, $reply)
    {
        $stmt = $this->conn->prepare("UPDATE contact_messages SET reply_message = ?, replied_at = NOW() WHERE message_id = ?");
        $stmt->bind_param("si", $reply, $messageId);
        return $stmt->execute();
    }

    public function getMessageById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM contact_messages WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(MYSQLI_ASSOC);
    }

    public function getMessagesByUser($userId) {
        $sql = "SELECT message, reply_message, submitted_at as date FROM contact_messages WHERE user_id = ? ORDER BY submitted_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $messages = [];
        while ($row = $result->fetch_assoc()) {
            $messages[] = [
                'content' => $row['message'] . ($row['reply_message'] ? ' (Reply: ' . $row['reply_message'] . ')' : ''),
                'date' => $row['date']
            ];
        }
        return $messages;
    }
}
