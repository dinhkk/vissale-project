<?php
require_once dirname ( __FILE__ ) . '/APCCaching.php';
require_once dirname ( __FILE__ ) . '/CachingConfiguration.php';
require_once dirname ( __FILE__ ) . '/../logger/LoggerConfiguration.php';
use caching\APC\APCCaching;
class FBSCaching {
	private $caching = null;
	public function __construct() {
		$this->caching = new APCCaching ();
	}
	public function genCacheKey($params) {
		$key = '';
		foreach ( $params as $k => $val ) {
			$val = trim ( strval ( $val ) );
			if ($val === '')
				continue;
			$key .= "$k=$val&";
		}
		$key = CachingConfiguration::CACHING_NAMESPACE . md5 ( $key );
		LoggerConfiguration::logInfo ( "Cache key=$key" );
		return $key;
	}
	public function store($params, &$data, $ttl = 0) {
		if (! CachingConfiguration::ALLOW_CACHE) {
			LoggerConfiguration::logInfo ( 'Caching had disabled' );
			return null;
		}
		try {
			return $this->caching->store ( $this->genCacheKey ( $params ), $data, $ttl );
		} catch ( Exception $e ) {
			LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION__, __LINE__ );
			return false;
		}
	}
	public function get($params) {
		if (! CachingConfiguration::ALLOW_CACHE) {
			LoggerConfiguration::logInfo ( 'Caching had disabled' );
			return null;
		}
		try {
			return $this->caching->fetch ( $this->genCacheKey ( $params ) );
		} catch ( Exception $e ) {
			LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION__, __LINE__ );
			return false;
		}
	}
	public function remove($params) {
		if (! CachingConfiguration::ALLOW_CACHE) {
			LoggerConfiguration::logInfo ( 'Caching had disabled' );
			return null;
		}
		try {
			return $this->caching->delete ( $this->genCacheKey ( $params ) );
		} catch ( Exception $e ) {
			LoggerConfiguration::logError ( $e->getMessage (), __CLASS__, __FUNCTION__, __LINE__ );
			return false;
		}
	}
	
	// clear all cache
	public function clearCache() {
		$toDelete = new APCIterator ( 'user', '/^' . CachingConfiguration::CACHING_NAMESPACE . '/', APC_ITER_VALUE );
		return apc_delete ( $toDelete );
	}
}