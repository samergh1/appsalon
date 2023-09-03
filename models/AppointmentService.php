<?php

namespace Model;

class AppointmentService extends ActiveRecord {
    protected static $table = 'citas_servicios';
    protected static $columnsDB = ['id', 'citaId', 'servicioId'];
    public $id;
    public $citaId;
    public $servicioId;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? '';
        $this->citaId = $args['citaId'] ?? '';
        $this->servicioId = $args['servicioId'] ?? '';
    }
}
