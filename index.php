<?php
// index.php — Main Router (Improved but still simple)

// 1. Load all dependencies
require_once 'core/databaseconn.php';
require_once 'app/controllers/HomeController.php';
require_once 'app/controllers/PetController.php';
require_once 'app/controllers/UserController.php';
require_once 'app/controllers/AdminController.php';
require_once 'app/controllers/DonateController.php';
require_once 'app/controllers/CenterController.php';
require_once 'app/controllers/ContactController.php';

// 2. Start session
session_start();

// 3. Define routes in a cleaner way (but still in this file)
$routes = [
    // Public Routes
    'home' => ['HomeController', 'index'],
    'browse' => ['PetController', 'browse'],
    'adoptionprocess' => ['HomeController', 'adoptionprocess'],
    'aboutus' => ['HomeController', 'aboutus'],
    'volunteer' => ['HomeController', 'volunteer'],
    'petdetails' => ['PetController', 'showpetdetails'],
    'donate' => ['DonateController', 'donate'],
    
    'logout' => function () {
    $redirect = 'index.php?page=home'; // default

    if (!empty($_SESSION['admin'])) {
        $redirect = 'index.php?page=admin/admin_login';
    } elseif (!empty($_SESSION['center'])) {
        $redirect = 'index.php?page=adoptioncenter/center_login';
    }

    session_unset();
    session_destroy();
    header("Location: $redirect");
    exit();
},

    
    // Contact Routes
    'contactus' => function() {
        header('Location: index.php?page=contactcontroller/showcontactform');
        exit();
    },
    'contactcontroller/showcontactform' => ['ContactController', 'showContactForm'],
    'contactcontroller/contactsubmit' => ['ContactController', 'contactsubmit'],
    'contactsubmit' => ['UserController', 'contactSubmit'],
    
    // Admin Routes
    'admin/admin_login' => ['AdminController', 'showadminloginform'],
    'admin/verify_admin' => ['AdminController', 'verify_adminLogin'],
    'admin/admin_dashboard' => ['AdminController', 'showdashboard', 'admin_auth'],
    'admin/addpet' => ['AdminController', 'showaddpetform', 'admin_auth'],
    'admin/addPet' => ['AdminController', 'addPet', 'admin_auth'],
    'admin/getPetById' => ['AdminController', 'getPetById', 'admin_auth'],
    'admin/updatePet' => ['AdminController', 'updatePet', 'admin_auth'],
    'admin/deletePet' => ['AdminController', 'deletePet', 'admin_auth'],
    'admin/PetManagement' => ['AdminController', 'ManagePets', 'admin_auth'],
    'admin/CenterManagement' => ['AdminController', 'ManageCenters', 'admin_auth'],
    'admin/fetch_center_details' => ['AdminController', 'fetch_center_details', 'admin_auth'],
    'admin/fetch_edit_form' => ['AdminController', 'fetch_edit_form', 'admin_auth'],
    'admin/add_centerform' => ['AdminController', 'showaddcenterform', 'admin_auth'],
    'admin/update_center_user' => ['AdminController', 'update_center_user', 'admin_auth'],
    'admin/delete_center_user' => ['AdminController', 'delete_center_user', 'admin_auth'],
    'admin/add_Center' => ['AdminController', 'addAdoptionCenter', 'admin_auth'],
    'admin/userManagement' => ['AdminController', 'ManageUsers', 'admin_auth'],
    'admin/reset_password' => ['AdminController', 'resetCenterPassword', 'admin_auth'],
    
    // Center Routes
    'adoptioncenter/center_login' => ['CenterController', 'showLoginForm'],
    'adoptioncenter/center_dashboard' => ['CenterController', 'showDashboard', 'center_auth'],
    'adoptioncenter/adoptioncenter_profile' => ['CenterController', 'showprofile', 'center_auth'],
    'adoptioncenter/add_pets' => ['CenterController', 'showaddpetform', 'center_auth'],
    'adoptioncenter/addPet' => ['CenterController', 'addPet', 'center_auth'],
    'adoptioncenter/getPetById' => ['CenterController', 'getPetById', 'center_auth'],
    'adoptioncenter/updatePet' => ['CenterController', 'updatePet', 'center_auth'],
    'adoptioncenter/deletePet' => ['CenterController', 'deletePet', 'center_auth'],
    'adoptioncenter/managepets' => ['CenterController', 'managepetsform', 'center_auth'],
];

// 4. Get current page
$page = $_GET['page'] ?? 'home';
$current_page = $page; // For use in header.php

// 5. Route handling
if (isset($routes[$page])) {
    $route = $routes[$page];
    
    // Handle closures (like logout)
    if (is_callable($route)) {
        $route();
        exit;
    }
    
    // Handle controller methods
    list($controller, $method, $middleware) = array_pad($route, 3, null);
    
    // Check middleware
    if ($middleware === 'admin_auth' && empty($_SESSION['admin'])) {
        header("Location: index.php?page=admin/admin_login");
        exit;
    }
    
    if ($middleware === 'center_auth' && empty($_SESSION['center'])) {
        header("Location: index.php?page=adoptioncenter/center_login");
        exit;
    }
    
    // Call the controller method
    (new $controller)->$method();
} else {
    // 404 Page
    echo "404 - Page Not Found";
}
?>

</html>