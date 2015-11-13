<?php
require_once('admin'.EXT);
class Backup extends admin{
	function __construct()
	{
		parent::__construct();	
	}
	
	function database()
	{
		// Load the DB utility class
		$this->load->dbutil();
		
		$this->load->helper(array('download','upload'));
		
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			// Backup your entire database and assign it to a variable
			$time = time();
			$prefs = array(
                //'tables'      => array('table1', 'table2'),  // Array of tables to backup.
                'ignore'      => array(),           // List of tables to omit from the backup
                'format'      => 'txt',             // gzip, zip, txt
                'filename'    => 'db_'.$time.'.sql',    // File name - NEEDED ONLY WITH ZIP FILES
                'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
                'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
                'newline'     => "\n"               // Newline character used in backup file
              );
			$backup =& $this->dbutil->backup($prefs);
			
			// Load the file helper and write the file to your server
			$this->load->helper('file');
			
			$dir = BASEPATH.'db/';
			if(!is_dir($dir))
				create_dir($dir);
			write_file($dir.$time.'.gz', $backup);
			
			// Load the download helper and send the file to your desktop
			
			force_download('db_'.$time.'.gz', $backup); 
		}
		
		echo "<form method=\"POST\" action=\"\">";
			echo "<input type=\"submit\" value=\"Back up Database\"/>";
		echo "</form>";
		
	}
}