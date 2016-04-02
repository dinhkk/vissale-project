<?php

App::uses('Component', 'Controller');

class SearchCommonComponent extends Component {

    public $controller = '';

    public function initialize(\Controller $controller) {

        parent::initialize($controller);
        $this->controller = $controller;
    }

    public function process(&$options, $request_data = array(), $schema = array(), $model_class = null) {

        if (empty($request_data)) {
            $request_data = $this->controller->request->query;
        }
        // nếu không truyền vào $model_class, lấy mặc định là Model chính tương ứng với controller
        if (empty($model_class)) {
            $model_class = $this->controller->modelClass;
        }
        // nếu không truyền vào $schemas, lấy mặc định schema tương ứng với $model_class
        if (empty($schema)) {
            $schema = $this->controller->$model_class->schema();
        }
        if (empty($request_data) || !is_array($request_data)) {
            return;
        }
        foreach ($request_data as $k => $v) {
            
        }
    }

}
