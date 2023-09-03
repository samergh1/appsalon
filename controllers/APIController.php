<?php

namespace Controllers;

use Model\Appointment;
use Model\Service;
use Model\AppointmentService;

class APIController {
    public static function index() {
        $services = Service::all();
        echo json_encode($services);
    }

    public static function save() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Crear cita
            $appointment = new Appointment($_POST);
            $result = $appointment->create();
            echo json_encode($result);

            // Crear CitaServicio
            $citaId = $result['id'];
            $serviciosId = explode(',', $_POST['selectedServices']);
            foreach ($serviciosId as $servicioId) {
                $args = [
                    'citaId' => $citaId,
                    'servicioId' => $servicioId
                ];
                $appointmentService = new AppointmentService($args);
                $result = $appointmentService->create();
            }
        }
    }

    public static function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $result = Appointment::delete($id);
            if ($result) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        }
    }
}
