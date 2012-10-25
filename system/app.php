<?php

class Application {

    public function run() {
        // Wrap the entire application in a try block to catch exceptions
        try {
            // Determine request path also forcing ending slash
            $path = str_replace(Config::$basePath, '', strtolower($_SERVER['REQUEST_URI']));
            if(substr($path, -1) != '/') {
                $path .= '/';
            }

            // Load routes and router
            require_once APP_ROOT . 'routes.php';
            require_once SYS_ROOT . 'router.php';

            // Match this request to a route
            $destination = Router::routeRequest($path);
            
            // Check if controller exists
            if(file_exists(APP_ROOT . 'controllers/' . $destination['controller'] . '.php')) {
                // Include and instantiate controllers
                require_once APP_ROOT . 'controllers/Controller.php';
                require_once APP_ROOT . 'controllers/' . $destination['controller'] . '.php';
                $destination['controller'] .= 'Controller';
                $controller = new $destination['controller']();

                // Run method for this route
                if(method_exists($controller, $destination['action'])) {
                    return call_user_func_array(array($controller, $destination['action']), $destination['params']);
                } else {
                    throw new Exception('Method ' . $destination['action'] . ' missing in controller ' . $destination['controller']);
                }
            } else {
                throw new Exception('Controller ' . $destination['controller'] . 'Controller missing');
            }
        } catch(Exception $e) {
            die('<h1>Ahhh! An Exception!</h1>' . $e->getMessage());
        }
    }

}