<?php
require_once '../core/databaseconn.php';
require_once '../app/controllers/AdminController.php';

$page = $_GET['page'] ?? 'dashboard';

switch ($page) {
    case 'adminlogin':
         (new AdminController)->showadminloginform();
        break;
    case 'dashboard':
        (new AdminController)->showdashboard();
        break;
    case 'addpet':
        (new AdminController)->showAddPetForm();
        break;
   
    // ... more admin routes
    default:
        echo "404 - Admin Page Not Found";
}
?>