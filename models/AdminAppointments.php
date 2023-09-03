<?php

namespace Model;

class AdminAppointments extends ActiveRecord {
    protected static $table = 'citas_servicios';
    protected static $columnsDB = ['id', 'hora', 'cliente', 'email', 'telefono', 'servicio', 'precio'];
    public $id;
    public $hora;
    public $cliente;
    public $email;
    public $telefono;
    public $servicio;
    public $precio;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? '';
        $this->hora = $args['hora'] ?? '';
        $this->cliente = $args['cliente'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->servicio = $args['servicio'] ?? '';
        $this->precio = $args['precio'] ?? '';
    }
}
