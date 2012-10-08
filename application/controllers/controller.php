<?php

class Controller {

    protected $models = array();
    protected $view = '';

    protected function loadModel($name) {
        // Load a model into $models in order to be used by controllers
        if(file_exists(APP_ROOT . 'models/' . $name . '.php')) {
            // Include and instantiate model
            require_once APP_ROOT . 'models/Model.php';
            require_once APP_ROOT . 'models/' . $name . '.php';
            $modelName = $name . 'Model';
            $model = new $modelName();

            // Add model to $this->models
            $this->models[$name] = $model;
        } else {
            throw new Exception('Model file ' . $name . '.php not found.');
        }
    }

    protected function loadView($name, $data = null) {
        // Check if view exists
        if(!file_exists(APP_ROOT . 'views/' . $name . '.html')) {
            throw new Exception('View file ' . $name . '.html not found.');
        }

        // Make variables passed using $data available to the view using key as variable names
        if(is_array($data)) {
            extract($data);
        }

        // Include view file
        include_once APP_ROOT . 'views/' . $name . '.html';
    }

}