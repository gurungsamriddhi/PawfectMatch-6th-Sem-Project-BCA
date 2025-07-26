<?php
require_once 'core/databaseconn.php';
require_once 'app/models/Adoption.php';

$db = new Database();
$conn = $db->connect();
$adoptionModel = new Adoption($conn);

echo "=== TESTING ADOPTION REQUEST STATUS ===\n\n";

// Test admin getAllForms
echo "=== ADMIN DASHBOARD FORMS ===\n";
$adminForms = $adoptionModel->getAllForms();
echo "Total forms: " . count($adminForms) . "\n";

if (count($adminForms) > 0) {
    echo "\nForm details:\n";
    foreach($adminForms as $form) {
        echo "Form ID: " . $form['form_id'] . "\n";
        echo "Request ID: " . $form['request_id'] . "\n";
        echo "Status: " . ($form['request_status'] ?? 'NULL') . "\n";
        echo "Pet: " . $form['pet_name'] . "\n";
        echo "Requester: " . $form['requester_name'] . "\n";
        echo "---\n";
    }
}

// Test center forms
echo "\n=== ADOPTION CENTER FORMS ===\n";
$centerId = 1; // Change this to test with different centers
$centerForms = $adoptionModel->getFormsByCenter($centerId);
echo "Total forms for center $centerId: " . count($centerForms) . "\n";

if (count($centerForms) > 0) {
    echo "\nForm details:\n";
    foreach($centerForms as $form) {
        echo "Form ID: " . $form['form_id'] . "\n";
        echo "Request ID: " . $form['request_id'] . "\n";
        echo "Status: " . ($form['request_status'] ?? 'NULL') . "\n";
        echo "Pet: " . $form['pet_name'] . "\n";
        echo "Requester: " . $form['requester_name'] . "\n";
        echo "---\n";
    }
}

// Check adoption_requests table directly
echo "\n=== ADOPTION REQUESTS TABLE ===\n";
$sql = "SELECT ar.request_id, ar.request_status, af.form_id, u.name as requester_name, p.name as pet_name 
        FROM adoption_requests ar 
        LEFT JOIN adoption_form af ON ar.request_id = af.request_id 
        LEFT JOIN users u ON af.user_id = u.user_id 
        LEFT JOIN pets p ON af.pet_id = p.pet_id 
        ORDER BY ar.request_id DESC";
$result = $conn->query($sql);
$requests = $result->fetch_all(MYSQLI_ASSOC);

echo "Total adoption requests: " . count($requests) . "\n";
foreach($requests as $request) {
    echo "Request ID: " . $request['request_id'] . " - Status: " . $request['request_status'] . " - Form ID: " . $request['form_id'] . " - Pet: " . $request['pet_name'] . " - Requester: " . $request['requester_name'] . "\n";
}
?> 