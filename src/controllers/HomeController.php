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
    public function loginForm(){
        $error = $_GET['error'] ?? null;

        include __DIR__ . '/../../views/layouts/header.php';
        include __DIR__ . '/../../views/login.php';
        include __DIR__ . '/../../views/layouts/footer.php';
    }


    public function login(){
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $users = include __DIR__ . '/../../data/users.php';

        foreach($users as $user){
            if ($user['username'] === $username && password_verify($password, $user['password'])){
                $_SESSION['username'] = $user['username'];
                header('Location: /kalender-admin');
                exit;
            }
        }
        header('Location: /login?error=1');
        exit;
    }
    public function kalenderAdmin() {
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
        include __DIR__ . '/../../views/kalender-admin.php';
        include __DIR__ . '/../../views/layouts/footer.php';
    }


    public function logout(){
        session_start();
        session_destroy();
        header('Location: /');
        exit;
    }
    public function saveShift() {
        $date = $_POST['date'] ?? null;
        $name = $_POST['name'] ?? null;
        $expertise = $_POST['expertise'] ?? null;

        if (!$date || !$name || !$expertise) {
            header("Location: /kalender-admin?error=1");
            exit;
        }

        require_once __DIR__ . '/../../core/Database.php';
        $db = Database::getConnection();

        $stmt = $db->prepare("INSERT INTO shifts (date, name, expertise) VALUES (?, ?, ?)");
        $stmt->execute([$date, $name, $expertise]);

        header("Location: /kalender-admin?success=1");
        exit;
    }


}


