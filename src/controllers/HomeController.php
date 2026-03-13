<?php
class HomeController {
    public function index() {
        include __DIR__ . '/../../views/layouts/header.php';
        include __DIR__ . '/../../views/home.php';
        include __DIR__ . '/../../views/layouts/footer.php';
    }
}


