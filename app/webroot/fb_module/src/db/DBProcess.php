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
	public function getConnection() {
		return $this->connection->getConnection ();
	}
	protected function real_escape_string($str) {
		return mysqli_real_escape_string ( $this->connection->getConnection (), $str );
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
	public function set_auto_commit($mode) {
		return mysqli_autocommit ( $this->connection->getConnection (), $mode );
	}
	public function commit() {
		return mysqli_commit ( $this->connection->getConnection () );
	}
	public function rollback() {
		return mysqli_rollback ( $this->connection->getConnection () );
	}
	protected function insert_id() {
		return mysqli_insert_id ( $this->connection->getConnection () );
	}
	protected function get_error() {
		return $this->error?$this->error:mysqli_error($this->connection->getConnection ());
	}
	protected function affected_rows() {
		return mysqli_affected_rows ( $this->getConnection () );
	}
	protected function num_rows(&$result) {
	    return mysqli_num_rows($result);
	}
}