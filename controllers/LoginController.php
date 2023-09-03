<?php

namespace Controllers;

use Classes\Email;
use Model\User;
use MVC\Router;

class LoginController {
    public static function login(Router $router) {
        $user = new User;
        $alerts = User::getAlerts();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->updateData($_POST);
            $alerts = $user->validateLogin();

            if (empty($alerts['error'])) {
                $alerts = $user->verifyPassword();
                if (empty($alerts['error'])) {
                    $authUser = User::where('email', $user->email);
                    session_start();
                    // Agregar datos a la variable global session
                    $_SESSION['id'] = $authUser->id;
                    $_SESSION['nombre'] = $authUser->nombre . ' ' . $authUser->apellido;
                    $_SESSION['email'] = $authUser->email;
                    $_SESSION['login'] = true;

                    if ($authUser->admin === '1') {
                        $_SESSION['admin'] = $authUser->admin;
                        header('Location: /admin');
                    } else {
                        header('Location: /appointments');
                    }
                }
            }
        }

        $router->render('auth/login', [
            'user' => $user,
            'alerts' => $alerts
        ]);
    }

    public static function logout() {
        session_start();
        $_SESSION = [];
        header('Location: /');
    }

    public static function signup(Router $router) {
        $user = new User;
        $alerts = User::getAlerts();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->updateData($_POST);
            $alerts = $user->validateSignup();

            if (empty($alerts['error'])) {
                // Hashear password
                $user->hashPassword();
                // Generar token unico para validar email
                $user->generateToken();
                // Enviar email de confirmacion
                $mail = new Email($user->email, $user->nombre, $user->token);
                $mail->sendConfirmation();
                // Crear usuario
                $result = $user->create();
                if ($result['status']) {
                    header('Location: /email/message');
                }
            }
        }

        $router->render('auth/signup', [
            'user' => $user,
            'alerts' => $alerts
        ]);
    }

    public static function emailMessage(Router $router) {
        $router->render('auth/email/emailMessage');
    }

    public static function emailConfirmation(Router $router) {
        // Obtener y sanitizar token
        $token = s($_GET['token']) ?? '';
        // Validar existencia del usuario que posea ese token
        $user = User::where('token', $token);
        if (!$user->id) {
            header('Location: /');
        }
        // Confirmar usuario
        $result = $user->confirmUser();
        if ($result) {
            $router->render('auth/email/emailConfirmation');
        }
    }

    public static function passwordReset(Router $router) {
        $alerts = User::getAlerts();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new User($_POST);
            $user->validateEmail();
            $alerts = User::getAlerts();
            if (empty($alerts['error'])) {
                $user = User::where('email', $user->email);
                if ($user->resetToken()) {
                    // Crear email para resetear password y enviar
                    $mail = new Email($user->email, $user->nombre, $user->token);
                    $mail->sendPasswordReset();
                    // Mensaje de confirmacion
                    $user->setAlert('success', 'confirmation', 'Se ha enviado un email con instrucciones para actualizar su password');
                    $alerts = User::getAlerts();
                }
            }
        }

        $router->render('auth/password/resetPassword', [
            'alerts' => $alerts
        ]);
    }

    public static function newPassword(Router $router) {
        $alerts = User::getAlerts();
        // Obtener y sanitizar token
        $token = $_GET['token'] ?? '0';
        // Validar existencia del usuario que posea ese token
        $user = User::where('token', $token);
        if (!$user->id) {
            header('Location: /');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener password, sanitizar y validar
            $user->password = s($_POST['password']);
            $user->validatePassword();
            $alerts = User::getAlerts();

            if (empty($alerts['error'])) {
                // Hashear password, eliminar token y actualizar usuario
                $user->hashPassword();
                $user->token = null;
                if ($user->update($user->id)) {
                    // Mensaje de confirmacion
                    $user->setAlert('success', 'confirmation', 'Se ha cambiado su password exitosamente');
                    $alerts = User::getAlerts();
                }
            }
        }

        $router->render('auth/password/newPassword', [
            'alerts' => $alerts
        ]);
    }
}
