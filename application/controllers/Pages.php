<?php

class PagesController extends Controller {

    public function home() {
    	// Load model
    	$this->loadModel('Users');

    	// Assign view variables and load the homepage view
        $data = array(
        			  'users' => $this->models['Users']->getAllUsers()
        			  );
        $this->loadView('home', $data);
    }

}