<?php
/**
 * Order Fixture
 */
class OrderFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'group_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'fb_customer_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'fb_page_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'fb_post_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'fb_comment_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'total_qty' => array('type' => 'integer', 'null' => true, 'default' => '1', 'unsigned' => false),
		'code' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'postal_code' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'customer_name' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'mobile' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'telco_code' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'city' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'address' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'note1' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'note2' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'cancel_note' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'shipping_note' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'is_top_priority' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 4, 'unsigned' => false),
		'is_send_sms' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 4, 'unsigned' => false),
		'is_inner_city' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 4, 'unsigned' => false),
		'shipping_service_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'bundle_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'status_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'price' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false),
		'discount_price' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false),
		'shipping_price' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false),
		'other_price' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false),
		'total_price' => array('type' => 'integer', 'null' => true, 'default' => '0', 'unsigned' => false),
		'weight' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'duplicate_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'duplicate_note' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 500, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'user_confirmed' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'user_assigned' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'user_created' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'user_modified' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'confirmed' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'delivered' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'group_id' => 1,
			'fb_customer_id' => 1,
			'fb_page_id' => 1,
			'fb_post_id' => 1,
			'fb_comment_id' => 1,
			'total_qty' => 1,
			'code' => 'Lorem ipsum dolor sit amet',
			'postal_code' => 'Lorem ipsum dolor sit amet',
			'customer_name' => 'Lorem ipsum dolor sit amet',
			'mobile' => 'Lorem ipsum dolor sit amet',
			'telco_code' => 'Lorem ipsum dolor sit amet',
			'city' => 'Lorem ipsum dolor sit amet',
			'address' => 'Lorem ipsum dolor sit amet',
			'note1' => 'Lorem ipsum dolor sit amet',
			'note2' => 'Lorem ipsum dolor sit amet',
			'cancel_note' => 'Lorem ipsum dolor sit amet',
			'shipping_note' => 'Lorem ipsum dolor sit amet',
			'is_top_priority' => 1,
			'is_send_sms' => 1,
			'is_inner_city' => 1,
			'shipping_service_id' => 1,
			'bundle_id' => 1,
			'status_id' => 1,
			'price' => 1,
			'discount_price' => 1,
			'shipping_price' => 1,
			'other_price' => 1,
			'total_price' => 1,
			'weight' => 1,
			'duplicate_id' => 1,
			'duplicate_note' => 'Lorem ipsum dolor sit amet',
			'user_confirmed' => 1,
			'user_assigned' => 1,
			'user_created' => 1,
			'user_modified' => 1,
			'confirmed' => '2016-03-30 14:15:21',
			'delivered' => '2016-03-30 14:15:21',
			'created' => '2016-03-30 14:15:21',
			'modified' => '2016-03-30 14:15:21'
		),
	);

}
