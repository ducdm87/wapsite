<?php
class PhpdocxUtilities {
	private static $_phpdocxConfig;
	public static function isUtf8($string_input) {
		$string = $string_input;
		$string = preg_replace ( "#[\x09\x0A\x0D\x20-\x7E]#", "", $string );
		$string = preg_replace ( "#[\xC2-\xDF][\x80-\xBF]#", "", $string );
		$string = preg_replace ( "#\xE0[\xA0-\xBF][\x80-\xBF]#", "", $string );
		$string = preg_replace ( "#[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}#", "", $string );
		$string = preg_replace ( "#\xED[\x80-\x9F][\x80-\xBF]#", "", $string );
		$string = preg_replace ( "#\xF0[\x90-\xBF][\x80-\xBF]{2}#", "", $string );
		$string = preg_replace ( "#[\xF1-\xF3][\x80-\xBF]{3}#", "", $string );
		$string = preg_replace ( "#\xF4[\x80-\x8F][\x80-\xBF]{2}#", "", $string );
		return ($string == "" ? true : false);
	}
	public static function parseConfig() {
		if (! isset ( self::$_phpdocxConfig )) {
			self::$_phpdocxConfig = parse_ini_file ( dirname ( __FILE__ ) . '/../config/phpdocxconfig.ini', true );
		}
		return self::$_phpdocxConfig;
	}
	public static function uniqueId() {
		$uniqueid = uniqid ( 'phpdocx_' );
		return $uniqueid;
	}
}
?>