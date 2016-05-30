<?php

App::uses('Component', 'Controller');

class PermLimitComponent extends Component {

    public $controller = '';
    public $allowedActions = array(); // những action ngoại lệ không áp dụng hạn chế quyền

    public function initialize(\Controller $controller) {
        parent::initialize($controller);

        $this->controller = $controller;
    }

    public function startup(\Controller $controller) {
        parent::startup($controller);

        // nếu action hiện tại thuộc vào allowedActions thì luôn cho phép
        if (in_array($controller->action, $this->allowedActions)) {
            return true;
        }
        $user = CakeSession::read('Auth.User');
        if (empty($user)) {
//            return $this->controller->redirect($this->controller->Auth->loginRedirect);
            return true;
        }
        // nếu không có quyền thực hiện chuyển hướng về màn hình trước đó
        $perm = $this->controller->name . '/' . $this->controller->action;
        $data_encode = CakeSession::read('Auth.User.data');
        $data = json_decode($data_encode, true);
        if (empty($data)) {
            return true;
        }
        $perm_code = !empty($data['perm_code']) ? $data['perm_code'] : array();
        if (empty($perm_code)) {
            return true;
        }
        // nếu action hiện tại không nằm trong nhóm quyền của user
        if (!in_array($perm, $perm_code)) {
            return $this->controller->redirect(array(
                        'controller' => 'Orders',
                        'action' => 'index',
            ));
        }

        return true;
    }

    public function allow($action = null) {

        $args = func_get_args();
        if (empty($args) || $action === null) {
            $this->allowedActions = $this->controller->methods;
            return;
        }
        if (isset($args[0]) && is_array($args[0])) {
            $args = $args[0];
        }
        $this->allowedActions = array_merge($this->allowedActions, $args);
    }

}
