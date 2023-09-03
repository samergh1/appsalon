<?php

namespace Model;

class Appointment extends ActiveRecord {
    protected static $table = 'citas';
    protected static $columnsDB = ['id', 'fecha', 'hora', 'usuarioId'];
    public $id;
    public $fecha;
    public $hora;
    public $usuarioId;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? '';
        $this->fecha = $args['date'] ?? '';
        $this->hora = $args['time'] ?? '';
        $this->usuarioId = $args['usuarioId'] ?? '';
    }
}
