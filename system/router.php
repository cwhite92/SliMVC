<?php

class Router {

    public static function routeRequest($path) {
        // Try to match the request (defined by $path) to a route
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

        return array('controller' => $controllerName,
                     'action' => $actionName,
                     'params' => $params);
    }

}