<?php
require_once __DIR__ . '/../../core/databaseconn.php';
require_once __DIR__ . '/../models/Admin.php';
require_once __DIR__ . '/../models/AdoptionCenter.php';
require_once __DIR__ . '/../models/Pet.php';
require_once __DIR__ . '/../models/User.php';

class AdoptionController{
    private $AdoptionModel;
    

    public function __construct()
    { 
        $db=new Database();
        $conn=$db->connect();
        $this->AdoptionModel = new Adoption($conn); // inject once
    }



}
?>