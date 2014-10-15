<?php

namespace login\model;

require_once('model/UserDAL.php');

class LoginModel {

	private static $usernameLocation = 'username';
	private static $passwordLocation = 'password';
	private static $loginStatusLocation = 'loggedIn';

	// Check if the supplied credentials are valid
	public function checkCredentials(array $credentials) {

		$userDAL = new \model\UserDAL();
		$catalogue = $userDAL->getUsersDataArray();

		$username = $credentials[0];
		$password = $credentials[1];

		if(array_key_exists($username, $catalogue)) {
			if($catalogue[$username] == $password) {
				$_SESSION[self::$usernameLocation] = $username;
				$_SESSION[self::$loginStatusLocation] = true;
				return true;
			} 
		}

		return false;
	}

	// Set the loginststatus to logged out 
	public function setStatusToLogout() {
		$_SESSION[self::$loginStatusLocation] = false;
	}

	// Check if the user is logged in or not
	public function isLoggedIn() {
		if(isset($_SESSION[self::$loginStatusLocation]))
			return $_SESSION[self::$loginStatusLocation];
		else
			return false;
	}

	// Return the username of current user
	public function getUsername() {
		return $_SESSION[self::$usernameLocation];
	}
}