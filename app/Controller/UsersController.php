<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController {

    public $uses = array('User');

    public function login() {

        $this->layout = 'login';
    }

    public function logout() {
        
    }

}
