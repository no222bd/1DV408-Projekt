<?php

namespace login\controller;

require_once('login/model/LoginModel.php');
require_once('login/model/UserControl.php');
require_once('login/view/LoginView.php');
require_once('login/view/CredentialsHandler.php');

require_once('controller/QuizzyMaster.php');


class LoginController {

	private $loginModel;
	private $loginView;
	private $userControl;
	private $credentialsHandler;

	public function __construct() {
		$this->loginModel = new \login\model\LoginModel();
		$this->userControl = new \login\model\UserControl();
		$this->credentialsHandler = new \login\view\CredentialsHandler();
		$this->loginView = new \login\view\LoginView($this->loginModel);
	}

	// Login execution flow
	public function doLogin() {
		if($this->userControl->checkUserAgent($this->loginView->getUserAgent())) {
			if($this->loginModel->isLoggedIn()) {
				if($this->loginView->didUserLogout())
					$this->logout();
			} else {
				if($this->credentialsHandler->cookieExist()){
					$this->cookieLogin();
				} else {
					if($this->loginView->didUserLogin()) {
						$this->login();
					}
				}
			}

			return $this->getHTML();
		}

		return $this->loginView->getLoginHTML();
	}

	// Handles the process of logging out
	private function logout() {
		$this->loginModel->setStatusToLogout();
		$this->credentialsHandler->clearCredentials();
		$this->loginView->setLogoutMessage();
	}

	// Handles the process of logging in
	private function login() {
		if($this->loginView->hasValidInput()) {
			if($this->loginModel->checkCredentials($this->loginView->getCredentials())) {
				if($this->loginView->doRememberMe()) {
					$this->credentialsHandler->saveCredentials($this->loginView->getCredentials());
					$this->loginView->setRemberMeLoginMessage();
				} else {
					$this->loginView->setLoginMessage();
				}
			} else {
				$this->loginView->setFailMessage();
			}
		}
	}

	// Handles the process of logging in with cookies
	private function cookieLogin() {
		if($this->credentialsHandler->isValidCookie()
		&& $this->loginModel->checkCredentials($this->credentialsHandler->getCredentials())) {
			$this->loginView->setCookieLoginMessage();
		} else {
			$this->credentialsHandler->clearCredentials();
			$this->loginView->setFaultyCookieMessage();
		}
	}

	// Take appropriate action depending on if user is logged in or not
	private function getHTML() {
		if($this->loginModel->isLoggedIn()) {

			$router = new \controller\QuizzyMaster();
			return $router->doRoute();

			//return $this->loginView->getLogoutHTML();
		} else {
			return $this->loginView->getLoginHTML();
		}
	}
}