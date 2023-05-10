<?php
require_once 'core/Application.php';
require_once 'controllers/SiteController.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/BooksController.php';

require_once 'controllers/BookmarksController.php';
require_once 'controllers/HotelsController.php';
require_once 'controllers/BookingsController.php';

$dbConfig = [
    'dsn' => "mysql:host=127.0.0.1;post=3306;dbname=booking_db",
    'user' => 'root',
    'password' => ''
];

$app = new Application($dbConfig);

// register all your endpoints here
// if you want to register delete, put, patch, create the methods for yourself
// make sure to pass the URL and an array with two elements, the class of the controller and the name of the method
// that will handle the request
$app->getRouter()->get('/', [SiteController::class, 'home']);

$app->getRouter()->get('/about', [SiteController::class, 'about']);

$app->getRouter()->get('/login', [AuthController::class, 'login']);
$app->getRouter()->post('/login', [AuthController::class, 'login']);

$app->getRouter()->get('/register', [AuthController::class, 'register']);
$app->getRouter()->post('/register', [AuthController::class, 'register']);

$app->getRouter()->get('/logout', [AuthController::class, 'logout']);


//$app->getRouter()->get('/books', [BooksController::class, 'list']); // protected route, only authenticated users will open it
// log out should always be POST request, but to keep it simple, leave it GET


$app->getRouter()->get('/hotels', [HotelsController::class, 'list']);

$app->getRouter()->post('/book', [HotelsController::class, 'book']);
$app->getRouter()->get('/book', [HotelsController::class, 'book']);


$app->getRouter()->get('/hotelsregister', [HotelsController::class, 'register']);
$app->getRouter()->post('/hotelsregister', [HotelsController::class, 'register']);

$app->getRouter()->get('/bookings', [BookingsController::class, 'list']);
$app->getRouter()->post('/bookings', [BookingsController::class, 'book']);

//we will register hotels in a different endpoint


//TODO after Phase 1
// $app->getRouter()->get('/bookmarks', [BookmarksController::class, 'list']);
// $app->getRouter()->post('/bookmarks', [BookmarksController::class, 'bookmark']);

//


// start the application
$app->start();
