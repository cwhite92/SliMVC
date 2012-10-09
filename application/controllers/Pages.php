<?php

class PagesController extends Controller {

    public function home() {
        // Load model
        $this->loadModel('Users');

    	// Assign view variables and load the views
        $data = array(
                      'title' => 'SliMVC - lightweight PHP MVC framework',
                      'users' => $this->models['Users']->getAllUsers()
                      );
        $this->loadView('header', $data);
        $this->loadView('home', $data);
        $this->loadView('footer', $data);
    }

}