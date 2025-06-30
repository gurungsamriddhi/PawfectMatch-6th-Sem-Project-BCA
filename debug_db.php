<?php
session_start();
require_once 'core/databaseconn.php';
require_once 'app/models/Pet.php';

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