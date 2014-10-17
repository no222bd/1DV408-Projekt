<?php

namespace view;

require_once('\view\Question.php');

class Quiz {

	// Do Quiz ====================================================================================================
	
	public function getQuizId() {
		return $_GET['doQuiz'];
	}

	public function isPostBack() {
		return $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['answer']);
	}

	public function getAnswer() {
		return $_POST['answer'];
	}

	public function getResultHTML($correctCount, $questionIdex) {
		$html = '<p>Du hade ' . $correctCount . ' av ' . $questionIdex . ' rätt!</p>';

		$html .= '<a href="?">Till huvudmenyn</a';

		return $html;
	}

	public function getHTML(\model\Question $question, $numberOfQuestions , $quizName, $questionIndex) {
		$html = '<h2>' . $quizName . '</h2>';

		$html .= '<div id="questionBox">'
					  . (new \view\Question())->getHTML($question) .
				 '</div>';

		$html .= '<h3>Fråga ' . ($questionIndex + 1) . ' / ' . $numberOfQuestions . '</h3>';

		return $html;		
	}

	// Create Quiz ====================================================================================================

	public function hasFileUpload() {
		return !empty($_FILES['imageFile']);
	}

	public function handleFile($quizId) {

		$target_path = 'media/images/';

		$target_path = $target_path . basename( $_FILES['imageFile']['name']); 

		move_uploaded_file($_FILES['imageFile']['tmp_name'], $target_path);
	}

	public function getQuizTitle() {
		if(isset($_POST['quizTitle']))
			return $_POST['quizTitle'];
	}

	public function getQuestion() {
		if(isset($_POST['question']))
			return $_POST['question'];
	}

	public function getAnswers() {
		$answers = array();

		if(empty($_POST['answer4'])) {
			$answers[] = $_POST['answer1'];
		} else {
			$answers[] = $_POST['answer1'];
			$answers[] = $_POST['answer2'];
			$answers[] = $_POST['answer3'];
			$answers[] = $_POST['answer4'];
		}

		return $answers;
	}

	public function getTitleFormHTML() {
		$html = '<h2>Skapa Quiz</h2>';
		
		$html .= '<p> Ange Quiz-namn </p>';

		$html .= '<form method="POST">
						<label>Quiznamn
							<input type="text" name="quizTitle" required />
						</label>
						<input type="submit" value="Skapa"/>
				  </form>';
		
		return $html;
	}

	public function getQuestionFormHTML($questionNumber) {

		$html = '<h2>Skapa fråga ' . $questionNumber . '</h2>
				<form method="POST" enctype="multipart/form-data">
					<label> Ange fråga
						<input type="text" name="question" required />
					</label>
					<label> Ange svar
						<input type="text" name="answer1" required />
					</label>
					<hr>

					<input type="file" name="imageFile"><br>

					<hr>
					<p>Om flervalsfråga önskas, fyll i alla nedanstående</p>
					<label> Ange svarsalternativ 1
						<input type="text" name="answer2" />
					</label>
					<label> Ange svarsalternativ 2
						<input type="text" name="answer3" />
					</label>
					<label> Ange svarsalternativ 3
						<input type="text" name="answer4" />
					</label>
					<input type="submit" value="Spara"/>
			</form>';

		return $html;	
	}

	// List Quizes ====================================================================================================

	public function getQuizListHTML($quizes) {



		$html = '<h2>Tillgängliga Quiz</h2>';

		foreach ($quizes as $quiz) {
			$html .= '<p><a href="?' . \view\QuizzyMaster::$PATH_DO .  '=' . $quiz->getQuizId() . '">' . $quiz->getQuizName() . '</a></p>';
		}

		return $html;
	}

}