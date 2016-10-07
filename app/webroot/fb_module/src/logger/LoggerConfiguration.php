<?php
require_once dirname ( __FILE__ ) . '/KLogger.php';
class LoggerConfiguration {
	const LOG_FILE = '/tmp/logs/fbsalev2/';
	const LOG_PRIORITY = KLogger::DEBUG;
	const ALLOW_LOG = true;
	const LOG_CONSOLE = false;
	private static $loggerInstance = null;
	private static $loggerErrorInstance = null;
	static function init($log_file, $log_console = self::LOG_CONSOLE) {
		if (!self::ALLOW_LOG){
			return false;
		}
		if (self::$loggerInstance === null) {
		    $whoami = self::whoami();
			$log_file = self::LOG_FILE . "/{$whoami}/{$log_file}";
			$dir = dirname ( $log_file );
			if (! file_exists ( $dir )) {
				if (! mkdir ( $dir, 0777, TRUE )) {
					return false;
				}
			}
			self::$loggerInstance = new KLogger ( $log_file, LoggerConfiguration::LOG_PRIORITY, empty ( $log_console ) ? self::LOG_CONSOLE : $log_console );
			self::$loggerErrorInstance = new KLogger ( self::LOG_FILE . 'error.log', LoggerConfiguration::LOG_PRIORITY, empty ( $log_console ) ? self::LOG_CONSOLE : $log_console );
		}
		return self::$loggerInstance;
	}
	private static function whoami(){
	    return exec('whoami');
	}
	private static $rand = null;
	static function getRand(){
	    if (self::$rand===null){
	        self::$rand = rand(100,999999);
	    }
	    return self::$rand;
	}
	public static function logInfo($msg) {
		if (self::$loggerInstance) {
			self::$loggerInstance->LogInfo ( '[' . self::getRand() . ']' . $msg );
		}
	}
	public static function logError($msg, $class, $function, $line) {
		self::logInfo ( $msg );
		if (self::$loggerErrorInstance)
			self::$loggerErrorInstance->LogError ( "{$class}::{$function}, line:$line => $msg" );
	}
	public static function overrideLogger($log_file, $log_console = self::LOG_CONSOLE) {
		self::$loggerInstance = null;
		self::init ( $log_file, $log_console );
	}
}
date_default_timezone_set ( 'Asia/Ho_Chi_Minh' );
$current_time = date ( 'YmdH' );
$current_month = date ( 'Ym' );
LoggerConfiguration::init ( "{$current_month}/{$current_time}.log" );