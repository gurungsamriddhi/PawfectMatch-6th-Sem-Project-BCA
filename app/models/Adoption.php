<?php
require_once 'core/databaseconn.php';

class Adoption {
    public static function getRecentRequests($limit = 5) {
        $db = new Database();
        $conn = $db->connect();
        $sql = "SELECT ar.request_id, ar.request_date, ar.request_status, u.name AS requester_name, p.name AS pet_name
                FROM adoption_requests ar
                JOIN users u ON ar.user_id = u.user_id
                JOIN pets p ON ar.pet_id = p.pet_id
                ORDER BY ar.request_date DESC
                LIMIT ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $requests = [];
        while ($row = $result->fetch_assoc()) {
            $requests[] = $row;
        }
        return $requests;
    }
    
}
