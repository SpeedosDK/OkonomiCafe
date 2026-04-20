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
        session_destroy();
        header('Location: /');
        exit;
    }
    public function saveShift() {
        require_once __DIR__ . '/../../models/Shift.php';
        require_once __DIR__ . '/../../models/ShiftUser.php';

        $date = $_POST['date'];
        $expertise = $_POST['expertise'];
        $userIds = $_POST['user_ids']; // array

        $shiftId = Shift::create($date, $expertise);

        foreach ($userIds as $uid) {
            ShiftUser::assign($shiftId, $uid);
        }

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
        require_once __DIR__ . '/../../models/ShiftUser.php';

        $id = $_POST['id'];
        $expertise = $_POST['expertise'];
        $userIds = $_POST['user_ids']; // array

        Shift::update($id, $expertise);

        // Fjern gamle brugere
        ShiftUser::deleteAllForShift($id);

        // Tilføj nye
        foreach ($userIds as $uid) {
            ShiftUser::assign($id, $uid);
        }

        header("Location: /kalender-admin");
        exit;
    }

    public function saveMessage() {
        require_once __DIR__ . '/../../models/Message.php';

        $name = $_POST['navn'];
        $email = $_POST['email'];
        $message = $_POST['besked'];

        Message::create($name, $email, $message);

        header("Location: /kontakt?sent=1");
        exit;
    }
    public function messages() {
        require_once __DIR__ . '/../../models/Message.php';

        $messages = Message::all(); // ← HENTER BESKEDERNE

        include __DIR__ . '/../../views/layouts/header.php';
        include __DIR__ . '/../../views/messages.php';
        include __DIR__ . '/../../views/layouts/footer.php';
    }


    public function messageRead() {
        require_once __DIR__ . '/../../models/Message.php';

        $id = $_POST['id'];
        Message::markAsRead($id);

        header("Location: /messages");
        exit;
    }

    public function messageReply() {
        require_once __DIR__ . '/../../models/Message.php';

        $id = $_POST['id'];
        $reply = $_POST['reply'];

        Message::addReply($id, $reply);

        $message = Message::find($id);

        error_log("TEST-MAIL TIL: {$message['email']}");
        error_log("EMNE: Svar på din besked til Økonomi-Caféen");
        error_log("INDHOLD:\n$reply");

        header("Location: /messages?sent=1");
        exit;
    }
}


