<?php
require_once 'core/databaseconn.php';

echo "=== DEBUGGING PETS DATABASE ===\n\n";

try {
    $db = new Database();
    $conn = $db->connect();
    
    echo "Database connection successful!\n\n";
    
    // Check if pets table exists
    $result = $conn->query("SHOW TABLES LIKE 'pets'");
    if ($result->num_rows > 0) {
        echo "Pets table exists!\n\n";
    } else {
        echo "Pets table does not exist!\n\n";
        exit;
    }
    
    // Get total count of pets
    $result = $conn->query("SELECT COUNT(*) as total FROM pets");
    $count = $result->fetch_assoc()['total'];
    echo "Total pets in database: " . $count . "\n\n";
    
    // Get pets with status filter
    $result = $conn->query("SELECT COUNT(*) as total FROM pets WHERE status = 'available'");
    $available = $result->fetch_assoc()['total'];
    echo "Pets with status 'available': " . $available . "\n\n";
    
    // Show all pets
    $result = $conn->query("SELECT pet_id, name, status, posted_by, adoption_center FROM pets ORDER BY created_at DESC LIMIT 10");
    echo "Recent pets:\n";
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row['pet_id'] . " - Name: " . $row['name'] . " - Status: " . $row['status'] . " - Posted by: " . $row['posted_by'] . " - Center: " . $row['adoption_center'] . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?> 