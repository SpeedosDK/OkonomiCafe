<?php
ob_start();
require_once __DIR__ . '/../includes/autoload.php';
require_once __DIR__ . '/../core/Router.php';



$router = new Router();

$router->get('/', 'HomeController@index');
$router->get('/home', 'HomeController@index');
$router->get('/saadan-virker-det', 'HomeController@saadan');
$router->get('/for-dig', 'HomeController@forDig');
$router->get('/frivillig', 'HomeController@frivillig');
$router->get('/kontakt', 'HomeController@kontakt');
$router->get('/kalender', 'HomeController@kalender');
$router->get('/login', 'HomeController@loginForm');
$router->post('/login', 'HomeController@login');
$router->post('/save-shift', 'HomeController@saveShift');
$router->post('/delete-shift', 'HomeController@deleteShift');
$router->post('/update-shift', 'HomeController@updateShift');


$router->get('/kalender-admin', 'HomeController@kalenderAdmin');
$router->get('/logout', 'HomeController@logout');
$router->post('/kalender-admin', 'HomeController@saveShift');


$router->post('/send-message', 'HomeController@saveMessage');
$router->get('/messages', 'HomeController@messages');

$router->post('/messages/read', 'HomeController@messageRead');
$router->post('/messages/reply', 'HomeController@messageReply');
$router->protect('/messages');


$router->protect('/kalender-admin');

$router->dispatch();
?>