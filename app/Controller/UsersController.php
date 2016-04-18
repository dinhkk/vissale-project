<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController {

    public $uses = array('User');

    public function login() {

        $this->layout = 'login';
    }

    public function logout() {
        
    }

    public function index() {
        
    }

    public function add() {
        
    }

    public function edit($id = null) {
        
    }

    public function delete($id = null) {

    }
    
    public function setPermissions(){

    }

    
}
