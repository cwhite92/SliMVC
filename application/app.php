<?php

class Application {

    public function run() {
        // Wrap the entire application in a try block to catch exceptions
        try {
            // Determine request path
            $path = strtolower($_SERVER['REQUEST_URI']);
            $path = str_replace(Config::$basePath, '', $path);

            // Load routes
            require_once 'routes.php';

            // Match this request to a route
            if(isset(Routes::$routes[$path])) {
                $controllerName = Routes::$routes[$path][0];
                $actionName = Routes::$routes[$path][1];
            } else {
                // TODO: create a specific 404 handler
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
        } catch(Exception $e) {
            die('<h1>Ahhh! An Exception!</h1>' . $e->getMessage());
        }
    }

}