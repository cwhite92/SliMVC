<?php

class Application {

    public function run() {
        // Set the exception handler for this application
        set_exception_handler(array('Application', 'exception'));

        // Determine request path
        $path = $_SERVER['REQUEST_URI'];
        $path = str_replace(Config::$basePath, '', $path);

        // Load routes
        require_once 'routes.php';

        // Match this request to a route
        if(isset(Routes::$routes[$path])) {
            $controllerName = Routes::$routes[$path][0];
            $actionName = Routes::$routes[$path][1];
        } else {
            throw new Exception('404 Not Found');
        }

        // Check if controller exists
        if(file_exists(APP_ROOT . 'controllers/' . $controllerName . '.php')) {
            // Include and instantiate controllers
            require_once APP_ROOT . 'controllers/Controller.php';
            require_once APP_ROOT . 'controllers/' . $controllerName . '.php';
            $controllerName .= 'Controller';
            $controller = new $controllerName();

            // Run method for this route
            if(method_exists($controller, $actionName)) {
                return $controller->$actionName();
            } else {
                throw new Exception('Method ' . $actionName . ' missing in controller ' . $controllerName);
            }
        } else {
            throw new Exception('Controller ' . $controllerName . 'Controller missing');
        }
    }

    public static function exception($e) {
        // TODO: log exception

        die(print_r($e));
    }

}