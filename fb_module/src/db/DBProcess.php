<?php
require_once dirname ( __FILE__ ) . '/DBMysql.php';
class DBProcess {
	public $prefix = 'gom_';
	public $error = null;
	private $connection = null;
	public function __construct() {
		try {
			$this->connection = DBMysql::getInstance ();
		} catch ( Exception $e ) {
			$this->error = $e->getMessage ();
		}
	}
	public function getConnection() {
		return $this->connection->getConnection ();
	}
	public function real_escape_string($str) {
		return mysqli_real_escape_string ( $this->getConnection (), $str );
	}
	public function free_result(&$result) {
		return mysqli_free_result ( $result );
	}
	public function query($query) {
		try {
			return mysqli_query ( $this->connection->getConnection (), $query );
		} catch ( Exception $e ) {
			$this->error = $e->getMessage ();
			return false;
		}
	}
	public function set_auto_commit($mode) {
		return mysqli_autocommit ( $this->connection->getConnection (), $mode );
	}
	public function commit() {
		return mysqli_commit ( $this->connection->getConnection () );
	}
	public function rollback() {
		return mysqli_rollback ( $this->connection->getConnection () );
	}
	public function insert_id() {
		return mysqli_insert_id ( $this->connection->getConnection () );
	}
	public function get_error() {
		return mysqli_error ( $this->connection->getConnection () );
	}
}