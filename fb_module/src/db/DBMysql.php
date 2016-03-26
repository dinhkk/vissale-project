<?php
/*
 * Mysql database class - only one connection alowed
 */
class DBMysql {
	public $error = null;
	private $_connection = null;
	private static $_instance; // The single instance
	                           // private $_host = "203.162.123.171";
	                           // private $_username = "phpfox";
	                           // private $_password = "KL46zrJHbBBeuuwK";
	                           // private $_database = "phpfox";
	private $_host = '45.117.80.243';
	private $_username = 'fbsale';
	private $_password = '@abc12345';
	private $_database = 'fbsale_dinhkk_com';
	/*
	 * Get an instance of the Database
	 * @return Instance
	 */
	public static function getInstance() {
		if (! self::$_instance) { // If no instance then make one
			self::$_instance = new self ();
		}
		return self::$_instance;
	}
	// Constructor
	private function __construct() {
		$this->_connection = new mysqli ( $this->_host, $this->_username, $this->_password, $this->_database );
		
		// Error handling
		if (mysqli_connect_error ()) {
			trigger_error ( 'Failed to connect to MySQL: ' . mysqli_connect_error (), E_USER_ERROR );
		}
	}
	// Magic method clone is empty to prevent duplication of connection
	private function __clone() {
	}
	// Get mysqli connection
	public function getConnection() {
		return $this->_connection;
	}
	public function close() {
		try {
			if ($this->_connection) {
				mysqli_close ( $this->_connection );
				$this->_connection = null;
			}
			return null;
		} catch ( Exception $e ) {
			$this->error = $e->getMessage ();
			return false;
		}
	}
	public function __destruct() {
		return $this->close ();
	}
}