<?php
require_once 'core/databaseconn.php';
require_once 'app/models/Pet.php';

$db = new Database();
$conn = $db->connect();
$petModel = new Pet($conn);

// Get pets from database (same as browse page)
$pets = $petModel->getAllPets();

// Convert to JSON for JavaScript (same as browse page)
$petsJson = json_encode($pets);

echo "=== TESTING BROWSE PAGE DATA ===\n\n";
echo "Total pets from getAllPets(): " . count($pets) . "\n\n";

echo "Pets data:\n";
foreach($pets as $pet) {
    echo "ID: " . $pet['pet_id'] . " - Name: " . $pet['name'] . " - Status: " . $pet['status'] . " - Posted by: " . $pet['posted_by'] . " - Center: " . $pet['adoption_center'] . "\n";
}

echo "\nJSON data length: " . strlen($petsJson) . "\n";
echo "JSON data (first 500 chars): " . substr($petsJson, 0, 500) . "\n";

// Also check raw database query
echo "\n=== RAW DATABASE QUERY ===\n";
$query = "SELECT * FROM pets WHERE status = 'available' ORDER BY created_at DESC";
$result = $conn->query($query);
$rawPets = $result->fetch_all(MYSQLI_ASSOC);

echo "Raw query pets count: " . count($rawPets) . "\n";
foreach($rawPets as $pet) {
    echo "ID: " . $pet['pet_id'] . " - Name: " . $pet['name'] . " - Status: " . $pet['status'] . " - Posted by: " . $pet['posted_by'] . " - Center: " . $pet['adoption_center'] . "\n";
}
?> 