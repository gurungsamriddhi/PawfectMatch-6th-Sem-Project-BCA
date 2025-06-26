<?php
class CenterController
{
    private function loadCenterView($filename)
    {
        include __DIR__ . '/../views/adoptioncenter/' . $filename;
    }

    public function showLoginForm()
    {
        // If already logged in, redirect to dashboard
        if (isset($_SESSION['adoptioncenter'])) {
            header("Location: index.php?page=adoptioncenter/center_dashboard");
            exit();
        }

        // Otherwise, show login form
        $this->loadCenterView('center_login.php');
    }

    public function showDashboard()
    {
        // Check if logged in
        if (!isset($_SESSION['adoptioncenter'])) {
            header("Location: index.php?page=adoptioncenter/center_login");
            exit();
        }

        // Optional: remove the debug message
        // echo "Dashboard loaded"; exit;

        $this->loadCenterView('center_dashboard.php');
    }
}
