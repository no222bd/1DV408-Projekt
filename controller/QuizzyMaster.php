<?php

namespace controller;

require_once('view/QuizzyMaster.php');
require_once('controller/Quiz.php');

class QuizzyMaster {

	private $view;

	public function __construct($user) {
		$this->view = new \view\QuizzyMaster($user);
	}

	public function doRoute() {

		switch ($this->view->getAction()) {
			case \view\QuizzyMaster::$PATH_DO:
				$controller = new \controller\Quiz();
				return $controller->doQuiz();
				break;
			case \view\QuizzyMaster::$PATH_CREATE:
				return (new \controller\Quiz())->createQuiz();
				break;			
			case \view\QuizzyMaster::$PATH_LIST:
				return (new \controller\Quiz())->listQuizes();
				break;
			case \view\QuizzyMaster::$PATH_HOME:
				return  $this->view->getStartPage();
				break;
		}
	}
}