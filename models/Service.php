<?php

namespace Model;

class Service extends ActiveRecord {
    protected static $table = 'servicios';
    protected static $columnsDB = ['id', 'nombre', 'precio'];
    public $id;
    public $nombre;
    public $precio;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->precio = $args['precio'] ?? '';
    }

    public function validateService() {
        if (!$this->nombre) {
            $this->setAlert('error', 'nombre', 'El nombre es obligatorio');
        }
        if (!$this->precio) {
            $this->setAlert('error', 'precio', 'El precio es obligatorio');
        } else if (!is_numeric($this->precio)) {
            $this->setAlert('error', 'precio', 'El precio solo debe contener números');
        }

        return self::getAlerts();
    }
}
