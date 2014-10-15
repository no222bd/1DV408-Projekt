<?php

namespace controller;

require_once('model/Question.php');
require_once('model/SessionHandler.php');
require_once('view/Quiz.php');
//TEMP
require_once('model/QuizDAL.php');

class Quiz {

	//private $model;
	private $view;
	private $session;

	public function __construct() {
		$this->view = new \view\Quiz();
		$this->session = new \model\SessionHandler();
	}

	public function listQuizes() {
		$dal = new \model\QuizDAL();
		$quizes = $dal->getEmptyQuizes();

		return $this->view->getQuizListHTML($quizes);
	}

	public function createQuiz() {

		// Kolla om Quiz har skapats annars skapa ett
		if(empty($this->session->getCreatedQuizId())) {

			if(!empty($this->view->getQuizTitle())) {

				$title = $this->view->getQuizTitle();
				$quiz = new \model\Quiz($title);

				$quizDAL = new \model\QuizDAL();
				
				$id = $quizDAL->saveQuiz($quiz);
				$this->session->saveCreatedQuizId($id);
			} else {
				return $this->view->getTitleFormHTML();
			}
		}

		// Kolla om ny fråga har matats in
		if(!empty($this->view->getQuestion())) {

			// Hämta Quiz från DB
			$quizDAL = new \model\QuizDAL();
			$quiz = $quizDAL->getQuizById($this->session->getCreatedQuizId());

			// Hämta input från användaren
			$question = $this->view->getQuestion();
			$answers = $this->view->getAnswers();

			// Skapa och lägg till Question i DB
			$questionObject = new \model\Question($question, $answers);
			$questionDAL = new \model\QuestionDAL();
			$questionObject = $questionDAL->saveQuestionByQuizId($questionObject, $quiz->getQuizId());

			$this->session->incrementQuestionNumber();
		}	

		return $this->view->getQuestionFormHTML($this->session->getQuestionNumber());
	}

	public function doQuiz() {

		$quizId = $this->view->getQuizId();

		$quizDAL = new \model\QuizDAL();
		
		$quiz = $quizDAL->getQuizById($quizId);
		
		$questions = $quiz->getQuestions();

		if($this->view->isPostBack()) {
			if($questions[$this->session->getQuestionIndex()]->isCorrect($this->view->getAnswer()))
				$this->session->incrementCorrectCount();

			$this->session->incrementQuestionIndex();
		}

		$index = $this->session->getQuestionIndex();

		if($index < count($questions))
			return $this->view->getHTML($questions[$index], count($questions), $quiz->getQuizName(), $this->session->getQuestionIndex());
		else
			return $this->view->getResultHTML($this->session->getCorrectCount(), $this->session->getQuestionIndex());
	}
}