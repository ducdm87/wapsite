<?php
class Repair {
	private static $_instance = NULL;
	private $_xml = array ();
	private function __construct() {
	}
	public function __destruct() {
	}
	public function __toString() {
		return $this->_xml;
	}
	public static function getInstance() {
		if (self::$_instance == NULL) {
			self::$_instance = new Repair ();
		}
		return self::$_instance;
	}
	public function getXML() {
		return $this->_xml;
	}
	public function setXML($xml) {
		$xml = preg_replace("/<w\:r>.*?<\/w\:r>/ism",'', $xml);
		$this->_xml = $xml;
	}
	public function addParapraphEmptyTablesTags() {
		$this->_xml = preg_replace ( '/<w:tc>[\s]*?<\/w:tc>/', '<w:tc><w:p /></w:tc>', $this->_xml );
		$this->_xml = preg_replace ( '/<\/w:tbl>[\s]*?<\/w:tc>/', '</w:tbl><w:p /></w:tc>', $this->_xml );
		$this->_xml = preg_replace ( '/<\/w:tbl>[\s]*?<w:tbl>/', '</w:tbl><w:p /><w:tbl>', $this->_xml );
	}
}
?>