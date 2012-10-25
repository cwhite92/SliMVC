<?php

class ErrorsController extends Controller {

    public function notFound() {
        $data = array('title' => 'Page not found');
        $this->loadViews(array('header', '404', 'footer'), $data);
    }

    public function exception($error) {
        $data = array('title' => 'A fatal error occured',
                      'error' => $error);
        $this->loadViews(array('header', 'exception', 'footer'), $data);
    }

}