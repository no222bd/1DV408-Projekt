<?php

namespace model;

class SessionHandler {

	// controller/Quiz->doQuiz()

	public function getQuestionIndex() {
		if(isset($_SESSION['questionIndex']))
			return $_SESSION['questionIndex'];
		else
			return $_SESSION['questionIndex'] = 0;
	}

	public function incrementQuestionIndex() {
		if(isset($_SESSION['questionIndex']))
			$_SESSION['questionIndex'] += 1;
	}

	public function getCorrectCount() {
		if(isset($_SESSION['countCorrect']))
			return $_SESSION['countCorrect'];
		else
			return $_SESSION['countCorrect'] = 0;
	}

	public function incrementCorrectCount() {
		if(isset($_SESSION['countCorrect']))
			$_SESSION['countCorrect'] += 1;
		else
			$_SESSION['countCorrect'] = 1;
	}

	// controller/Quiz->createQuiz()

	public function saveCreatedQuizId($quizId) {
		$_SESSION['quizId'] = $quizId;
	}

	public function getCreatedQuizId() {
		if(isset($_SESSION['quizId']))
			return $_SESSION['quizId'];
	}

	public function getQuestionNumber() {
		if(isset($_SESSION['questionNumber']))
			return $_SESSION['questionNumber'];
		else
			return $_SESSION['questionNumber'] = 1;
	}

	public function incrementQuestionNumber() {
		if(isset($_SESSION['questionNumber']))
			$_SESSION['questionNumber'] += 1;
	}
}