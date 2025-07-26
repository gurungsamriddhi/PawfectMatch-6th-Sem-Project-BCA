<?php
session_start();
require_once 'core/databaseconn.php';
require_once 'app/models/Adoption.php';

header('Content-Type: application/json');

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    echo json_encode(['success' => false, 'message' => 'Admin not logged in']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $requestId = intval($_POST['request_id'] ?? 0);

    if (!$requestId) {
        echo json_encode(['success' => false, 'message' => 'Invalid request ID']);
        exit;
    }

    // Get the adoption request details
    $request = Adoption::getRequestById($requestId);
    if (!$request) {
        echo json_encode(['success' => false, 'message' => 'Adoption request not found']);
        exit;
    }

    switch ($action) {
        case 'approve':
            // Update request status to approved
            if (Adoption::updateRequestStatus($requestId, 'approved')) {
                // Update pet status to adopted
                Adoption::updatePetStatus($request['pet_id'], 'adopted');
                echo json_encode(['success' => true, 'message' => 'Adoption request approved']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to approve request']);
            }
            break;

        case 'reject':
            // Update request status to rejected
            if (Adoption::updateRequestStatus($requestId, 'rejected')) {
                echo json_encode(['success' => true, 'message' => 'Adoption request rejected']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to reject request']);
            }
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
            break;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?> 