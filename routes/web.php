<?php

use App\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\ReservationController;

$router = Router::getInstance();

//addRoute(string $method, string $path, string $action, string $controller)
$router->addRoute("GET", "/", "home", HomeController::class);

$router->addRoute("GET", "/err", "showError", HomeController::class);

$router->addRoute("GET", "/register", "showRegister", AuthController::class);
$router->addRoute("POST", "/register", "register", AuthController::class);

$router->addRoute("GET", "/login", "showLogin", AuthController::class);
$router->addRoute("POST", "/login", "login", AuthController::class);

$router->addRoute("GET", "/logout", "logout", AuthController::class);

$router->addRoute("GET", "/add-reservation", "showReservationForm", ReservationController::class);
$router->addRoute("POST", "/add-reservation", "addReservation", ReservationController::class);

$router->addRoute("GET", "/edit-reservation", "showEditReservationForm", ReservationController::class);
$router->addRoute("POST", "/edit-reservation", "updateReservation", ReservationController::class);

$router->addRoute("POST", "/delete-reservation", "deleteReservation", ReservationController::class);


$router->dispatch();