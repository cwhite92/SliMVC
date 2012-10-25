<?php

class Routes {

    public static $routes = array(
        '/' => array('Pages', 'home'),
        '/users/:id/:action' => array('Pages', 'home'),

        // Special routes for error pages, don't change
        '/exception/:error' => array('Errors', 'exception')
    );

}