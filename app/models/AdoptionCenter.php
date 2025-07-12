 <?php
 class AdoptionCenter{
  protected $conn;

    public function __construct($conn)
    {
        
        $this->conn = $conn;
    }
 
 
 
  public function getAllAdoptionCenterUsers()
    {
        $stmt = $this->conn->prepare("SELECT user_id, name, user_type, email, status FROM users WHERE user_type = 'adoption_center'");
        $stmt->execute();

        $result = $stmt->get_result();  // works only if mysqlnd is installed
        return $result->fetch_all(MYSQLI_ASSOC);
    }
 
 
 public function getAdoptionCenterUserById($user_id)
    {
        $stmt = $this->conn->prepare("SELECT user_id,name,user_type,email,status FROM users WHERE user_id=? AND user_type='adoption_center'");
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getAdoptionCenterDetailsByUserId($user_id)
    {
        $stmt = $this->conn->prepare("
        SELECT  u.name, u.email, u.status, ac.established_date, ac.location, ac.phone, ac.number_of_employees, ac.description, ac.operating_hours
        FROM users u 
        LEFT JOIN adoption_centers ac ON u.user_id = ac.user_id
        WHERE u.user_id = ?
    ");
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

     public function updateCenterUser($user_id, $name, $email, $status)
    {
        $stmt = $this->conn->prepare("UPDATE users SET name = ?, email = ?, status = ? WHERE user_id = ?");
        $stmt->bind_param('sssi', $name, $email, $status, $user_id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    public function deleteCenterUser($user_id)
    {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE user_id = ? AND user_type = 'adoption_center'");
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}
?>