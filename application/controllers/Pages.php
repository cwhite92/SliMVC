<?php

class PagesController extends Controller {

    public function home() {
        // Load model
        $this->loadModels(array('Users'));

        // Load helper
        $this->loadHelpers(array('Password'));

      	// Assign view variables and load the views
        $data = array('title' => 'SliMVC - lightweight PHP MVC framework',
                      'users' => $this->models['Users']->getAllUsers(),
                      'helperTest' => $this->helpers['Password']->test());
        $this->loadViews(array('header', 'home', 'footer'), $data);
    }

}