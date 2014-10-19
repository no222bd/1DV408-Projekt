<?php

namespace model;

require_once('model/SuperDAL.php');
require_once("model/Quiz.php");
// TEMP
require_once('model/QuestionDAL.php');

class QuizDAL extends \model\SuperDAL {

	public function getUserAnswersArray($userId, $quizId) {

		$this->connectToDB();

		$sql = 'SELECT ' . self::$answer_questionIdField . ', ' . self::$answer_answerField . '
				FROM ' . self::$answer_tableName . ' 
				INNER JOIN ' . self::$userAnswer_tableName . ' 
					ON ' . self::$answer_tableName . '.' . self::$answer_idField . '=' . self::$userAnswer_tableName . '.' . self::$userAnswer_answerIdField . ' 
				INNER JOIN ' . self::$done_tableName . ' 
					ON ' . self::$done_tableName . '.' . self::$done_doneQuizIdField . '=' . self::$userAnswer_tableName . '.' . self::$userAnswer_doneQuizIdField . '
				WHERE ' . self::$done_userIdField . '=:user_Id AND ' . self::$done_quizIdField . '=:quiz_Id';

		$stmt = $this->dbConnection->prepare($sql);

		$stmt->execute(array('user_Id' => $userId,
							 'quiz_Id' => $quizId)
		);
	
		$answersArray = array();

		while($row = $stmt->fetch()) {
			$answersArray[$row[self::$answer_questionIdField]] = $row[self::$answer_answerField]; 
		}

		return $answersArray;
	}



	public function getEmptyDoneQuizes($userId) {

		$this->connectToDB();
		
		$sql = 'SELECT ' . self::$quiz_tableName . '.' . self::$quiz_idField . ', ' . self::$quiz_creatorIdField . ', ' . self::$quiz_nameField . ', ' . self::$quiz_isActiveField . '
				FROM ' . self::$quiz_tableName . '
				INNER JOIN ' . self::$done_tableName . '
				ON ' . self::$done_tableName . '.' . self::$done_quizIdField . '=' . self::$quiz_tableName . '.' . self::$quiz_idField . '
				WHERE ' . self::$done_userIdField . '=:user_Id';

		$stmt = $this->dbConnection->prepare($sql);

		$stmt->execute(array('user_Id' => $userId));
	
		$quizes = array();

		while($row = $stmt->fetch()) {
			$quiz = new \model\Quiz($row[self::$quiz_nameField], $row[self::$quiz_creatorIdField], $row[self::$quiz_isActiveField]);
			$quiz->setQuizId($row[self::$quiz_idField]);
			$quizes[] = $quiz;
		}

		return $quizes;
	}

	public function getEmptyAvalibleQuizes($userId) {

		$this->connectToDB();

		$sql = 'SELECT *
				FROM ' . self::$quiz_tableName . '
				WHERE NOT EXISTS
					(SELECT * 
		     		FROM ' . self::$done_tableName . '
		     		WHERE ' . self::$done_tableName . '.' . self::$done_quizIdField . '=' . self::$quiz_tableName . '.' . self::$quiz_idField . '
		     		AND ' . self::$done_tableName . '.' . self::$done_userIdField . '= :user_Id)
				AND ' . self::$quiz_isActiveField . '=TRUE';

		$stmt = $this->dbConnection->prepare($sql);

		$stmt->execute(array('user_Id' => $userId));
	
		$quizes = array();

		while($row = $stmt->fetch()) {
			$quiz = new \model\Quiz($row[self::$quiz_nameField], $row[self::$quiz_creatorIdField], $row[self::$quiz_isActiveField]);
			$quiz->setQuizId($row[self::$quiz_idField]);
			$quizes[] = $quiz;
		}

		return $quizes;
	}

	public function getEmptyQuizes() {

		$this->connectToDB();

		$sql = 'SELECT *
				FROM ' . self::$quiz_tableName;

		$stmt = $this->dbConnection->query($sql);
	
		$quizes = array();

		while($row = $stmt->fetch()) {
			$quiz = new \model\Quiz($row[self::$quiz_nameField], $row[self::$quiz_creatorIdField], $row[self::$quiz_isActiveField]);
			$quiz->setQuizId($row[self::$quiz_idField]);
			$quizes[] = $quiz;
		}

		return $quizes;
	}

	public function getQuizById($quizId) {

		$this->connectToDB();

		$sql = 'SELECT *
				FROM ' . self::$quiz_tableName . '
				WHERE ' . self::$quiz_idField . ' = :quiz_Id';

		$stmt = $this->dbConnection->prepare($sql);
	
		$stmt->execute(array('quiz_Id' => $quizId));

		$result = $stmt->fetch();
		
		// Skapar Quiz med titel och id
		$quiz = new \model\Quiz($result[self::$quiz_nameField], $result[self::$quiz_creatorIdField], $result[self::$quiz_isActiveField]);
		$quiz->setQuizId($result[self::$quiz_idField]);

		// Populerar Quiz med Questions
		$questionDAL = new \model\QuestionDAL();
		$questionDAL->populateQuizObject($quiz);

		return $quiz;
	}

	public function saveQuiz(\model\Quiz $quiz) {

		$this->connectToDB();

		// Spara i Quiz tabell
		
		$sql = 'INSERT INTO ' . self::$quiz_tableName . ' (' . self::$quiz_nameField . ') 
				VALUES (:quiz_Name, :is_Active)';

		$stmt = $this->dbConnection->prepare($sql);
	
		$stmt->execute(array('quiz_Name' => $quiz->getQuizName(),
							 'is_Active' =>	$quiz->getIsActive())
		);

		$quizId = $this->dbConnection->lastInsertId();

		// Spara i Question tabell

		$questions = $quiz->getQuestions();

		$questionDAL = new \model\QuestionDAL(); 

		foreach ($questions as $question)
			$questionDAL->saveQuestionByQuizId($question, $quizId);

		return $quizId;	
	}
}