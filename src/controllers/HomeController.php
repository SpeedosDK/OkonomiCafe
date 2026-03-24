<?php
class HomeController {
    public function index() {
        include __DIR__ . '/../../views/layouts/header.php';
        include __DIR__ . '/../../views/home.php';
        include __DIR__ . '/../../views/layouts/footer.php';
    }
    public function saadan(){
        include __DIR__ . '/../../views/layouts/header.php';
        include __DIR__ . '/../../views/saadan-virker-det.php';
        include __DIR__ . '/../../views/layouts/footer.php';
    }
    public function forDig(){
        include __DIR__ . '/../../views/layouts/header.php';
        include __DIR__ . '/../../views/for-dig.php';
        include __DIR__ . '/../../views/layouts/footer.php';
    }
    public function frivillig(){
        include __DIR__ . '/../../views/layouts/header.php';
        include __DIR__ . '/../../views/frivillig.php';
        include __DIR__ . '/../../views/layouts/footer.php';
    }
    public function kontakt(){
        include __DIR__ . '/../../views/layouts/header.php';
        include __DIR__ . '/../../views/kontakt.php';
        include __DIR__ . '/../../views/layouts/footer.php';
    }
    public function kalender(){
        $year = isset($_GET['year']) ? (int)$_GET['year'] : (int)date('Y');
        $month = isset($_GET['month']) ? (int)$_GET['month'] : (int)date('n');

        if ($month < 1) { $month = 12; $year--; }
        if ($month > 12) { $month = 1; $year++; }

        $data = [
            'year' => $year,
            'month' => $month,
        ];

        extract($data);

        include __DIR__ . '/../../views/layouts/header.php';
        include __DIR__ . '/../../views/kalender.php';
        include __DIR__ . '/../../views/layouts/footer.php';
    }
}


