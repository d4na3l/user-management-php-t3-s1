<?php

class Route
{
    protected $routes;
    protected $controller = 'AuthController';
    protected $method = 'login';
    public $requestMethod;
    public $requestUri;

    public function __construct($routes)
    {
        $this->routes = $routes; // Asegurarse de que las rutas se asignen al atributo de clase
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->requestUri = strtok($_SERVER['REQUEST_URI'], '?');
        $this->parseUrl();
    }

    protected function parseUrl()
    {
        if (isset($this->routes[$this->requestMethod][$this->requestUri])) {
            // Encuentra el controlador y método para la URL
            list($this->controller, $this->method) = explode('@', $this->routes[$this->requestMethod][$this->requestUri]);
        } elseif (isset($this->routes[$this->requestMethod]['/'])) {
            // Utiliza la ruta raíz (/) como predeterminada
            list($this->controller, $this->method) = explode('@', $this->routes[$this->requestMethod]['/']);
        }
    }

    public function getControllerAction()
    {
        return "{$this->controller}@{$this->method}";
    }
}
