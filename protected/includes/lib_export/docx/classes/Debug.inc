<?php
class Debug {
	private $_active;
	private static $_instance = null;
	private $_messages;
	private $_templateMessage;
	public function __construct() {
	}
	public function __destruct() {
	}
	public function __toString() {
		if ($this->_active) {
			$this->generateTemplate ();
			return $this->_templateMessage;
		}
	}
	public static function getInstance() {
		if (self::$_instance == NULL) {
			self::$_instance = new Debug ();
		}
		return self::$_instance;
	}
	public function setMessages($messages) {
		$this->_messages = $messages;
	}
	public function getMessages() {
		return $this->_messages;
	}
	public function setActive($active) {
		$this->_active = $active;
	}
	public function getActive() {
		return $this->_active;
	}
	public function addMessage($message) {
		$this->_messages [] = $message;
	}
	public function enableDebug() {
		$this->_messages = array ();
		$this->setActive ( 1 );
	}
	public function fDisableDebug() {
		$this->setActive ( 0 );
	}
	protected function generateTemplate() {
		$this->_templateMessage = '<html xmlns="http://www.w3.org/1999/xhtml"' . 'xml:lang="es" lang="es"><head></head><body><ul>';
		foreach ( $this->_messages as $dat ) {
			if (is_array ( $dat )) {
				foreach ( $this->_messages as $unkDatArr ) {
					if (is_array ( $unkDatArr )) {
						foreach ( $unkDatArr as $xmlErrorDat ) {
							$this->_templateMessage .= '<li>' . $xmlErrorDat->message . '</li>';
						}
					} else {
						$this->_templateMessage .= '<li>' . $unkDatArr . '</li>';
					}
				}
			} else {
				$this->_templateMessage .= '<li>' . $dat . '</li>';
			}
		}
		$this->_templateMessage .= '</ul></body></html>';
	}
}
?>