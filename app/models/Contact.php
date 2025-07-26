<?php
//use stmt closee
//not necessary recommended to use pdo instead of myssqli
class Contact
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    //userId parameter optional
public function saveMessage($name, $email, $message, $userId = null)
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
}
