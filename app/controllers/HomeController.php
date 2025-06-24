<?php
class HomeController {
    public function index() {
        include 'app/views/home.php';
    }
    public function aboutus(){
        include 'app/views/aboutus.php';

    }
    public function contactus(){
        include 'app/views/contactus.php';
    }
    public function adoptionprocess(){
         include 'app/views/adoptionprocess.php';
    }
    public function volunteer() {
        include 'app/views/volunteer.php';
}

}
