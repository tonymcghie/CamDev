<?php
class DATABASE_CONFIG {
        /**
         * @LIVE swap database connection
         */
        //local config
	public $default = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false ,
		'host' => 'localhost',
		'login' => 'root',
		'password' => 'abc123',
		'database' => 'cam_data',
		'prefix' => '',
		'encoding' => 'utf8'
	);
        //live config
        /**public $default = [
		'datasource' => 'Database/Mysql',
		'persistent' => false ,
		'host' => 'database.powerplant.pfr.co.nz',
		'login' => 'camadmin',
		'password' => '',
		'database' => 'cam_data',
		'prefix' => '',
		'encoding' => 'utf8'
	];*/
        
        function __construct() {
            //$this->default['password'] = getenv('MYSQL_PASS');
        }
}
