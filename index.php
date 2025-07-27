<?php
// index.php — Main Router
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1. Load all dependencies
require_once 'core/databaseconn.php';
require_once 'app/controllers/HomeController.php';
require_once 'app/controllers/PetController.php';
require_once 'app/controllers/UserController.php';
require_once 'app/controllers/AdminController.php';
require_once 'app/controllers/DonationController.php';
require_once 'app/controllers/CenterController.php';
require_once 'app/controllers/ContactController.php';
require_once 'app/controllers/VolunteerController.php';

// 2. Start session
session_start();

// 3. Define routes centrally
$routes = [

    // Public Routes
    'home' => ['HomeController', 'index'],
    'browse' => ['PetController', 'browse'],
    'adoptionprocess' => ['HomeController', 'adoptionprocess'],
    'aboutus' => ['HomeController', 'aboutus'],
    'volunteer' => ['HomeController', 'volunteer'],
    'petdetails' => ['PetController', 'showpetdetails'],
    'login'=>['UserController', 'Login'],
    'register'=>['UserController', 'Register'],
    'donate' => ['DonateController', 'donate'],
    'user_dashboard' => ['UserController', 'dashboard'],
    'user_profile' => ['UserController', 'user_profile'],
    'update_profile' => ['UserController', 'update_profile'],
    'user_saved_pets' => ['UserController', 'user_saved_pets'],
    'user_adoption_requests' => ['UserController', 'user_adoption_requests'],
    'user_donations' => ['UserController', 'user_donations'],
    'user_messages' => ['UserController', 'user_messages'],
    'user_volunteer_status' => ['UserController', 'user_volunteer_status'],
    'login' => ['UserController', 'Login'],
    'register' => ['UserController', 'Register'],
    'donate' => ['DonationController', 'donateForm'],

    'logout' => function () {
        $wasAdmin = !empty($_SESSION['admin']);
        $wasCenter = !empty($_SESSION['adoptioncenter']);

        // Destroy session
        session_unset();
        session_destroy();

        // Decide redirect based on what the user was before logging out
        if ($wasAdmin) {
            $redirect = 'index.php?page=admin/admin_login';
        } elseif ($wasCenter) {
            $redirect = 'index.php?page=adoptioncenter/center_login';
        } else {
            $redirect = 'index.php?page=home';
        }

        header("Location: $redirect");
        exit();
    },

    // Contact Routes
    'contactus' => function () {
        header('Location: index.php?page=contactcontroller/showcontactform');
        exit();
    },
    'contactcontroller/showcontactform' => ['ContactController', 'showContactForm'],
    'contactcontroller/contactsubmit' => ['ContactController', 'contactsubmit'],
    // 'contactsubmit' => ['UserController', 'contactSubmit'],

    // Admin Routes (with admin_auth middleware)


    //volunteer routes
    'volunteer/apply' => ['VolunteerController', 'apply'],



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
    'admin/volunteer_management' => ['AdminController', 'viewVolunteerRequests', 'admin_auth'],
    'admin/reset_password' => ['AdminController', 'resetCenterPassword', 'admin_auth'],
    'admin/contact_messages' => ['AdminController', 'showContactMessages', 'admin_auth'],
    'admin/send_contact_reply' => ['AdminController', 'sendContactReply', 'admin_auth'],
    'admin/adoption_request' => ['AdminController', 'showAdoptionRequests', 'admin_auth'],
    'admin/user_view' => ['AdminController', 'user_view', 'admin_auth'],
    'admin/user_suspend' => ['AdminController', 'user_suspend', 'admin_auth'],
    'admin/user_delete' => ['AdminController', 'user_delete', 'admin_auth'],
    'admin/update_adoption_status' => ['AdminController', 'updateAdoptionStatus', 'admin_auth'],
    'admin/volunteer_view' => ['AdminController', 'volunteer_view', 'admin_auth'],
    'admin/approve_and_assign_volunteer' => ['AdminController', 'approve_and_assign_volunteer', 'admin_auth'],
    'admin/reject_volunteer_request'=> ['AdminController', 'reject_volunteer_request', 'admin_auth'],   



    // Adoption Center Routes (with center_auth middleware)
    'adoptioncenter/center_login' => ['CenterController', 'showLoginForm'],
    'adoptioncenter/verify_center' => ['CenterController', 'verify_CenterLogin'], // Method name fixed (case-sensitive)
    'adoptioncenter/center_dashboard' => ['CenterController', 'showDashboard', 'center_auth'],
    'adoptioncenter/adoptioncenter_profile' => ['CenterController', 'showprofile', 'center_auth'],
    'adoptioncenter/add_pets' => ['CenterController', 'showaddpetform', 'center_auth'],
    'adoptioncenter/addPet' => ['CenterController', 'addPet', 'center_auth'],
    'adoptioncenter/getPetById' => ['CenterController', 'getPetById', 'center_auth'],
    'adoptioncenter/updatePet' => ['CenterController', 'updatePet', 'center_auth'],
    'adoptioncenter/deletePet' => ['CenterController', 'deletePet', 'center_auth'],
    'adoptioncenter/managepets' => ['CenterController', 'managepetsform', 'center_auth'],
    'adoptioncenter/update_profile' => ['CenterController', 'update_profile', 'center_auth'],
    'adoptioncenter/change_password' => ['CenterController', 'change_password', 'center_auth'],
    'adoptioncenter/savePets' => ['CenterController', 'savePets', 'center_auth'],
    'adoptioncenter/editpets' => ['CenterController', 'editpets', 'center_auth'],
    'adoptioncenter/deletepet' => ['CenterController', 'deletepet', 'center_auth'],
    'adoptioncenter/adoption_request' => ['CenterController', 'adoption_request', 'center_auth'],
    'adoptioncenter/feedback' => ['CenterController', 'feedback', 'center_auth'],
    'adoptioncenter/view_volunteers' => ['CenterController', 'viewAssignedVolunteers', 'center_auth'],
    'adoptioncenter/volunteer_view'=> ['CenterController', 'viewVolunteer', 'center_auth'],
];

// 4. Get current page requested
$page = $_GET['page'] ?? 'home';
$current_page = $page; // can be used in views/header

// 5. Route handling logic
if (isset($routes[$page])) {
    $route = $routes[$page];

    // If route is a closure (callable), execute directly
    if (is_callable($route)) {
        $route();
        exit();
    }

    // Else it's [Controller, Method, Middleware?]
    list($controller, $method, $middleware) = array_pad($route, 3, null);

    // Check middleware
    if ($middleware === 'admin_auth' && empty($_SESSION['admin'])) {
        header("Location: index.php?page=admin/admin_login");
        exit;
    }

    if ($middleware === 'center_auth' && empty($_SESSION['adoptioncenter'])) {
        header("Location: index.php?page=adoptioncenter/center_login");
        exit;
    }



    // Instantiate controller and call method
    (new $controller)->$method();
    exit();
} else {
    // 404 fallback
    header("HTTP/1.0 404 Not Found");
    echo "404 - Page Not Found";
    exit();
}
