<?php

class Controller {

    protected $models = array();
    protected $helpers = array();

    protected function loadModels($models) {
        // Load the listed models into $models in order to be used by the controller
        foreach($models as $model) {
            if(file_exists(APP_ROOT . 'models/' . $model . '.php')) {
                // Include and instantiate model
                require_once APP_ROOT . 'models/Model.php';
                require_once APP_ROOT . 'models/' . $model . '.php';
                $modelName = $model . 'Model';
                $theModel = new $modelName();

                // Add model to $this->models
                $this->models[$model] = $theModel;
            } else {
                throw new Exception('Model file ' . $name . '.php not found.');
            }
        }
    }

    protected function loadViews($views, $data = null) {
        // Loop through all views in $names
        foreach($views as $view) {
            // Check if view exists
            if(file_exists(APP_ROOT . 'views/' . $view . '.html')) {
                // Make variables passed using $data available to the view using key as variable names
                if(is_array($data)) {
                    extract($data);
                }

                // Include view file
                include_once APP_ROOT . 'views/' . $view . '.html';
            } else {
                throw new Exception('View file ' . $view . '.html not found.');
            }
        }
    }

    protected function loadHelpers($helpers) {
        // Loop through helpers to be loaded
        foreach($helpers as $helper) {
            // Check if helper exists
            if(file_exists(APP_ROOT . 'helpers/' . $helper . 'Helper.php')) {
                // Include and instantiate it
                include_once APP_ROOT . 'helpers/' . $helper . 'Helper.php';
                $helperName = $helper . 'Helper';
                $theHelper = new $helperName();

                // Add to $this->helpers
                $this->helpers[$helper] = $theHelper;
            } else {
                throw new Exception('Helper file ' . $helper . 'Helper.php not found.');
            }
        }
    }

}