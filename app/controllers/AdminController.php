<?php
class AdminController
{
    private function loadAdminView($filename)
    {
        include __DIR__ . '/../../admin/views/' . $filename;
    }
    public function showadminloginform()
    {
       $this->loadAdminView('adminlogin.php');
    }
    public function showdashboard()
    {
        $this->loadAdminView('dashboard.php');
    }
    public function showaddpetform()
    {
          $this->loadAdminView('addpet.php');
    }
}
