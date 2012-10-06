<?php

class Controller {

    protected $models = array();
    protected $view = '';

    protected function loadModel($name) {
        // Load a model into $models in order to be used by controllers
        if(file_exists(APP_ROOT . 'models/' . $name . '.php')) {
            // Include and instantiate model
            require_once APP_ROOT . 'models/model.php';
            require_once APP_ROOT . 'models/' . $name . '.php';
            $modelName = $name . 'Model';
            $model = new $modelName();

            // Add model to $this->models
            $this->models[$name] = $model;
            print_r($this->models);
        } else {
            throw new Exception('Model file ' . $name . '.php not found.');
        }
    }

    protected function loadView($name, $data = null) {
        // Load the view
        if(file_exists(APP_ROOT . 'views/' . $name . '.html')) {
            $view = file_get_contents(APP_ROOT . 'views/' . $name . '.html');
        } else {
            throw new Exception('View file ' . $name . '.html not found.');
        }

        // Replace variables with ones passed using $data
        if(is_array($data)) {
            foreach($data as $key => $val) {
                $view = str_replace('{' . $key . '}', $val, $view);
            }
        }

        // Append to output view
        $this->view .= $view;
    }

    protected function render() {
        // Simply output the view
        echo $this->view;
    }

}