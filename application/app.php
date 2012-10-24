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

            // Load routes
            require_once 'routes.php';

            // Match this request to a route
            foreach(Routes::$routes as $route => $destination) {
                // Check if a basic route matches straight away
                if($path == $route) {
                    $controllerName = $destination[0];
                    $actionName = $destination[1];
                } else if($route != '/') {
                    $routeSplit = array_filter(explode('/', $route));
                    $routeRegex = '^/';
                    $params = array();

                    // Loop through and construct regex for this route
                    foreach($routeSplit as $part) {
                        $segRegex = '';
                        if(substr($part, 0, 1) == ':') {
                            // We need to capture this in order to pass it as an argument to our action
                            $segRegex .= '([^/]*)/';
                            $params[ltrim($part, ':')] = null;
                        } else {
                            // Normal segment, don't capture
                            $segRegex .= $part . '/';
                        }
                        $routeRegex .= $segRegex;
                    }
                    $routeRegex .= '$';
                    
                    // Finally, use the regex pattern to match this route
                    if(preg_match_all('~' . $routeRegex . '~', $path, $matches) != 0) {
                        $controllerName = $destination[0];
                        $actionName = $destination[1];

                        // Prepare parameters
                        $i = 1;
                        foreach($params as $param => $value) {
                            $params[$param] = $matches[$i][0];
                            ++$i;
                        }
                        break;
                    }
                }
            }

            // Check if we've 404'd
            if(!isset($controllerName, $actionName)) {
                // TODO: write proper 404 handler
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
                    return call_user_func_array(array($controller, $actionName), $params);
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