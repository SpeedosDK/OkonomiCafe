<?php
require_once __DIR__ . '/../includes/autoload.php';
require_once __DIR__ . '/../src/controllers/HomeController.php';

$controller = new HomeController();
$controller->index();
?>