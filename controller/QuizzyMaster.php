<?php

namespace controller;

require_once('view/QuizzyMaster.php');
require_once('controller/Quiz.php');
require_once('controller/User.php');
require_once('login/controller/LoginController.php');

class QuizzyMaster {

	private $view;
	private $login_controller;

	public function __construct() {
		$this->login_controller = new \login\controller\LoginController();
	}

	public function doRoute() {

		// Om användaren är inloggad
		if($this->login_controller->checkLoginStatus()) {

			// Hämta användaren och skicka vidare till vyn
			$user = $this->login_controller->getUser();
			$this->view = new \view\QuizzyMaster($user);

			//var_dump($user);


			// Kolla om användaren är User eller Adminstrator
			if($user->getIsAdmin()) {

				// Administrator

				switch (\view\QuizzyMaster::getAction()) {

					case \view\QuizzyMaster::$PATH_MANAGE_USER:
						return (new \controller\User())->manageUser();
						break;
					case \view\QuizzyMaster::$PATH_DELETE_USER:
						return (new \controller\User())->manageUser();
						break;		
					case \view\QuizzyMaster::$PATH_MAKEADMIN:
						return (new \controller\User())->manageUser();
						break;

					case \view\QuizzyMaster::$PATH_MANAGE_QUIZ:
						return (new \controller\Quiz($user))->manageQuiz();
						break;
					case \view\QuizzyMaster::$PATH_DELETE_QUIZ:
						return (new \controller\Quiz($user))->manageQuiz();
						break;	
					case \view\QuizzyMaster::$PATH_CREATE_QUIZ:
						return (new \controller\Quiz($user))->createQuiz();
						break;

					case \view\QuizzyMaster::$PATH_ACTIVATE_QUIZ:
						return (new \controller\Quiz($user))->manageQuiz();
						break;	
					case \view\QuizzyMaster::$PATH_DEACTIVATE_QUIZ:
						return (new \controller\Quiz($user))->manageQuiz();
						break;





					case \view\QuizzyMaster::$PATH_HOME:
						return  $this->view->getAdminHTML();
						break;
					default:
						return  $this->view->getAdminHTML();
						break;
				}

			} else {

				// User

				switch (\view\QuizzyMaster::getAction()) {
					
					case \view\QuizzyMaster::$PATH_LIST_AVALIBLE:
						return (new \controller\Quiz($user))->listAvalibleQuiz();
						break;
					case \view\QuizzyMaster::$PATH_LIST_DONE:
						return (new \controller\Quiz($user))->listDoneQuiz();
						break;
					case \view\QuizzyMaster::$PATH_SHOW_RESULT:
						return (new \controller\Quiz($user))->showQuizResult();
						break;

					case \view\QuizzyMaster::$PATH_DO_QUIZ:
						return (new \controller\Quiz($user))->doQuiz();
						break;
					// case \view\QuizzyMaster::$PATH_LIST:
					// 	return (new \controller\Quiz())->listQuizes();
					// 	break;




					case \view\QuizzyMaster::$PATH_HOME:
						return  $this->view->getUserHTML();
						break;
					default:
						return  $this->view->getUserHTML();
						break;
				}
			}
		}



		// Kolla och visa Login eller Registration formulär
		if(\view\QuizzyMaster::getAction() == \view\QuizzyMaster::$PATH_REGISTER) {
			
			return (new \login\controller\Register())->doRegister();
		}
		else {
			//echo "hej"; die();
			return $this->login_controller->getLoginHTML();
		}
	}
}