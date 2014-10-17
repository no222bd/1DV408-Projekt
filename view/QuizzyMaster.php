<?php

namespace view;

class QuizzyMaster {

	public static $PATH_REGISTER = 'register';
	public static $PATH_DO = 'do';
	public static $PATH_CREATE = 'create';
	public static $PATH_LIST = 'list';
	public static $PATH_HOME = 'home';

	private $userId;
	private $username;

	public static function getUserId() {
	 	return $this->userId;
	}

	public static function getUsername() {
		return $this->userId;
	}

	public function __construct($user) {
		$this->userId = $user->getUserId();
		$this->username = $user->getUsername();
	}

	public static function doRegister() {
		return array_key_exists(self::$PATH_REGISTER, $_GET);
	}

	public function getStartPage() {

		$html = '<h2>Välkommen ' . $this->username . '</h2>
				 <a href="?' . self::$PATH_CREATE . '">Skapa ett quiz</a><br/>
				 <a href="?' . self::$PATH_LIST . '">Lista tillgängliga quiz</a><br/>';

		// STRÄNGBEROENDE!!!

		$html .= '<form method="post">
					<input type="submit" name="logout" value="Logga ut">
				  </form>';

		return $html;
	}

	public function getAction() {

		if(array_key_exists(self::$PATH_DO, $_GET))
			return self::$PATH_DO;

		if(array_key_exists(self::$PATH_CREATE, $_GET))
			return self::$PATH_CREATE;

		if(array_key_exists(self::$PATH_LIST, $_GET))
			return self::$PATH_LIST;

		return self::$PATH_HOME;
	}
}