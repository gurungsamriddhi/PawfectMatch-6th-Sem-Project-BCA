<?php
session_start();
require_once 'core/databaseconn.php';
require_once 'app/models/Pet.php';

header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$userId = $_SESSION['user']['id'];
$db = new Database();
$conn = $db->connect();
$petModel = new Pet($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $petId = intval($_POST['pet_id'] ?? 0);

    // Only require pet_id for actions that need it
    if ($action !== 'check_all' && !$petId) {
        echo json_encode(['success' => false, 'message' => 'Invalid pet ID']);
        exit;
    }

    switch ($action) {
        case 'add':
            if ($petModel->addToWishlist($userId, $petId)) {
                echo json_encode(['success' => true, 'message' => 'Added to wishlist']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to add to wishlist']);
            }
            break;

        case 'remove':
            if ($petModel->removeFromWishlist($userId, $petId)) {
                echo json_encode(['success' => true, 'message' => 'Removed from wishlist']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to remove from wishlist']);
            }
            break;

        case 'toggle':
            if ($petModel->isInWishlist($userId, $petId)) {
                // Remove from wishlist
                if ($petModel->removeFromWishlist($userId, $petId)) {
                    echo json_encode(['success' => true, 'action' => 'removed', 'message' => 'Removed from wishlist']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to remove from wishlist']);
                }
            } else {
                // Add to wishlist
                if ($petModel->addToWishlist($userId, $petId)) {
                    echo json_encode(['success' => true, 'action' => 'added', 'message' => 'Added to wishlist']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to add to wishlist']);
                }
            }
            break;

        case 'check':
            $isInWishlist = $petModel->isInWishlist($userId, $petId);
            echo json_encode(['success' => true, 'in_wishlist' => $isInWishlist]);
            break;

        case 'check_all':
            $wishlist = $petModel->getSavedByUser($userId);
            echo json_encode(['success' => true, 'wishlist' => $wishlist]);
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
            break;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?> 