<?php

namespace model;

require_once('model/SuperDAL.php');
require_once("model/Quiz.php");
// TEMP
require_once('model/QuestionDAL.php');

class QuizDAL extends \model\SuperDAL {

	// Quiz table properties
	private static $tableName = 'quiz';
	private static $idField = 'quizId';
	private static $nameField = 'name';

	// public function getEmptyQuiz($quizId) {

	// 	$this->connectToDB();

	// 	$sql = 'SELECT *
	// 			FROM ' . self::$tableName . '
	// 			WHERE ' . self::$idField . ' = :quiz_Id';

	// 	$stmt = $this->dbConnection->prepare($sql);
	
	// 	$stmt->execute(array('quiz_Id' => $quizId));

	// 	$result = $stmt->fetch();
		
	// 	// Skapar Quiz med titel och id
	// 	$quiz = new \model\Quiz($result[self::$nameField]);
	// 	$quiz->setQuizId($result[self::$idField]);

	// 	// Populerar Quiz med Questions
	// 	$questionDAL = new \model\QuestionDAL();
	// 	$questionDAL->populateQuizObject($quiz);

	// 	return $quiz;
	// }

	public function getEmptyQuizes() {

		$this->connectToDB();

		$sql = 'SELECT *
				FROM ' . self::$tableName;

		$stmt = $this->dbConnection->query($sql);
	
		$quizes = array();

		while($row = $stmt->fetch()) {
			$quiz = new \model\Quiz($row[self::$nameField]);
			$quiz->setQuizId($row[self::$idField]);
			$quizes[] = $quiz;
		}

		return $quizes;
	}

	public function getQuizById($quizId) {

		$this->connectToDB();

		$sql = 'SELECT *
				FROM ' . self::$tableName . '
				WHERE ' . self::$idField . ' = :quiz_Id';

		$stmt = $this->dbConnection->prepare($sql);
	
		$stmt->execute(array('quiz_Id' => $quizId));

		$result = $stmt->fetch();
		
		// Skapar Quiz med titel och id
		$quiz = new \model\Quiz($result[self::$nameField]);
		$quiz->setQuizId($result[self::$idField]);

		// Populerar Quiz med Questions
		$questionDAL = new \model\QuestionDAL();
		$questionDAL->populateQuizObject($quiz);

		return $quiz;
	}

	public function saveQuiz(\model\Quiz $quiz) {

		$this->connectToDB();

		// Spara i Quiz tabell
		
		$sql = 'INSERT INTO ' . self::$tableName . ' (' . self::$nameField . ') 
				VALUES (:quiz_Name)';

		$stmt = $this->dbConnection->prepare($sql);
	
		$stmt->execute(array('quiz_Name' => $quiz->getQuizName()));

		$quizId = $this->dbConnection->lastInsertId();

		// Spara i Question tabell

		$questions = $quiz->getQuestions();

		$questionDAL = new \model\QuestionDAL(); 

		foreach ($questions as $question)
			$questionDAL->saveQuestionByQuizId($question, $quizId);

		return $quizId;	
	}
}