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
    $has_other_pets = $_POST['has_other_pets'];

    if (!$user_id) {
        error_log('SESSION: ' . print_r($_SESSION, true));
        echo json_encode(['success' => false, 'message' => 'Not logged in', 'session' => $_SESSION]);
        exit;
    }

    $db = new Database();
    $conn = $db->connect();
    $stmt = $conn->prepare("INSERT INTO adoption_form (request_id, user_id, pet_id, address, phone, reason, preferred_date, home_type, has_other_pets) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissssss", $user_id, $pet_id, $address, $phone, $reason, $preferred_date, $home_type, $has_other_pets);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
    }
    exit;
}
echo json_encode(['success' => false, 'message' => 'Handler not reached or wrong request']);
exit;

echo "<h2>Database Debug Information</h2>";

// Test database connection
try {
    $db = new Database();
    $conn = $db->connect();
    echo "<p><strong>Database Connection:</strong> " . ($conn ? "SUCCESS" : "FAILED") . "</p>";
    
    if ($conn) {
        // Check if pets table exists
        $result = $conn->query("SHOW TABLES LIKE 'pets'");
        echo "<p><strong>Pets Table:</strong> " . ($result->num_rows > 0 ? "EXISTS" : "NOT FOUND") . "</p>";
        
        if ($result->num_rows > 0) {
            // Show table structure
            $result = $conn->query("DESCRIBE pets");
            echo "<h3>Pets Table Structure:</h3><ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . $row['Field'] . " (" . $row['Type'] . ")</li>";
            }
            echo "</ul>";
            
            // Count pets
            $result = $conn->query("SELECT COUNT(*) as count FROM pets");
            $row = $result->fetch_assoc();
            echo "<p><strong>Total Pets:</strong> " . $row['count'] . "</p>";
        }
        
        // Check users table
        $result = $conn->query("SHOW TABLES LIKE 'users'");
        echo "<p><strong>Users Table:</strong> " . ($result->num_rows > 0 ? "EXISTS" : "NOT FOUND") . "</p>";
        
        if ($result->num_rows > 0) {
            $result = $conn->query("SELECT COUNT(*) as count FROM users WHERE user_type = 'admin'");
            $row = $result->fetch_assoc();
            echo "<p><strong>Admin Users:</strong> " . $row['count'] . "</p>";
        }
    }
    
} catch (Exception $e) {
    echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>";
}

// Check session
echo "<h3>Session Information:</h3>";
echo "<p><strong>Session ID:</strong> " . session_id() . "</p>";
echo "<p><strong>Session Data:</strong></p>";
echo "<pre>" . print_r($_SESSION, true) . "</pre>";

// Test Pet model
echo "<h3>Pet Model Test:</h3>";
try {
    $petModel = new Pet();
    $pets = $petModel->getAllPetsForAdmin();
    echo "<p><strong>Pet Model Test:</strong> SUCCESS - Found " . count($pets) . " pets</p>";
} catch (Exception $e) {
    echo "<p><strong>Pet Model Error:</strong> " . $e->getMessage() . "</p>";
}
?> 