<?php
class CleanTemp {
	private function __construct() {
	}
	public function __destruct() {
	}
	public static function clean($path) {
		if (is_file ( $path )) {
			@unlink ( $path );
		}
		if (! $dh = @opendir ( $path )) {
			return;
		}
		;
		while ( ($obj = readdir ( $dh )) ) {
			if ($obj == '.' || $obj == '..') {
				continue;
			}
			if (! @unlink ( $path . '/' . $obj )) {
				self::clean ( $path . '/' . $obj );
			}
		}
		closedir ( $dh );
		@rmdir ( $path );
	}
}
?>