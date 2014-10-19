<?php

namespace controller;

require_once('view/MessageHandler.php');
require_once('view/User.php');

class User {

	private $view;
	private $messageHandler;

	public function __construct() {
		$this->messageHandler = new \view\MessageHandler();
		$this->view = new \view\User();
		
	}

	public function manageUser() {

		$userDAL = new \model\UserDAL();

		if($_GET['action'] == 'deleteuser') {
			$userDAL->deleteUserById($_GET['user']);
			$this->messageHandler->setMessage('Användare borttagen');
			header('location: http://127.0.0.1:8080/quizzy/?action=manageuser');

		}

		if($_GET['action'] == 'makeadmin') {
			$userDAL->makeAdminById($_GET['user']);
			$this->messageHandler->setMessage('Användare fått administratörsrättigheter');
			header('location: http://127.0.0.1:8080/quizzy/?action=manageuser');
		}

		$users = $userDAL->getUsersOnly();

		return $this->view->getUserListHTML($users);
	}
}