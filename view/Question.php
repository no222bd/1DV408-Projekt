<?php

namespace view;

class Question {

	public function getHTML(\model\Question $question) {

		$html = '<h2>' . $question->getQuestion() . '</h2>';

		if($question->getMediaPath() !== NULL) {
			$html .= '<img src="' . $question->getMediaPath() . '" />';
		}
		
		$html .= '<form method="POST">';

		if($question->isTextQuestion()) {
			$html .= '<input type="text" name="answer" required />';
		} else {
			$answers = $question->getAnswers();
			shuffle($answers);

			foreach ($answers as $answer) {
				$html .= '<label>'
							. '<input type="radio" name="answer" value="' . $answer . '" required />'
							. $answer . '</label>';
			}
		}

		$html .= '<input type="submit" value="Svara"/>
				  </form>';

		return $html;

		//action="' . $_SERVER['PHP_SELF'] . '?action=doQuiz"
	}
}