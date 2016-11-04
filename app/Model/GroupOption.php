<?php
App::uses('AppModel', 'Model');

/**
 * orders Model
 *
 * @property Group $Group
 * @property FbCustomer $FbCustomer
 * @property FbPage $FbPage
 * @property FbPost $FbPost
 * @property FbComment $FbComment
 * @property ShippingService $ShippingService
 * @property Bundle $Bundle
 * @property Status $Status
 * @property Duplicate $Duplicate
 * @property Product $Product
 */
class GroupOption extends AppModel
{
    public $useTable = 'group_options';
    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'key' => array(
            'rule1' => array(
                'rule' => 'alphaNumericDashUnderscore',
                'message' => 'Key không được có ký tự đặc biệt'
            ),
            'rule2' => array(
                'rule' => array('isUnique', array('key', 'group_id'), false),
                'message' => 'This key has already been taken.'
            )
        ),
        'group_id' => array(
            'rule' => 'naturalNumber',
            'message' => 'group_id phải là số lớn hơn 0'
        )
    );

    // The Associations below have been created with all possible keys, those that are not needed can be removed
}
