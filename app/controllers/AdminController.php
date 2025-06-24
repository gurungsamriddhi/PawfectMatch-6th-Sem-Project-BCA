<?php
class AdminController
{
    private function loadAdminView($filename)
    {
        include __DIR__ . '/../views/admin/' . $filename;
    }

    public function showadminloginform()
    {
        $this->loadAdminView('adminlogin.php');
    }

    public function showdashboard()
    {
        if (!isset($_SESSION['admin'])) {
            header("Location: index.php?page=admin/admin_login");
            exit();
        }
        $this->loadAdminView('dashboard.php');
    }

    public function showaddpetform()
    {
        if (!isset($_SESSION['admin'])) {
            header("Location: index.php?page=admin/admin_login");
            exit();
        }
        $this->loadAdminView('addpet.php');
    }
}
