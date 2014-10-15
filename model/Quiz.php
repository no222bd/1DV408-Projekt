<?php

namespace model;

class Quiz {

	private $quizId;
	private $quizName;
	private $questions = array();

	public function __construct($quizName) {
		$this->quizName = $quizName;
	}

	public function getQuizId() {
		// If isset skall ske
		return $this->quizId;
	}

	public function getQuizName() {
		return $this->quizName;
	}

	public function getQuestions() {
		return $this->questions;
	}

	public function setQuizId($quizId) {
		$this->quizId = $quizId;
	}

	public function addQuestion(\model\Question $question) {
		$this->questions[] = $question;
	}
}