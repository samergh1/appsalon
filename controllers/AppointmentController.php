<?php

namespace Controllers;

use MVC\Router;

class AppointmentController {
    public static function index(Router $router) {
        authUser();

        if (!isset($_SESSION)) {
            session_start();
        }

        $router->render('appointments/index', [
            'name' => $_SESSION['nombre'],
            'id' => $_SESSION['id']
        ]);
    }
}
