<?php
session_start();
require_once 'core/databaseconn.php';
require_once 'app/models/Adoption.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
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

    // Verify that the user owns this request
    if ($request['user_id'] != $_SESSION['user']['id']) {
        echo json_encode(['success' => false, 'message' => 'You can only cancel your own adoption requests']);
        exit;
    }

    // Check if the request is still pending (can only cancel pending requests)
    if (strtolower($request['request_status']) !== 'pending') {
        echo json_encode(['success' => false, 'message' => 'You can only cancel pending adoption requests']);
        exit;
    }

    switch ($action) {
        case 'cancel':
            // Update request status to rejected (since cancelled is not in the ENUM)
            // We'll add a note to distinguish user-cancelled from admin-rejected
            if (Adoption::updateRequestStatus($requestId, 'rejected')) {
                // Track cancelled requests in session
                if (!isset($_SESSION['cancelled_requests'])) {
                    $_SESSION['cancelled_requests'] = [];
                }
                $_SESSION['cancelled_requests'][] = $requestId;
                
                // Add a note or update a field to indicate this was user-cancelled
                // For now, we'll return a special response that the frontend can handle
                echo json_encode([
                    'success' => true, 
                    'message' => 'Adoption request cancelled successfully',
                    'status' => 'cancelled',
                    'action' => 'user_cancelled'
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to cancel request']);
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