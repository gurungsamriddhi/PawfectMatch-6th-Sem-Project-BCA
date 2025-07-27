
<?php
require_once __DIR__ . '/../models/Pet.php';
require_once __DIR__ . '/../../core/databaseconn.php';

class HomeController
{
    public function index()
    {
        // Fetch recent available pets for the home page
        $db = new Database();
        $conn = $db->connect();
        $petModel = new Pet($conn);

        // Get 3 recent available pets
        $recentPets = $petModel->getRecentAvailablePets(3);

        // Get some basic statistics for the home page
        $stats = [
            'total_available_pets' => 0,
            'total_adopted_pets' => 0,
            'total_pets' => 0
        ];

        // Count available pets
        $result = $conn->query("SELECT COUNT(*) as count FROM pets WHERE status = 'available'");
        if ($result) {
            $row = $result->fetch_assoc();
            $stats['total_available_pets'] = $row['count'];
        }

        // Count adopted pets
        $result = $conn->query("SELECT COUNT(*) as count FROM pets WHERE status = 'adopted'");
        if ($result) {
            $row = $result->fetch_assoc();
            $stats['total_adopted_pets'] = $row['count'];
        }

        // Count total pets
        $result = $conn->query("SELECT COUNT(*) as count FROM pets");
        if ($result) {
            $row = $result->fetch_assoc();
            $stats['total_pets'] = $row['count'];
        }

        include 'app/views/home.php';
    }
    public function aboutus()
    {
        include 'app/views/aboutus.php';
    }
    public function contactus()
    {
        include 'app/views/contactus.php';
    }
    public function adoptionprocess()
    {
        include 'app/views/adoptionprocess.php';
    }
    public function volunteer()
    {
        include 'app/views/volunteer_form.php';
    }
}
