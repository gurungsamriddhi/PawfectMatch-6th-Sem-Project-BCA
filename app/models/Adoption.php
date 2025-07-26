<?php
require_once 'core/databaseconn.php';

class Adoption
{

    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getRecentRequests($limit = 5)
    {

        $sql = "SELECT ar.request_id, ar.request_date, ar.request_status, u.name AS requester_name, p.name AS pet_name
                FROM adoption_requests ar
                JOIN users u ON ar.user_id = u.user_id
                JOIN pets p ON ar.pet_id = p.pet_id
                ORDER BY ar.request_date DESC
                LIMIT ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $requests = [];
        while ($row = $result->fetch_assoc()) {
            $requests[] = $row;
        }
        return $requests;
    }
    //approve request posted by admin in admin dashboard and by adoption center in adoption center respectively
    public function getAllRequests()
    {

        $sql = "SELECT ar.request_id, ar.request_date, ar.request_status, u.name AS requester_name, u.email AS requester_email, p.name AS pet_name, p.type AS pet_type, p.breed, p.image_path
                FROM adoption_requests ar
                JOIN users u ON ar.user_id = u.user_id
                JOIN pets p ON ar.pet_id = p.pet_id
                ORDER BY ar.request_date DESC";
        $result = $this->conn->query($sql);
        $requests = [];
        while ($row = $result->fetch_assoc()) {
            $requests[] = $row;
        }
        return $requests;
    }

    public function getAllForms()
    {

        $sql = "SELECT af.form_id, 
        af.request_id, 
        af.user_id, 
        af.pet_id, 
        af.address, 
        af.phone, 
        af.reason, 
        af.preferred_date,
        af.home_type,
        af.has_other_pets,
        u.name 
          AS requester_name, u.email AS requester_email, 
          p.name AS pet_name, p.type AS pet_type, p.breed, p.image_path
                FROM adoption_form af
                JOIN users u ON af.user_id = u.user_id
                JOIN pets p ON af.pet_id = p.pet_id
                ORDER BY af.form_id DESC";
        $result = $this->conn->query($sql);
        $forms = [];
        while ($row = $result->fetch_assoc()) {
            $forms[] = $row;
        }
        return $forms;
    }

   
}
