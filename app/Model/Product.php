<?php

App::uses('AppModel', 'Model');

class Product extends AppModel {

    public $actsAs = array(
        'Search.Searchable'
    );
    public $filterArgs = array(
        'code' => array(
            'type' => 'like',
            'field' => 'code'
        ),
        'alias' => array(
            'type' => 'like',
            'field' => 'alias'
        ),
        'name' => array(
            'type' => 'like',
            'field' => 'name'
        ),
        'color' => array(
            'type' => 'like',
            'field' => 'color'
        ),
        'size' => array(
            'type' => 'like',
            'field' => 'size'
        ),
        'price' => array(
            'type' => 'like',
            'field' => 'price'
        ),
    );
    public $validate = array(
        'name' => array(
            'maxLength' => array(
                'rule' => array('maxLength', 255),
                'message' => 'validate_name_max_lenght',
            ),
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'validate_notBlank',
            ),
        ),
        'code' => array(
            'maxLength' => array(
                'rule' => array('maxLength', 255),
                'message' => 'validate_name_max_lenght',
            ),
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'validate_notBlank',
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
                'required' => 'create',
                'message' => 'validate_isUnique',
            ),
        ),
        'alias' => array(
            'maxLength' => array(
                'rule' => array('maxLength', 255),
                'message' => 'validate_name_max_lenght',
            ),
        ),
        'color' => array(
            'maxLength' => array(
                'rule' => array('maxLength', 255),
                'message' => 'validate_name_max_lenght',
            ),
        ),
        'size' => array(
            'maxLength' => array(
                'rule' => array('maxLength', 255),
                'message' => 'validate_name_max_lenght',
            ),
            'numeric' => array(
                'rule' => 'numeric',
                'message' => 'validate_numeric',
            ),
        ),
        'price' => array(
            'numeric' => array(
                'rule' => 'numeric',
                'message' => 'validate_numeric',
            ),
        ),
    );

    public function beforeSave($options = array()) {
        parent::beforeSave($options);

        if (empty($this->data[$this->alias]['id']) && !isset($this->data[$this->alias]['alias'])) {
            $this->data[$this->alias]['alias'] = $this->data[$this->alias]['code'];
        }
    }

    public function beforeValidate($options = array()) {
        parent::beforeValidate($options);

        // nếu thực hiện clone
        if ($this->clone) {
            $color = !empty($this->data[$this->alias]['color']) ? $this->data[$this->alias]['color'] : '';
            $size = !empty($this->data[$this->alias]['size']) ? $this->data[$this->alias]['size'] : '';
            if (empty($color) && empty($size)) {
                $this->validationErrors['color'][] = __('validate_color_size_notBlank');
                $this->validationErrors['size'][] = __('validate_color_size_notBlank');
                return false;
            }
            $is_clone_exist = $this->isCloneExists($color, $size);
            if ($is_clone_exist && empty($color)) {
                $this->validationErrors['size'][] = __('validate_color_isUnique');
                return false;
            } elseif ($is_clone_exist && empty($size)) {
                $this->validationErrors['color'][] = __('validate_size_isUnique');
                return false;
            } elseif ($is_clone_exist) {
                $this->validationErrors['color'][] = __('validate_color_size_isUnique');
                $this->validationErrors['size'][] = __('validate_color_size_isUnique');
                return false;
            }
        }
        return true;
    }

    protected function isCloneExists($color, $size) {

        $options = array(
            'recursive' => -1,
        );
        if (!empty($color)) {
            $options['conditions']['color'] = $color;
        }
        if (!empty($size)) {
            $options['conditions']['size'] = $size;
        }
        $check = $this->find('first', $options);
        if (empty($check)) {
            return false;
        }
        return true;
    }

}
