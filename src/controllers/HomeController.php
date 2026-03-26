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


    public function login() {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        require_once __DIR__ . '/../../models/User.php';

        $user = User::findByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            header('Location: /kalender-admin');
            exit;
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
        require_once __DIR__ . '/../../models/Shift.php';

        $date = $_POST['date'];
        $name = $_POST['name'];
        $expertise = $_POST['expertise'];

        Shift::create($date, $name, $expertise);

        header("Location: /kalender-admin");
        exit;
    }
    public function deleteShift() {
        require_once __DIR__ . '/../../models/Shift.php';

        $id = $_POST['id'];
        Shift::delete($id);

        header("Location: /kalender-admin");
        exit;
    }
    public function updateShift() {
        require_once __DIR__ . '/../../models/Shift.php';

        $id = $_POST['id'];
        $name = $_POST['name'];
        $expertise = $_POST['expertise'];

        Shift::update($id, $name, $expertise);

        header("Location: /kalender-admin");
        exit;
    }

}


