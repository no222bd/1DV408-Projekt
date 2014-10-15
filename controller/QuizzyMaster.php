<?php

namespace controller;

require_once('view/Master.php');
require_once('controller/Quiz.php');

class QuizzyMaster {

	private $view;

	public function __construct() {
		$this->view = new \view\Master();
	}

	public function doRoute() {

		switch ($this->view->getAction()) {
			case 'doQuiz':
				$controller = new \controller\Quiz();
				return $controller->doQuiz();
				break;
			case 'createQuiz':
				return (new \controller\Quiz())->createQuiz();
				break;			
			case 'listQuiz':
				return (new \controller\Quiz())->listQuizes();
				break;
			case 'startPage':
				return  $this->view->getStartPage();
				break;
		}
	}
}