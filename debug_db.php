<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
file_put_contents(__DIR__.'/debug.log', date('c')."\nPOST: ".print_r($_POST, true)."SESSION: ".print_r($_SESSION, true)."\n", FILE_APPEND);
session_start();
require_once 'core/databaseconn.php';
require_once 'app/models/Pet.php';

// Handle adoption request form submission
echo "<!-- Handler reached -->\n";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pet_id'])) {
    header('Content-Type: application/json');
    $user_id = $_SESSION['user']['id'] ?? null;
    $pet_id = $_POST['pet_id'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $reason = $_POST['reason'];
    $preferred_date = $_POST['preferred_date'];
    $home_type = $_POST['home_type'];
    $has_other_pets = ($_POST['has_other_pets'] === 'Yes') ? 1 : 0;

    if (!$user_id) {
        error_log('SESSION: ' . print_r($_SESSION, true));
        echo json_encode(['success' => false, 'message' => 'Not logged in', 'session' => $_SESSION]);
        exit;
    }

    $db = new Database();
    $conn = $db->connect();

    // 1. Check if adoption_requests row exists
    $request_id = null;
    $check = $conn->prepare("SELECT request_id FROM adoption_requests WHERE user_id = ? AND pet_id = ?");
    if (!$check) {
        error_log('Prepare failed (check request): ' . $conn->error);
        echo json_encode(['success' => false, 'message' => 'Prepare failed (check request): ' . $conn->error]);
        exit;
    }
    $check->bind_param("ii", $user_id, $pet_id);
    $check->execute();
    $check->bind_result($request_id);
    if ($check->fetch()) {
        // Found existing request_id
        $check->close();
    } else {
        $check->close();
        // Insert new adoption_requests row
        $insert_req = $conn->prepare("INSERT INTO adoption_requests (user_id, pet_id) VALUES (?, ?)");
        if (!$insert_req) {
            error_log('Prepare failed (insert request): ' . $conn->error);
            echo json_encode(['success' => false, 'message' => 'Prepare failed (insert request): ' . $conn->error]);
            exit;
        }
        $insert_req->bind_param("ii", $user_id, $pet_id);
        if (!$insert_req->execute()) {
            error_log('Execute failed (insert request): ' . $insert_req->error);
            echo json_encode(['success' => false, 'message' => 'Database error (insert request): ' . $insert_req->error]);
            exit;
        }
        $request_id = $insert_req->insert_id;
        $insert_req->close();
    }

    // 2. Insert into adoption_form with the request_id
    $stmt = $conn->prepare("INSERT INTO adoption_form (request_id, user_id, pet_id, address, phone, reason, preferred_date, home_type, has_other_pets) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        error_log('Prepare failed: ' . $conn->error);
        echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
        exit;
    }
    $ok = $stmt->bind_param("iiisssssi", $request_id, $user_id, $pet_id, $address, $phone, $reason, $preferred_date, $home_type, $has_other_pets);
    if (!$ok) {
        error_log('Bind param failed: ' . $stmt->error);
        echo json_encode(['success' => false, 'message' => 'Bind param failed: ' . $stmt->error]);
        exit;
    }
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        error_log('Execute failed: ' . $stmt->error);
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
    }
    exit;
}

echo json_encode(['success' => false, 'message' => 'Handler not reached or wrong request']);
exit; 