<?php

namespace model;

require_once('model/SuperDAL.php');

class UserDAL extends \model\SuperDAL {

	// User table properties
	private static $tableName = 'user';
	private static $userIdField = 'userId';
	private static $usernameField = 'username';
	private static $passwordField = 'password';
	private static $userTypeIdField = 'userTypeId';

	public function getArrayOfUsernames() {
		
		$this->connectToDB();

		// Ändra så att endast usernames hämtas(används i \login\model\register)

		$sql = 'SELECT *
				FROM ' . self::$tableName;

		$stmt = $this->dbConnection->query($sql);
	
		$usernames = array();

		while($row = $stmt->fetch()) {
			$usernames[] = $row[self::$usernameField];
		}

		return $usernames;
	}

	public function getUsersDataArray() {
		
		$this->connectToDB();

		$sql = 'SELECT *
				FROM ' . self::$tableName;

		$stmt = $this->dbConnection->query($sql);
	
		$users = array();

		while($row = $stmt->fetch()) {
			$users[$row[self::$usernameField]] = $row[self::$passwordField];
		}

		return $users;
	}

	public function saveUser(\model\User $user) {

		$this->connectToDB();
		
		$sql = 'INSERT INTO ' . self::$tableName . ' (' . self::$usernameField . ', ' . self::$passwordField . ') 
				VALUES (:username, :password)';

		$stmt = $this->dbConnection->prepare($sql);
	
		$stmt->execute(array(
				'username' => $user->getUsername(),
				'password' => $user->getPassword())
			);
	}
}