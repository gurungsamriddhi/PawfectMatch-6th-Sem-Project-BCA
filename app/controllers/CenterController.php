<?php
class CenterController
{
    private function loadCenterView($filename)
    {
        include __DIR__ . '/../views/adoptioncenter/' . $filename;
    }

    public function showLoginForm()
    {
        $this->loadCenterView('center_login.php');
    }

    public function showDashboard()
    {
       
        $this->loadCenterView('center_dashboard.php');
    }
}
