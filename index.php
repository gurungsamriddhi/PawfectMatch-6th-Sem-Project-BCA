<?php
// index.php — Main Router

require_once 'core/databaseconn.php';
require_once 'app/controllers/HomeController.php';
require_once 'app/controllers/PetController.php';
require_once 'app/controllers/AdminController.php';

// Get 'page' from the URL like ?page=home
$page = $_GET['page'] ?? 'home';

// Route based on the value of 'page'
switch ($page) {
    case 'home':
        (new HomeController)->index();
        break;
    case 'browse':
        (new PetController)->browse();
        break;
  
    case 'admin':
        (new AdminController)->adminlogin();
        break;
    default:
        echo "404 - Page Not Found";
        break;
}
