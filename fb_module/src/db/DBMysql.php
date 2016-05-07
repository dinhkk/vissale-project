<?php
require_once dirname ( __FILE__ ) . '/../logger/LoggerConfiguration.php';
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
	private $_host = '103.28.38.130';
	private $_username = 'root';
	private $_password = 't2C&D9X74auS';
	private $_database = 'fb_8386_dev';
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
		LoggerConfiguration::logInfo ( 'CONNECT TO DB' );
		$this->_connection = new mysqli ( $this->_host, $this->_username, $this->_password, $this->_database );
		
		// Error handling
		if ($this->error = mysqli_connect_error ()) {
			LoggerConfiguration::logError ( "Failed to connect to MySQL: {$this->error}", __CLASS__, __FUNCTION__, __LINE__ );
		}
		else
			mysqli_set_charset($this->_connection,'utf8');
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
				LoggerConfiguration::logInfo ( 'CLOSE DB' );
				mysqli_close ( $this->_connection );
				$this->_connection = null;
				self::$_instance = null;
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