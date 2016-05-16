<?php

App::uses('AppModel', 'Model');

/**
 * Group Model
 *
 * @property FbUser $FbUser
 * @property BillingPrint $BillingPrint
 * @property Bundle $Bundle
 * @property FbBlacklist $FbBlacklist
 * @property FbConversation $FbConversation
 * @property FbConversationMessage $FbConversationMessage
 * @property FbCronConfig $FbCronConfig
 * @property FbCustomer $FbCustomer
 * @property FbPage $FbPage
 * @property FbPostComment $FbPostComment
 * @property FbPost $FbPost
 * @property Order $Order
 * @property Product $Product
 * @property Role $Role
 * @property ShippingService $ShippingService
 * @property Status $Status
 * @property StockBook $StockBook
 * @property StockDelivering $StockDelivering
 * @property StockReceiving $StockReceiving
 * @property Stock $Stock
 * @property Supplier $Supplier
 * @property Unit $Unit
 * @property User $User
 */
class Group extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'name';

    // The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'BillingPrint' => array(
            'className' => 'BillingPrint',
            'foreignKey' => 'group_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Bundle' => array(
            'className' => 'Bundle',
            'foreignKey' => 'group_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        /* 'FbBlacklist' => array(
          'className' => 'FbBlacklist',
          'foreignKey' => 'group_id',
          'dependent' => false,
          'conditions' => '',
          'fields' => '',
          'order' => '',
          'limit' => '',
          'offset' => '',
          'exclusive' => '',
          'finderQuery' => '',
          'counterQuery' => ''
          ), */
        /* 'FbConversation' => array(
          'className' => 'FbConversation',
          'foreignKey' => 'group_id',
          'dependent' => false,
          'conditions' => '',
          'fields' => '',
          'order' => '',
          'limit' => '',
          'offset' => '',
          'exclusive' => '',
          'finderQuery' => '',
          'counterQuery' => ''
          ), */
        'FbConversationMessage' => array(
            'className' => 'FbConversationMessage',
            'foreignKey' => 'group_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'FBCronConfig' => array(
            'className' => 'FBCronConfig',
            'foreignKey' => 'group_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'FbCustomer' => array(
            'className' => 'FbCustomer',
            'foreignKey' => 'group_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'FbPage' => array(
            'className' => 'FbPage',
            'foreignKey' => 'group_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'FbPostComment' => array(
            'className' => 'FbPostComment',
            'foreignKey' => 'group_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'FbPost' => array(
            'className' => 'FbPost',
            'foreignKey' => 'group_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Order' => array(
            'className' => 'Order',
            'foreignKey' => 'group_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Product' => array(
            'className' => 'Product',
            'foreignKey' => 'group_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Role' => array(
            'className' => 'Role',
            'foreignKey' => 'group_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'ShippingService' => array(
            'className' => 'ShippingService',
            'foreignKey' => 'group_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Status' => array(
            'className' => 'Status',
            'foreignKey' => 'group_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'StockBook' => array(
            'className' => 'StockBook',
            'foreignKey' => 'group_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'StockDelivering' => array(
            'className' => 'StockDelivering',
            'foreignKey' => 'group_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'StockReceiving' => array(
            'className' => 'StockReceiving',
            'foreignKey' => 'group_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Stock' => array(
            'className' => 'Stock',
            'foreignKey' => 'group_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Supplier' => array(
            'className' => 'Supplier',
            'foreignKey' => 'group_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Unit' => array(
            'className' => 'Unit',
            'foreignKey' => 'group_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'group_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );

    public function beforeSave($options = array()) {
        parent::beforeSave($options);

        if (!empty($this->data[$this->alias]['id'])) {
            unset($this->data[$this->alias]['code']);
        }
        return true;
    }

    public function afterSave($created, $options = array()) {
        parent::afterSave($created, $options);

        if ($created) {
            $this->copySystemData();
        }
        return true;
    }

    public function beforeValidate($options = array()) {
        parent::beforeValidate($options);

        if (
                isset($this->data[$this->alias]['group_id']) &&
                isset($this->data[$this->alias]['code'])
        ) {
            $options = array(
                'recursive' => -1,
                'conditions' => array(
                    'group_id' => $this->data[$this->alias]['group_id'],
                    'code' => $this->data[$this->alias]['code'],
                ),
            );
            if (!empty($this->data[$this->alias]['id'])) {
                $options['conditions']['id !='] = $this->data[$this->alias]['id'];
            }
            $exists = $this->find('first', $options);
            if (!empty($exists)) {
                $this->validationErrors['code'] = __('Already taken.');
                return false;
            }
        }
        return true;
    }

    /**
     * copySystemData
     * Thực hiện copy dữ liệu có sẵn của hệ thống sang group mới đang được khởi tạo
     * 
     * @return bool
     */
    protected function copySystemData() {

        $dataSource = $this->getDataSource();
        $dataSource->begin();
        $flag = true;

        // Thực hiện clone cấu hình fb của group hệ thống sang group đang khởi tạo
        $fb_cron_config = $this->FBCronConfig->find('first', array(
            'recursive' => -1,
            'conditions' => array(
                'group_id' => GROUP_SYSTEM_id,
            ),
        ));
        if (!empty($fb_cron_config)) {
            $fb_cron_config_clone = $fb_cron_config[$this->FBCronConfig->alias];
            unset($fb_cron_config_clone['id']);
            $fb_cron_config_clone['group_id'] = $this->id;
            $fb_cron_config_clone['parent_id'] = $fb_cron_config[$this->FBCronConfig->alias]['id'];
            $this->FBCronConfig->create();
            if (!$this->FBCronConfig->save($fb_cron_config_clone)) {
                $flag = false;
            }
        }
        // Thực hiện clone role của group hệ thống sang group đang khởi tạo
        $roles = $this->Role->find('all', array(
            'recursive' => -1,
            'conditions' => array(
                'group_id' => GROUP_SYSTEM_id,
                'level <=' => ADMINGROUP,
            ),
        ));
        if (!empty($roles)) {
            $role_clones = array();
            foreach ($roles as $k => $v) {
                $role_clones[$k] = $v[$this->Role->alias];
                unset($role_clones[$k]['id']);
                $role_clones[$k]['group_id'] = $this->id;
                $role_clones[$k]['parent_id'] = $v[$this->Role->alias]['id'];
            }
            if (!$this->Role->saveAll($role_clones)) {
                $flag = false;
            }
        }
        $user_data = array(
            'username' => $this->data[$this->alias]['code'],
            'name' => $this->data[$this->alias]['name'],
            'phone' => $this->data[$this->alias]['phone'],
            'address' => $this->data[$this->alias]['address'],
            'level' => ADMINGROUP,
            'group_id' => $this->id,
        );
        if (!$this->User->save($user_data)) {
            $flag = false;
        }
        if ($flag) {
            return $dataSource->commit();
        } else {
            return $dataSource->rollback();
        }
    }

    // The Associations below have been created with all possible keys, those that are not needed can be removed
    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'code' => array(
//            'isUnique' => array(
//                'rule' => array('isUnique'),
//                'message' => 'Already taken.'
//            ),
            'username' => array(
                'rule' => 'alphaNumericDashUnderscore',
                'required' => true,
                'message' => 'Letters and numbers only'
            ),
            'between' => array(
                'rule' => array('lengthBetween', 5, 40),
                'message' => 'Must lengthen between 5 and 40 characters.'
            )
        ),
        'phone' => array(
            'rule' => 'isUnique',
            'message' => 'This phone has already been taken.'
        ),
    );

}
