<?php

namespace Controllers;

use Model\AdminAppointments;
use MVC\Router;

class AdminController {
    public static function index(Router $router) {
        authAdmin();

        if (!isset($_SESSION)) {
            session_start();
        }

        $date = $_GET['date'] ?? date('Y-m-d');
        // Validar fecha
        $dateSplit = explode('-', $date);
        if (!checkdate($dateSplit[1], $dateSplit[2], $dateSplit[0])) {
            header('Location: /admin');
        }

        $query = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $query .= "usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $query .= "FROM citas ";
        $query .= "LEFT OUTER JOIN usuarios ";
        $query .= "ON citas.usuarioId = usuarios.id ";
        $query .= "LEFT OUTER JOIN citas_servicios ";
        $query .= "ON citas_servicios.citaId = citas.id ";
        $query .= "LEFT OUTER JOIN servicios ";
        $query .= "ON servicios.id = citas_servicios.servicioId ";
        $query .= "WHERE fecha = '$date';";

        $appointments = AdminAppointments::SQL($query);
        $formatted = [];
        // Se unen todos los resultados que tengan el mismo id en un solo array
        foreach ($appointments as $appointment) {
            // Solo sobreescribe los campos la primera vez
            if (empty($formatted[$appointment->id])) {
                $formatted[$appointment->id]['id'] = $appointment->id;
                $formatted[$appointment->id]['hora'] = $appointment->hora;
                $formatted[$appointment->id]['cliente'] = $appointment->cliente;
                $formatted[$appointment->id]['email'] = $appointment->email;
                $formatted[$appointment->id]['telefono'] = $appointment->telefono;
                $formatted[$appointment->id]['total'] = 0;
            }
            $formatted[$appointment->id]['servicios'][] = [
                'servicio' => $appointment->servicio,
                'precio' => $appointment->precio
            ];
            $formatted[$appointment->id]['total'] += $appointment->precio;
        }

        $router->render('admin/index', [
            'name' => $_SESSION['nombre'],
            'appointments' => $formatted,
            'date' => $date
        ]);
    }
}
