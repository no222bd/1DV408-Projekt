<?php

namespace model;

require_once('Settings.php');

abstract class SuperDAL {

	protected $dbConnection;
	
	protected function connectToDB() {
		
		if ($this->dbConnection == NULL)
			$this->dbConnection = new \PDO(\Settings::$dbConnectionString, \Settings::$dbUsername, \Settings::$dbPassword);
		
		//$this->dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		
		return $this->dbConnection;
	}
}