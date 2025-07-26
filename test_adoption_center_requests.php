<?php
require_once 'core/databaseconn.php';
require_once 'app/models/Adoption.php';

$db = new Database();
$conn = $db->connect();
$adoptionModel = new Adoption($conn);

echo "=== TESTING ADOPTION CENTER REQUESTS ===\n\n";

// Test with a sample center ID (you can change this to test with different centers)
$testCenterId = 1; // Change this to test with different centers

echo "Testing with center ID: $testCenterId\n\n";

// Get requests for this center
$requests = $adoptionModel->getFormsByCenter($testCenterId);

echo "Total requests found: " . count($requests) . "\n\n";

if (count($requests) > 0) {
    echo "Requests details:\n";
    foreach($requests as $request) {
        echo "Form ID: " . $request['form_id'] . "\n";
        echo "Pet: " . $request['pet_name'] . " (" . $request['pet_type'] . ", " . $request['breed'] . ")\n";
        echo "Requester: " . $request['requester_name'] . " (" . $request['requester_email'] . ")\n";
        echo "Phone: " . $request['phone'] . "\n";
        echo "Date: " . $request['preferred_date'] . "\n";
        echo "Image: " . $request['image_path'] . "\n";
        echo "---\n";
    }
} else {
    echo "No requests found for this center.\n";
}

// Also check what pets this center has posted
echo "\n=== PETS POSTED BY THIS CENTER ===\n";
$sql = "SELECT pet_id, name, type, breed, posted_by FROM pets WHERE posted_by = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $testCenterId);
$stmt->execute();
$result = $stmt->get_result();
$pets = $result->fetch_all(MYSQLI_ASSOC);

echo "Total pets posted by center $testCenterId: " . count($pets) . "\n";
foreach($pets as $pet) {
    echo "Pet ID: " . $pet['pet_id'] . " - " . $pet['name'] . " (" . $pet['type'] . ", " . $pet['breed'] . ")\n";
}

// Check if there are any adoption forms for these pets
if (count($pets) > 0) {
    $petIds = array_column($pets, 'pet_id');
    $petIdsStr = implode(',', $petIds);
    
    echo "\n=== ADOPTION FORMS FOR THESE PETS ===\n";
    $sql = "SELECT af.form_id, af.pet_id, u.name as requester_name, p.name as pet_name 
            FROM adoption_form af 
            JOIN users u ON af.user_id = u.user_id 
            JOIN pets p ON af.pet_id = p.pet_id 
            WHERE af.pet_id IN ($petIdsStr)";
    $result = $conn->query($sql);
    $forms = $result->fetch_all(MYSQLI_ASSOC);
    
    echo "Total adoption forms for these pets: " . count($forms) . "\n";
    foreach($forms as $form) {
        echo "Form ID: " . $form['form_id'] . " - Pet: " . $form['pet_name'] . " - Requester: " . $form['requester_name'] . "\n";
    }
}
?> 