<?php

class Routes {

    public static $routes = array(
        '/' => array('Pages', 'home'),
        '/users/:id/:action' => array('Pages', 'home')
    );

}