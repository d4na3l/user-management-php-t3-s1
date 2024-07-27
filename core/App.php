<?php

class App
{
    protected $route;

    public function __construct()
    {
        $routes = require '../routes/web.php';  // Carga el array de rutas desde el archivo de configuración
        $this->route = new Route($routes);  // Pasa las rutas a la clase Route
    }

    public function run()
    {
        $controllerAction = $this->route->getControllerAction();

        if ($controllerAction) {
            list($controller, $method) = explode('@', $controllerAction);

            $controller = "App\\Controller\\{$controller}";

            if (class_exists($controller)) {
                $controllerInstance = new $controller();
                if (method_exists($controllerInstance, $method)) {
                    call_user_func_array([$controllerInstance, $method], []);
                } else {
                    $this->handleNotFound("Método '{$method}' no encontrado en el controlador '{$controller}'.");
                }
            } else {
                $this->handleNotFound("Controlador '{$controller}' no encontrado.");
            }
        } else {
            $this->handleNotFound("Ruta no encontrada para {$this->route->requestMethod} {$this->route->requestUri}.");
        }
    }

    protected function handleNotFound($message = 'Not Found')
    {
        http_response_code(404);
        require '../resources/views/layouts/404.view.php';
        show("<h1>404 - {$message}");
    }
}
