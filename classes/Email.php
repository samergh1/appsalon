<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {
    public $email;
    public $name;
    public $token;

    public function __construct($email, $name, $token) {
        $this->email = $email;
        $this->name = $name;
        $this->token = $token;
    }

    public static function configuration(): PHPMailer {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];
        $mail->SMTPSecure = 'tls';
        $mail->Port = $_ENV['EMAIL_PORT'];
        return $mail;
    }

    public function sendConfirmation() {
        $mail = self::configuration();

        $mail->setFrom('appsalon@admin.com', 'AppSalón');
        $mail->addAddress($this->email, $this->name);
        $mail->isHTML(true);

        $url = $_ENV['APP_URL'] . "/email/confirmation?token=" . $this->token;
        $content = "<html>";
        $content .= "<p>Hola $this->name, haz click en el siguiente enlace para confirmar tu cuenta de AppSalón</p>";
        $content .= "<a href='$url'>Confirmar cuenta</a>";
        $content .= "<p>Ignora este mensaje si no lo solicitaste</p>";
        $content .= "</html>";

        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Confirma tu cuenta de App Salón';
        $mail->Body = $content;
        $mail->AltBody = 'Cuerpo alternativo';

        try {
            $mail->send();
        } catch (\Throwable $th) {
            var_dump($th);
        }
    }

    public function sendPasswordReset() {
        $mail = self::configuration();

        $mail->setFrom('appsalon@admin.com', 'AppSalón');
        $mail->addAddress($this->email, $this->name);
        $mail->isHTML(true);

        $url = $_ENV['APP_URL'] . "/password/new?token=" . $this->token;
        $content = "<html>";
        $content .= "<p>Hola $this->name, haz click en el siguiente enlace para crear una nueva password</p>";
        $content .= "<a href='$url'>Resetear password</a>";
        $content .= "<p>Ignora este mensaje si no lo solicitaste</p>";
        $content .= "</html>";

        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Resetea tu password de App Salón';
        $mail->Body = $content;
        $mail->AltBody = 'Cuerpo alternativo';

        try {
            $mail->send();
        } catch (\Throwable $th) {
            var_dump($th);
        }
    }
}
