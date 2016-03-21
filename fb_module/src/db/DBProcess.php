<?php
require_once dirname ( __FILE__ ) . '/../logger/LoggerConfiguration.php';
require_once dirname ( __FILE__ ) . '/DBMysql.php';
class DBProcess {
	protected $prefix = 'gom_';
	public $error = null;
	private $connection = null;
	public function __construct() {
		try {
			$this->connection = DBMysql::getInstance ();
		} catch ( Exception $e ) {
			$this->error = $e->getMessage ();
		}
	}
	protected function getConnection() {
		return $this->connection->getConnection ();
	}
	protected function real_escape_string($str) {
		return mysqli_real_escape_string ( $this->getConnection (), $str );
	}
	protected function free_result(&$result) {
		return mysqli_free_result ( $result );
	}
	protected function query($query) {
		try {
			return mysqli_query ( $this->connection->getConnection (), $query );
		} catch ( Exception $e ) {
			$this->error = $e->getMessage ();
			return false;
		}
	}
	protected function set_auto_commit($mode) {
		return mysqli_autocommit ( $this->connection->getConnection (), $mode );
	}
	protected function commit() {
		return mysqli_commit ( $this->connection->getConnection () );
	}
	protected function rollback() {
		return mysqli_rollback ( $this->connection->getConnection () );
	}
	protected function insert_id() {
		return mysqli_insert_id ( $this->connection->getConnection () );
	}
	protected function get_error() {
		return mysqli_error ( $this->connection->getConnection () );
	}
}