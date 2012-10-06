<?php

class PagesController extends Controller {

    public function home() {
    	// Test models
    	$this->loadModel('Users');

    	$this->models['Users'];

    	// Test views
        $data = array('test' => 'homepage');
        $this->loadView('home', $data);

        $this->render();
    }

}