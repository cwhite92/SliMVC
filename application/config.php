<?php

class Config {

    // Site base path without trailing slash (use / for root)
    public static $basePath = '/slimvc';

    // Database connection information
    public static $db = array('host' => 'localhost',
                              'user' => 'root',
                              'pass' => '',
                              'database' => 'slimvc');
}