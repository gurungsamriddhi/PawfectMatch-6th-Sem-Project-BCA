<?php
require_once 'core/databaseconn.php';

class User
{
    public static function findByEmail($email)
    {
        $db = new Database();
        $conn = $db->connect();//php syntax to call the function using object of a class

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc();  // return user data or null
    }

    public static function create($name, $email, $password, $user_type)
    {   $db= new Database();
        $conn = $db->connect();

        $stmt = $conn->prepare("INSERT INTO users (name, email, password, user_type) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $name, $email, $password, $user_type);

        return $stmt->execute();  // returns true if success, false otherwise
    }
}
