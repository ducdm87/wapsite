<?php
class EmbedHTML extends CreateElement implements EmbedDocument {
	private $_id = 0;
	private static $_instance = NULL;
	protected $_xml = '';
	public function __construct() {
	}
	public function __destruct() {
	}
	public function __toString() {
		return $this->_xml;
	}
	public static function getInstance() {
		if (self::$_instance == NULL) {
			self::$_instance = new EmbedHTML ();
		}
		return self::$_instance;
	}
	public function getId() {
		return $this->_id;
	}
	public function embed($matchSource = false) {
		$this->_xml = '';
		$this->_id ++;
		$this->generateALTCHUNK ();
	}
	public function generateALTCHUNK($matchSource = false) {
		$this->_xml = '<' . CreateElement::NAMESPACEWORD . ':altChunk r:id="rHTMLId' . $this->_id . '" ' . 'xmlns:r="http://schemas.openxmlformats.org/' . 'officeDocument/2006/relationships" ' . 'xmlns:w="http://schemas.openxmlformats.org/' . 'wordprocessingml/2006/main" />';
	}
}
?>