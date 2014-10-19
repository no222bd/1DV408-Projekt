<?php

namespace model;

class Quiz {

	private $quizId;
	private $quizName;
	private $questions = array();
	// Skall denna finnas här eller bara i databasen
	private $creatorId;
	private $isActive;


	public function __construct($quizName, $creatorId, $isActive = false) {
		$this->quizName = $quizName;
		$this->creatorId = $creatorId;
		$this->isActive = $isActive;
	}

	public function getQuizId() {
		// If isset skall ske
		return $this->quizId;
	}

	public function getQuizName() {
		return $this->quizName;
	}

	public function getQuizStatus() {
		return $this->isActive;
	}

	public function getQuestions() {
		return $this->questions;
	}

	public function setQuizId($quizId) {
		$this->quizId = $quizId;
	}

	public function setIsActive($isActive) {
		$this->isActive = $isAcive;
	}

	public function addQuestion(\model\Question $question) {
		$this->questions[] = $question;
	}
}