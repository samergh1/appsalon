<?php

namespace Controllers;

use Model\Service;
use MVC\Router;

class ServiceController {
    public static function index(Router $router) {
        authAdmin();

        $services = Service::all();

        $router->render('admin/services/index', [
            'name' => $_SESSION['nombre'],
            'services' => $services
        ]);
    }

    public static function create(Router $router) {
        authAdmin();

        $service = new Service;
        $alerts = Service::getAlerts();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $service->updateData($_POST);
            $alerts = $service->validateService();
            if (empty($alerts)) {
                $result = $service->create();
                if ($result['status']) {
                    // Mensaje de confirmacion
                    $service->setAlert('success', 'confirmation', 'Se ha creado el servicio exitosamente');
                    $alerts = Service::getAlerts();
                    // Se vacia el objeto
                    $service = new Service;
                }
            }
        }

        $router->render('admin/services/create', [
            'name' => $_SESSION['nombre'],
            'service' => $service,
            'alerts' => $alerts
        ]);
    }

    public static function update(Router $router) {
        authAdmin();

        // Validar id del GET
        $serviceId = filter_var($_GET['id'], FILTER_VALIDATE_INT);
        if (!$serviceId) {
            header('Location: /services');
        }
        // Obtener servicio
        $service = Service::find($serviceId);
        if (!$service->id) {
            header('Location: /services');
        }
        $alerts = Service::getAlerts();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            debug($_POST);
            $service->updateData($_POST);
            $alerts = $service->validateService();
            if (empty($alerts)) {
                $result = $service->update($service->id);
                if ($result) {
                    header('Location: /services');
                }
            }
        }

        $router->render('admin/services/update', [
            'name' => $_SESSION['nombre'],
            'service' => $service,
            'alerts' => $alerts
        ]);
    }

    public static function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $result = Service::delete($id);
            if ($result) {
                echo json_encode($result);
            }
        }
    }
}
