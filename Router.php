<?php

namespace MVC;

class Router {
    public $routesGET = [];
    public $routesPOST = [];

    public function get($url, $fn) {
        $this->routesGET[$url] = $fn;
    }

    public function post($url, $fn) {
        $this->routesPOST[$url] = $fn;
    }

    public function checkRoutes() {
        $url = strtok($_SERVER['REQUEST_URI'], '?') ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            $fn = $this->routesGET[$url] ?? null;
        } else {
            $fn = $this->routesPOST[$url] ?? null;
        }

        if (!is_null($fn)) {
            // Permite llamar una funcion que esta dentro de la instancia del objeto Router
            call_user_func($fn, $this);
        } else {
            echo '<h1>Page not found</h1>';
        }
    }

    // Muestra una vista
    public function render($view, $data = []) {
        foreach ($data as $key => $value) {
            // $$ -> Variable de variable (se crea una nueva variable con el valor de $key)
            $$key = $value;
        }
        // Inicia un almacenamiento en memoria
        ob_start();
        include __DIR__ . "/views/$view.php";
        // Se almacena el contenido en la variable y se limpia la memoria
        $content = ob_get_clean();
        include __DIR__ . "/views/layout.php";
    }
}
