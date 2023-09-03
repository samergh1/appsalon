<?php

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\LoginController;
use Controllers\AppointmentController;
use Controllers\AdminController;
use Controllers\APIController;
use Controllers\ServiceController;

$router = new Router();

// Auth
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);
$router->get('/signup', [LoginController::class, 'signup']);
$router->post('/signup', [LoginController::class, 'signup']);
$router->get('/email/confirmation', [LoginController::class, 'emailConfirmation']);
$router->get('/email/message', [LoginController::class, 'emailMessage']);
// Resetear password
$router->get('/password/reset', [LoginController::class, 'passwordReset']);
$router->post('/password/reset', [LoginController::class, 'passwordReset']);
$router->get('/password/new', [LoginController::class, 'newPassword']);
$router->post('/password/new', [LoginController::class, 'newPassword']);
// Rutas privadas
$router->get('/appointments', [AppointmentController::class, 'index']);
$router->get('/admin', [AdminController::class, 'index']);
// CRUD Servicios
$router->get('/services', [ServiceController::class, 'index']);
$router->get('/services/create', [ServiceController::class, 'create']);
$router->post('/services/create', [ServiceController::class, 'create']);
$router->get('/services/update', [ServiceController::class, 'update']);
$router->post('/services/update', [ServiceController::class, 'update']);
$router->post('/services/delete', [ServiceController::class, 'delete']);
// APIs
$router->get('/api/services', [APIController::class, 'index']);
$router->post('/api/appointments', [APIController::class, 'save']);
$router->post('/api/delete', [APIController::class, 'delete']);

$router->checkRoutes();
