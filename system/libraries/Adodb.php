<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//die('test');

class CI_Adodb {

	var $adodb;

	function __construct($config = array())
	{
		include(APPPATH.'config/appconfig'.EXT);

		if (!isset($dbconf) OR count($dbconf) == 0)
		{
			show_error('No database connection settings were found in the database config file.');
		}

		include(BASEPATH.'/libraries/adodb5/adodb.inc.php');

        /*cara lama ga ada port sedih amat */
		$this->adodb = ADONewConnection($dbconf['dbdriver']);
		$this->adodb->debug = $dbconf['db_debug'];
        
        if(!$this->adodb->PConnect($dbconf['hostname'], $dbconf['username'], $dbconf['password'], $dbconf['database']))
        {
			show_error('Connection Error');
			log_message('debug', "Connection Error");
		}
        
        
        /*cara dua
        $dsn = $dbconf['dbdriver'].'://'.$dbconf['username'].':'.$dbconf['password'].'@'.$dbconf['hostname'].':'.$dbconf['port'].'/'.$dbconf['database'];
        
        if(!$this->adodb = ADONewConnection($dsn))
        {
			show_error('Connection Error');
			log_message('debug', "Connection Error");
		}
        */
        /*
        //cara 3        
        $this->adodb = ADONewConnection($dbconf['dbdriver']);
		
        $this->adodb->debug = $dbconf['db_debug'];
         
        if(!$this->adodb->Connect('host='.$dbconf['hostname'].' port='.$dbconf['port'].' dbname='.$dbconf['database'].' user='.$dbconf['username'].' password='.$dbconf['password']))
		{
			show_error('Connection Error');
			log_message('debug', "Connection Error");
		}
       */ 
		log_message('debug', "ADODB Class Initialized");
	}

	public function db()
	{
		return $this->adodb;
	}

}
