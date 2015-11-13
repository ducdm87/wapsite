<?php
interface EmbedDocument {
	function getId();
	function embed($matchSource = null);
	function generateALTCHUNK($matchSource = null);
}
?>