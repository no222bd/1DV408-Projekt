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
	//private $session;
	private $user;
	private $messageHandler;


	public function __construct(\model\User $user) {
		$this->user = $user;
		$this->view = new \view\Quiz();
		$this->session = new \model\SessionHandler();
		$this->messageHandler = new \view\MessageHandler();
	}

	public function manageQuiz() {

		$quizDAL = new \model\QuizDAL();

		if($_GET['action'] == 'activatequiz' || $_GET['action'] == 'deactivatequiz') {
			$quizDAL->toogleQuizActivation($_GET['quiz']);
			$this->messageHandler->setMessage('Quiz-statusen är ändrad');
			header('location: http://127.0.0.1:8080/quizzy/?action=managequiz');
		}

		$quizes = $quizDAL->getAdminEmptyQuizes($this->user->getUserId());
		return $this->view->getAdminQuizListHTML($quizes);
	}


	public function showQuizResult() {

		// Hämta quizId från vyn get

		$quizId =  $this->view->getQuizId();

		// Hämta  helt quiz samt resultat från DB

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

	public function createQuiz() {

		
		// Hämta eventuellt QuizId från GET
		$quizId = $this->view->getQuizId();		

		// Kolla eventuellt att användaren är creator //
		// Annar skicka till felsida //

		// Kolla om QuizId fanns i GET
		if(empty($quizId)) {

			// Kolla om titel finns i POST
			if(empty($this->view->getQuizTitle())) {
				// Visa HTML för inmatning av titel
				return $this->view->getTitleFormHTML();
			} else {
				// Skapa ett Quiz-objekt
				$title = $this->view->getQuizTitle();
				$quiz = new \model\Quiz($title, $this->user->getUserId());

				$quizDAL = new \model\QuizDAL();
				$quizId = $quizDAL->saveQuiz($quiz);

				header('location: http://127.0.0.1:8080/quizzy/?action=createquiz&quiz=' . $quizId);
			}

		}elseif(!empty($this->view->getQuestion())) {

			// Hämta Quiz från DB
			$quizDAL = new \model\QuizDAL();
			$quiz = $quizDAL->getQuizById($quizId);

			// Hämta input från användaren
			$question = $this->view->getQuestion();
			$answers = $this->view->getAnswers();

			/////////////////////////
			// Uppladdning av bild //
			/////////////////////////

			// Skapa och lägg till Question i DB
			$questionObject = new \model\Question($question, $answers);
			$questionDAL = new \model\QuestionDAL();
			$questionDAL->saveQuestionByQuizId($questionObject, $quizId);

			header('location: http://127.0.0.1:8080/quizzy/?action=createquiz&quiz=' . $quizId);
		}	

		$questionNumber = count((new \model\QuizDAL())->getQuizById($quizId)->getQuestions()) + 1;

		if($this->view->isLastQuestion()) {
			header('location: http://127.0.0.1:8080/quizzy/?action=' . \view\QuizzyMaster::$PATH_MANAGE_QUIZ);
		} elseif($questionNumber > 2)
			return $this->view->getQuestionFormHTML($questionNumber, $showDoneButton = true);
		else
			return $this->view->getQuestionFormHTML($questionNumber);
	}

	public function doQuiz() {

		// Hämta quizId från URL
		$quizId = $this->view->getQuizId();

		// Hämta Quiz och Questions från DB 
		$quizDAL = new \model\QuizDAL();
		$quiz = $quizDAL->getQuizById($quizId);
		$questions = $quiz->getQuestions();

		// Kolla om formulär har postats och spara då svaret i db
		if($this->view->isPostBack()) {

			$doneQuizId = $quizDAL->getDoneQuizId($this->user->getUserId(), $quizId);

			if(empty($doneQuizId)) 
				$doneQuizId = $quizDAL->saveDoneQuiz($this->user->getUserId(), $quizId);

			// Hämta svar och questionId från vyn
			$answer = $this->view->getAnswer();
			$questionId = $this->view->getQuestionId();

			// Ta fram AnswerId baserat på svaret
			$questionDAL = new \model\QuestionDAL();
			$answerId = $questionDAL->getAnswerIdByQuestionIdAndAnswer($questionId, $answer);

			// Spara svaret		
			$questionDAL->saveUserAnswer($doneQuizId, $answerId);
		}

		// Kolla vilken Question som skall visas
		$quizSize = count($questions);
		$answerd = $quizDAL->getUserAnswersArray($this->user->getUserId(), $quizId);

		// Question id finns i useranswer så kolla nästa
		for($i = 0; $i < $quizSize; $i++) {
			
			if(array_key_exists($questions[$i]->getQuestionId(), $answerd))
				continue;
			else {
				return $this->view->getHTML($questions[$i], $quizSize, $quiz->getQuizName(), $i + 1);
			}
		}
		
		$quizDAL->updateDoneQuizIsComplete($doneQuizId);
		
		header('location: http://127.0.0.1:8080/quizzy/?action=' . \view\QuizzyMaster::$PATH_SHOW_RESULT . '&quiz=' . $quiz->getQuizId());
	}
}