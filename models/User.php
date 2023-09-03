<?php

namespace Model;

class User extends ActiveRecord {
    protected static $table = 'usuarios';
    protected static $columnsDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];
    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;


    public function __construct($args = []) {
        $this->id = $args['id'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? 0;
        $this->confirmado = $args['confirmado'] ?? 0;
        $this->token = $args['token'] ?? '';
    }

    public function confirmUser(): bool {
        $this->confirmado = 1;
        $this->token = null;
        return $this->update($this->id);
    }

    // Validar datos del inicio de sesion
    public function validateLogin(): array {
        $this->validateEmail();
        $this->validatePassword();
        return self::getAlerts();
    }

    // Validar email
    public function validateEmail(): void {
        if (!$this->email) {
            $this->setAlert('error', 'email', 'El email es obligatorio');
        } else {
            $result = User::where('email', $this->email);
            if (!$result->email) {
                $this->setAlert('error', 'email', 'El usuario no existe');
            } else if ($result->confirmado === '0') {
                $this->setAlert('error', 'email', 'El email no ha sido confirmado');
            }
        }
    }

    // Validar password
    public function validatePassword(): void {
        if (!$this->password) {
            $this->setAlert('error', 'password', 'El password es obligatorio');
        } else if (strlen($this->password) < 6) {
            $this->setAlert('error', 'password', 'El password debe contener al menos 6 caracteres');
        }
    }

    // Verificar que la password introducida sea igual a la que esta almacenada en la BD
    public function verifyPassword(): array {
        $user = User::where('email', $this->email);
        $hashedPassword = $user->password;
        if (!password_verify($this->password, $hashedPassword)) {
            $this->setAlert('error', 'password', 'El password es incorrecto');
        }
        return self::getAlerts();
    }

    public function resetToken(): bool {
        $this->generateToken();
        return $this->update($this->id);
    }

    // Validar datos del registro
    public function validateSignup(): array {
        if (!$this->nombre) {
            $this->setAlert('error', 'nombre', 'El nombre es obligatorio');
        }
        if (!$this->apellido) {
            $this->setAlert('error', 'apellido', 'El apellido es obligatorio');
        }
        if (!preg_match('/^[0-9]{11}$/', $this->telefono)) {
            $this->setAlert('error', 'telefono', 'El telefono es obligatorio y debe tener 11 caracteres');
        }
        if (!$this->email) {
            $this->setAlert('error', 'email', 'El email es obligatorio');
        } else {
            $result = User::where('email', $this->email);
            if ($result->email) {
                $this->setAlert('error', 'email', 'El usuario ya existe');
            }
        }
        $this->validatePassword();

        return self::getAlerts();
    }

    public function hashPassword(): void {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
    }

    public function generateToken(): void {
        $this->token = uniqid();
    }
}
