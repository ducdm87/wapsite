<?php
class PhpdocxLogger1 {
	private static $_log = NULL;
	public static function logger($message, $level) {
		$levels = array (
				'debug',
				'info',
				'notice',
				'warning',
				'error',
				'fatal' 
		);
		if (! self::$_log) {
			Logger::configure ( dirname ( __FILE__ ) . '/../config/log4php.xml' );
			self::$_log = Logger::getLogger ( 'phpdocx_logger' );
		}
		if (in_array ( $level, $levels )) {
			$stringLevel = strtolower ( $level );
			self::$_log->info ( $message );
			if ($level == 'fatal') {
				throw new Exception ( $message );
			}
		}
	}
}
?>