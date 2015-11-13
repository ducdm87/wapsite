<?php
include_once dirname ( __FILE__ ) . '/CreateElement.inc';
class CreateProperties extends CreateElement {
	private static $_instance = NULL;
	public function __construct() {
		$this->_debug = Debug::getInstance ();
	}
	public function __destruct() {
	}
	public function __toString() {
		return $this->_xml;
	}
	public static function getInstance() {
		if (self::$_instance == NULL) {
			self::$_instance = new CreateProperties ();
		}
		return self::$_instance;
	}
	public function CreateProperties() {
		$generalProperties = array (
				'title',
				'subject',
				'creator',
				'keywords',
				'description',
				'category',
				'contentStatus' 
		);
		$nameSpaces = array (
				'title' => 'dc',
				'subject' => 'dc',
				'creator' => 'dc',
				'keywords' => 'cp',
				'description' => 'dc',
				'category' => 'cp',
				'contentStatus' => 'cp' 
		);
		$nameSpacesURI = array (
				'dc' => 'http://purl.org/dc/elements/1.1/',
				'cp' => 'http://schemas.openxmlformats.org/package/2006/metadata/core-properties',
				'dcterms' => 'http://purl.org/dc/terms/' 
		);
		$args = func_get_args ();
		$basePath = $args [1];
		try {
			$coreProps = fopen ( $basePath . '/docProps/core.xml', "r+" );
			if (! $coreProps) {
				throw new Exception ( 'Error while trying to read the properties file' );
			}
		} catch ( Exception $e ) {
			exit ( $e->getMessage () );
		}
		$coreContents = fread ( $coreProps, filesize ( $basePath . '/docProps/core.xml' ) );
		$coreDocument = new DOMDocument ();
		$coreDocument->loadXML ( $coreContents );
		foreach ( $args [0] as $key => $value ) {
			if (in_array ( $key, $generalProperties )) {
				$coreNodes = $coreDocument->getElementsByTagName ( $key );
				if ($coreNodes->length > 0) {
					$coreNodes->item ( 0 )->nodeValue = $value;
				} else {
					$strNode = '<' . $nameSpaces [$key] . ':' . $key . ' xmlns:' . $nameSpaces [$key] . '="' . $nameSpacesURI [$nameSpaces [$key]] . '">' . $value . '</' . $nameSpaces [$key] . ':' . $key . '>';
					$tempNode = $coreDocument->createDocumentFragment ();
					$tempNode->appendXML ( $strNode );
					$coreDocument->documentElement->appendChild ( $tempNode );
				}
			}
		}
		$rewriteCoreProps = fopen ( $basePath . '/docProps/core.xml', "w+" );
		$propData = $coreDocument->saveXML ();
		fwrite ( $rewriteCoreProps, $propData );
	}
	public function createPropertiesApp() {
		$appProperties = array (
				'Manager',
				'Company' 
		);
		$args = func_get_args ();
		$basePath = $args [1];
		try {
			$appProps = fopen ( $basePath . '/docProps/app.xml', "r+" );
			if (! $appProps) {
				throw new Exception ( 'Error while trying to read the properties file' );
			}
		} catch ( Exception $e ) {
			exit ( $e->getMessage () );
		}
		$appContents = fread ( $appProps, filesize ( $basePath . '/docProps/app.xml' ) );
		$appDocument = new DOMDocument ();
		$appDocument->loadXML ( $appContents );
		foreach ( $args [0] as $key => $value ) {
			if (in_array ( $key, $appProperties )) {
				$appNodes = $appDocument->getElementsByTagName ( $key );
				if ($appNodes->length > 0) {
					$appNodes->item ( 0 )->nodeValue = $value;
				} else {
					$strNode = '<' . $key . '>' . $value . '</' . $key . '>';
					$tempNode = $appDocument->createDocumentFragment ();
					$tempNode->appendXML ( $strNode );
					$appDocument->documentElement->appendChild ( $tempNode );
				}
			}
		}
		$rewriteAppProps = fopen ( $basePath . '/docProps/app.xml', "w+" );
		fwrite ( $rewriteAppProps, $appDocument->saveXML () );
	}
	public function createPropertiesCustom() {
		$tagName = array (
				'text' => 'lpwstr',
				'date' => 'filetime',
				'number' => 'r8',
				'boolean' => 'bool' 
		);
		$args = func_get_args ();
		$basePath = $args [1];
		if (file_exists ( $basePath . '/docProps/custom.xml' )) {
			$customProps = fopen ( $basePath . '/docProps/custom.xml', "r+" );
			$customContents = fread ( $customProps, filesize ( $basePath . '/docProps/custom.xml' ) );
		} else {
			$customContents = '<?xml version="1.0" encoding="UTF-8" standalone="yes" ?><Properties xmlns:vt="http://schemas.openxmlformats.org/officeDocument/2006/docPropsVTypes" xmlns="http://schemas.openxmlformats.org/officeDocument/2006/custom-properties"></Properties>';
			try {
				$relsProps = fopen ( $basePath . '/_rels/.rels', "r+" );
				if (! $relsProps) {
					throw new Exception ( 'Error while trying to read the _rels/.rels file' );
				}
			} catch ( Exception $e ) {
				exit ( $e->getMessage () );
			}
			$relsContents = fread ( $relsProps, filesize ( $basePath . '/_rels/.rels' ) );
			$relsDocument = new DOMDocument ();
			$relsDocument->loadXML ( $relsContents );
			$strCustom = '<Relationship Id="rId' . rand ( 999, 9999 ) . '" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/custom-properties" Target="docProps/custom.xml" />';
			$tempNode = $relsDocument->createDocumentFragment ();
			$tempNode->appendXML ( $strCustom );
			$relsDocument->documentElement->appendChild ( $tempNode );
			$rewriteRelsProps = fopen ( $basePath . '/_rels/.rels', "w+" );
			fwrite ( $rewriteRelsProps, $relsDocument->saveXML () );
		}
		$strNode = "";
		foreach ( $args [0] as $key => $value ) {
			$myKey = array_keys ( $value );
			$myValue = array_values ( $value );
			if (array_key_exists ( $myKey [0], $tagName )) {
				$customDocument = new DOMDocument ();
				$customDocument->loadXML ( $customContents );
				$customNodes = $customDocument->getElementsByTagName ( 'property' );
				$numberNodes = $customNodes->length;
				if ($numberNodes > 0) {
					for($j = 0; $j < $numberNodes; $j ++) {
						if ($customNodes->item ( $j )->getAttribute ( 'name' ) == $key) {
							$customNodes->item ( $j )->firstChild->nodeValue = $myValue [0];
						} else {
							$strNode .= '<property fmtid="{D5CDD505-2E9C-101B-9397-08002B2CF9AE}" pid="' . rand ( 999, 99999999 ) . '" name="' . $key . '"><vt:' . $tagName [$myKey [0]] . ' xmlns:vt="http://schemas.openxmlformats.org/officeDocument/2006/docPropsVTypes">' . $myValue [0] . '</vt:' . $tagName [$myKey [0]] . '></property>';
						}
					}
				} else {
					$strNode .= '<property fmtid="{D5CDD505-2E9C-101B-9397-08002B2CF9AE}" pid="' . rand ( 999, 99999999 ) . '" name="' . $key . '"><vt:' . $tagName [$myKey [0]] . ' xmlns:vt="http://schemas.openxmlformats.org/officeDocument/2006/docPropsVTypes">' . $myValue [0] . '</vt:' . $tagName [$myKey [0]] . '></property>';
				}
			}
		}
		if ($strNode != '') {
			$tempNode = $customDocument->createDocumentFragment ();
			$tempNode->appendXML ( $strNode );
			$customDocument->documentElement->appendChild ( $tempNode );
		}
		$rewriteCustomProps = fopen ( $basePath . '/docProps/custom.xml', "w+" );
		$propData = str_replace ( 'xmlns:vt="http://schemas.openxmlformats.org/officeDocument/2006/docPropsVTypes">', '>', $customDocument->saveXML () );
		fwrite ( $rewriteCustomProps, $propData );
	}
}
?>