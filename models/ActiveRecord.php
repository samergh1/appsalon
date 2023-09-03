<?php

namespace Model;

class ActiveRecord {
    protected static $db;
    protected static $table = '';
    protected static $columnsDB = [];
    protected static $alerts = [];

    // Crear registro
    public function create(): array {
        try {
            $attributes = $this->sanitizeData();
            $columnKeys = join(', ', array_keys($attributes));
            $columnValues = join("', '", array_values($attributes));
            $query = "INSERT INTO " . static::$table . " ($columnKeys) VALUES ('$columnValues');";
            $result = [
                'status' => self::$db->query($query),
                'id' => self::$db->insert_id
            ];
            return $result;
        } catch (\Throwable $th) {
            var_dump($th);
        }
    }

    // Obtener todos los registros
    public static function all(): array {
        try {
            $query = "SELECT * FROM " . static::$table . ";";
            $result = self::$db->query($query);
            $records = [];
            while ($row = $result->fetch_assoc()) {
                $row = new static($row);
                $records[] = $row;
            }
            return $records;
        } catch (\Throwable $th) {
            var_dump($th);
        }
    }

    // Obtener una cantidad de registros especifica
    public static function get(int $limit = 1): array {
        try {
            $query = "SELECT * FROM " . static::$table . " LIMIT $limit;";
            $result = self::$db->query($query);
            $records = [];
            while ($row = $result->fetch_assoc()) {
                $row = new static($row);
                $records[] = $row;
            }
            return $records;
        } catch (\Throwable $th) {
            var_dump($th);
        }
    }

    // Obtener registro a traves del id
    public static function find(int $id): object {
        try {
            $query = "SELECT * FROM " . static::$table . " WHERE id=$id;";
            $result = self::$db->query($query);
            $record = new static($result->fetch_assoc());
            return $record;
        } catch (\Throwable $th) {
            var_dump($th);
        }
    }

    // Obtener registro de acuerdo a la columna que se especifique
    public static function where(string $column, string $value): object {
        try {
            $query = "SELECT * FROM " . static::$table . " WHERE $column='$value';";
            $result = self::$db->query($query);
            $record = new static($result->fetch_assoc());
            return $record;
        } catch (\Throwable $th) {
            var_dump($th);
        }
    }

    // Consulta SQL plana
    public static function SQL(string $query): array {
        try {
            $result = self::$db->query($query);
            $records = [];
            while ($row = $result->fetch_assoc()) {
                $row = new static($row);
                $records[] = $row;
            }
            return $records;
        } catch (\Throwable $th) {
            var_dump($th);
        }
    }

    // Actualizar registro
    public function update(int $id): bool {
        $attributes = $this->sanitizeData();
        $setQuery = '';
        foreach ($attributes as $key => $value) {
            $setQuery .= $key . ' = ' . "'$value', ";
        }
        // Se eliminan los ultimos dos caracteres del string (, )
        $setQuery = substr($setQuery, 0, -2);

        $query = "UPDATE " . static::$table . " SET $setQuery WHERE id = $id;";
        return self::$db->query($query);
    }

    // Eliminar registro
    public static function delete(int $id): bool {
        try {
            $id = self::$db->escape_string($id);
            $query = "DELETE FROM " . static::$table . " WHERE id = $id;";
            return self::$db->query($query);
        } catch (\Throwable $th) {
            var_dump($th);
        }
    }

    // Mapear los atributos de un objeto hacia un array asociativo
    public function mapAttributes(): array {
        $attributesArray = [];
        foreach (static::$columnsDB as $column) {
            if ($column === 'id') continue;
            $attributesArray[$column] = $this->$column;
        }
        return $attributesArray;
    }

    // Sanitizar los datos
    public function sanitizeData(): array {
        $attributesArray = $this->mapAttributes();
        $sanitizedData = [];
        foreach ($attributesArray as $key => $value) {
            $sanitizedData[$key] = self::$db->escape_string($value);
        }
        return $sanitizedData;
    }

    // Actualizar los datos obtenidos de la variable POST
    public function updateData(array $args = []): void {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

    // Getters y setters
    public static function getAlerts(): array {
        return static::$alerts;
    }

    public static function setDB($database): void {
        self::$db = $database;
    }

    public function setAlert(string $type, string $name, string $message): void {
        static::$alerts[$type][$name] = $message;
    }
}
