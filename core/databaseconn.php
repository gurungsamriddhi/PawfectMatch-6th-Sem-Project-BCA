<?php
class Database {
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '2607';
    private $dbname = 'pawfect_matchdb';
    private $conn = null;

    public function connect() {
        if ($this->conn === null) {
            $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);

            if ($this->conn->connect_error) {
                die("Database connection failed: " . $this->conn->connect_error);
            }
        }
        return $this->conn;
    }
}
?>
