<?php
class Donation
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function saveDonation($user_id, $name, $email, $amount, $message = null)
    {
        $stmt = $this->conn->prepare("INSERT INTO donations (user_id, name, email, amount, message) VALUES (?, ?, ?, ?, ?)");
        if ($stmt === false) {
            die("Prepare failed: " . $this->conn->error);
        }

        // user_id can be null for guests
        if ($user_id === null) {
            $null = null;
            $stmt->bind_param("issds", $null, $name, $email, $amount, $message);
        } else {
            $stmt->bind_param("issds", $user_id, $name, $email, $amount, $message);
        }

        return $stmt->execute();
    }
}
