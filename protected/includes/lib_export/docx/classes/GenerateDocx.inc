<?php
class GenerateDocx {
	public static function beginDocx() {
		$xzerod = '';
		$xzerob = '';
		$xzeroc = '';
		$phpdocxconfig = PhpdocxUtilities::parseConfig ();
		if (! isset ( $_SERVER ['SERVER_NAME'] )) {
			return;
		} else {
			$xzerod = trim ( $phpdocxconfig ['license'] ['code'] );
			$xzerob = trim ( gethostbyname ( $_SERVER ['SERVER_NAME'] ) );
			$xzeroc = trim ( $_SERVER ['SERVER_NAME'] );
			$xzeroa = trim ( $phpdocxconfig ['license'] ['email'] );
		}
		if (preg_match ( '/^192.168./', $xzeroc ) || preg_match ( '/^172./', $xzeroc ) || preg_match ( '/^192.168./', $xzerob ) || preg_match ( '/^172./', $xzerob ) || preg_match ( '/^10./', $xzerob ) || preg_match ( '/^127./', $xzerob ) || preg_match ( '/localhost/', $xzeroc )) {
			return;
		} elseif ($xzerod == md5 ( $xzeroc . $xzeroa . '_docx' )) {
			return;
		} elseif (! preg_match ( '/^www./', $xzeroc )) {
			$xzeroc = 'www.' . $xzeroc;
		}
		if ($xzerod == md5 ( $xzeroc . $xzeroa . '_docx' )) {
			return;
		}
		throw new Exception ( 'There is not a valid license' );
	}
}
?>