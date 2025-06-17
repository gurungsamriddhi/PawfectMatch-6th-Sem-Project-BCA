<?php
class Database {
    private $conn;

    public function connect() {
        $this->conn = new mysqli('localhost', 'root', '', 'pawfect_match');
        

        if ($this->conn->connect_error) {
            die('Database connection failed: ' . $this->conn->connect_error);
        }

        echo "✅ Database connection successful.<br>";
        return $this->conn;
    }
}
?>
