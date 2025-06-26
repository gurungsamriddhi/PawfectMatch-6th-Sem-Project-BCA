 <?php
    // index.php — Main Router

    require_once 'core/databaseconn.php';
    require_once 'app/controllers/HomeController.php';
    require_once 'app/controllers/PetController.php';
    require_once 'app/controllers/UserController.php';
    require_once 'app/controllers/AdminController.php';
    require_once 'app/controllers/DonateController.php';
    require_once 'app/controllers/CenterController.php';

    // Start session (important for logout)
    //session is used to keep track of user data cross multiple page requests(since http itself is stateless) called once at the top of every php file that uses session variables
    session_start();

    // Get 'page' from the URL like ?page=home
    $page = $_GET['page'] ?? 'home';
    $current_page = $page; // set this for use in header.php
    // Route based on the value of 'page'
    switch ($page) {
        case 'home':
            (new HomeController)->index();
            break;
        case 'browse':
            (new PetController)->browse();
            break;
        case 'adoptionprocess':
            (new HomeController)->adoptionprocess();
            break;
        case 'aboutus':
            (new HomeController)->aboutus();
            break;
        case 'contactus':
            (new HomeController)->contactus();
            break;
        case 'register':
            (new UserController)->Register();
            break;

        case 'volunteer':
            (new HomeController)->volunteer();
            break;

        case 'petdetails':
            (new PetController)->showpetdetails();
            break;
        case 'donate':
            (new DonateController)->donate();
            break;
        case 'login':
            (new UserController)->Login(); // call Login() method in UserController
            break;



        // ✅ Admin Pages
        case 'admin/admin_login':
            (new AdminController)->showadminloginform();
            break;

<<<<<<< HEAD
=======
        case 'admin/verify_admin':
            (new AdminController)->verify_adminLogin();
            break;
>>>>>>> d9037b53744a851365af4eb16967bdea5c049918
        case 'admin/admin_dashboard':
            (new AdminController)->showdashboard();
            break;

        case 'admin/addpet':
            (new AdminController)->showaddpetform();
            break;
        case 'admin/PetManagement':
            (new AdminController)->ManagePets();
            break;
        case 'admin/adoptionManagement':
            (new AdminController)-> ManageAdoption();
            break;



        // ✅ Adoption Center Pages (example controller)
        case 'adoptioncenter/center_login':
<<<<<<< HEAD
            (new CenterController)->showLoginForm();
=======
            (new centerController)->showLoginForm();
>>>>>>> d9037b53744a851365af4eb16967bdea5c049918
            break;

        case 'adoptioncenter/center_dashboard':
<<<<<<< HEAD
            (new CenterController)->showDashboard();
            break;

        case 'adoptioncenter/adoptioncenter_profile':
            (new CenterController)->showprofile();
            break;

        case 'adoptioncenter/add_pets':
            (new CenterController)->showaddpetform();
            break;

      case 'adoptioncenter/managepets':
            (new CenterController)->managepetsform();
=======
            (new centerController)->showDashboard();
>>>>>>> d9037b53744a851365af4eb16967bdea5c049918
            break;

        case 'logout':
            session_unset();
            session_destroy();
            header('Location: index.php?page=home');
            exit();
            break;

        default:
            echo "404 - Page Not Found";
            break;
    }
    ?>

 </html>