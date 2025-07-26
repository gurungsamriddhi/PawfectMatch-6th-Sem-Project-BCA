 <?php
    class AdoptionCenter
    {
        protected $conn;

        public function __construct($conn)
        {

            $this->conn = $conn;
        }


        public function getAllCentersWithUserInfo()
        {
            $sql = "SELECT u.user_id, u.name, u.email, u.status,
               ac.center_id, ac.phone
        FROM users u
        LEFT JOIN adoption_centers ac ON u.user_id = ac.user_id
        WHERE u.user_type = 'adoption_center' AND u.status != 'deleted'";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function getAllAdoptionCenterUsers()
        {
            $stmt = $this->conn->prepare("SELECT user_id, name, user_type, email, status FROM users WHERE user_type = 'adoption_center' AND status!='deleted'");
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

        public function getAdoptionCenterDetailsByCenterId($center_id)
        {
            $stmt = $this->conn->prepare("
        SELECT ac.center_id, ac.name, ac.phone, u.email AS user_email, u.name AS user_name
        FROM adoption_centers ac
        LEFT JOIN users u ON ac.user_id = u.user_id
        WHERE ac.center_id = ?
    ");
            $stmt->bind_param('i', $center_id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }

        public function getCenterIdByUserId($user_id)
        {
            $stmt = $this->conn->prepare("SELECT center_id FROM adoption_centers WHERE user_id = ?");
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            return $row ? $row['center_id'] : null;
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
            $stmt = $this->conn->prepare("UPDATE users SET status = 'deleted' WHERE user_id = ? AND user_type = 'adoption_center'");
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            return $stmt->affected_rows > 0;
        }
    }
    ?>