<?php

App::uses('AppController', 'Controller');

class BundlesController extends AppController {

    public $uses = array('Bundle');

    public function index() {

        $this->setInit();
        $page_title = __('bundle_title');
        $this->set('page_title', $page_title);

        $breadcrumb = array();
        $breadcrumb[] = array(
            'title' => __('home_title'),
            'url' => Router::url(array('controller' => 'DashBoard', 'action' => 'index'))
        );
        $breadcrumb[] = array(
            'title' => __('bundle_title'),
            'url' => Router::url(array('action' => $this->action)),
        );
        $this->set('breadcrumb', $breadcrumb);
    }

    protected function setInit() {

        $this->set('model_class', $this->modelClass);
    }

}
