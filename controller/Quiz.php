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
	private $user;


	public function __construct(\model\User $user) {
		$this->user = $user;
		$this->view = new \view\Quiz();
		$this->session = new \model\SessionHandler();
	}

	public function manageQuiz() {

		$dal = new \model\QuizDAL();
		$quizes = $dal->getEmptyQuizes();

		return $this->view->getQuizListHTML($quizes);


		//$userDAL = new \model\QuizDAL();

		// if($_GET['action'] == 'delete') {
		// 	// $userDAL->deleteUserById($_GET['user']);
		// 	// $this->messageHandler->setMessage('Anv�ndare borttagen');
		// 	// header('location: http://127.0.0.1:8080/quizzy/?action=manage');

		// }

		// if($_GET['action'] == 'show') {
		// 	// $userDAL->makeAdminById($_GET['user']);
		// 	// $this->messageHandler->setMessage('Anv�ndare f�tt administrat�rsr�ttigheter');
		// 	// header('location: http://127.0.0.1:8080/quizzy/?action=manage');
		// }

		// $users = $userDAL->getUsersOnly();

		// return $this->view->getUserListHTML($users);
	}


	public function showQuizResult() {

		// H�mta quizId fr�n vyn get

		$quizId =  $this->view->getQuizId();

		// H�mta  helt quiz samt resultat fr�n DB

		$quizDAL = new \model\QuizDAL();

		$quiz = $quizDAL->getQuizById($quizId);
		$userAnswers = $quizDAL->getUserAnswersArray($this->user->getUserId(), $quizId);


//var_dump($quiz);
		return $this->view->getQuizResultHTML($quiz, $userAnswers); // Parameter?

	}



	public function listAvalibleQuiz() {

		$dal = new \model\QuizDAL();
		$quizes = $dal->getEmptyAvalibleQuizes($this->user->getUserId());

		return $this->view->getAvalibleQuizListHTML($quizes);

	}

	public function listDoneQuiz() {

		$dal = new \model\QuizDAL();
		$quizes = $dal->getEmptyDoneQuizes($this->user->getUserId());

		return $this->view->getDoneQuizListHTML($quizes);
	}


	// public function listQuizes() {
	// 	$dal = new \model\QuizDAL();
	// 	$quizes = $dal->getEmptyQuizes();

	// 	return $this->view->getQuizListHTML($quizes);
	// }

	public function createQuiz() {

		// Kolla om Quiz har skapats annars skapa ett
		if(empty($this->session->getCreatedQuizId())) {

			if(!empty($this->view->getQuizTitle())) {

				$title = $this->view->getQuizTitle();
				$quiz = new \model\Quiz($title, $this->user->getUserId());

				$quizDAL = new \model\QuizDAL();
				
				$id = $quizDAL->saveQuiz($quiz);
				$this->session->saveCreatedQuizId($id);
			} else {
				return $this->view->getTitleFormHTML();
			}
		}

		// Kolla om ny fr�ga har matats in
		if(!empty($this->view->getQuestion())) {

			// H�mta Quiz fr�n DB
			$quizDAL = new \model\QuizDAL();
			$quiz = $quizDAL->getQuizById($this->session->getCreatedQuizId());

			// H�mta input fr�n anv�ndaren
			$question = $this->view->getQuestion();
			$answers = $this->view->getAnswers();

			// Kolla om fil har lagts till
			// if($this->view->hasFileUpload()) {

			// 	$this->view->handleFile($this->session->getCreatedQuizId());



			// }

			// Skapa och l�gg till Question i DB
			$questionObject = new \model\Question($question, $answers);
			$questionDAL = new \model\QuestionDAL();
			$questionObject = $questionDAL->saveQuestionByQuizId($questionObject, $quiz->getQuizId());

			$this->session->incrementQuestionNumber();
		}	

		return $this->view->getQuestionFormHTML($this->session->getQuestionNumber());
	}

	public function doQuiz() {

		// H�mta quizId fr�n URL
		$quizId = $this->view->getQuizId();

		// H�mta Quiz och Questions fr�n DB 
		$quizDAL = new \model\QuizDAL();
		$quiz = $quizDAL->getQuizById($quizId);
		$questions = $quiz->getQuestions();

		// Om POST s� kolla om angivet svar �r korrekt och r�kna upp antalet r�tt
		if($this->view->isPostBack()) {
			if($questions[$this->session->getQuestionIndex()]->isCorrect($this->view->getAnswer()))
				$this->session->incrementCorrectCount();

			$this->session->incrementQuestionIndex();
		}

		// H�mta aktuellt index

		$index = $this->session->getQuestionIndex();

		// Om klar s� visa resultat annars visa n�sta fr�ga
		if($index < count($questions))
			return $this->view->getHTML($questions[$index], count($questions), $quiz->getQuizName(), $this->session->getQuestionIndex());
		else
			return $this->view->getResultHTML($this->session->getCorrectCount(), $this->session->getQuestionIndex());
	}
}