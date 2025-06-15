 <?php
    // index.php — Main Router

    require_once 'core/databaseconn.php';
    require_once 'app/controllers/HomeController.php';
    require_once 'app/controllers/PetController.php';
    require_once 'app/controllers/UserController.php';
    require_once 'app/controllers/AdminController.php';

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
            (new UserController)->showRegisterForm();
            break;
        case 'volunteer':
            (new HomeController)->volunteer();
            break;
        default:
            echo "404 - Page Not Found";
            break;
    }
    ?>

 </html>