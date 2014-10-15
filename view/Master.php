<?php

namespace view;

class Master {

	public static function doRegister() {
		return array_key_exists('register', $_GET);
	}

	public function getStartPage() {

		$html = '<h2>V�lkommen</h2>
				 <a href="?createQuiz">Skapa ett quiz</a><br/>
				 <a href="?listQuiz">Lista tillg�ngliga quiz</a><br/>';

		// STR�NGBEROENDE!!!

		$html .= '<form method="post">
					<input type="submit" name="logout" value="Logga ut">
				  </form>';

		return $html;
	}

	public function getAction() {

		if(array_key_exists('doQuiz', $_GET))
			return 'doQuiz';

		if(array_key_exists('createQuiz', $_GET))
			return 'createQuiz';

		if(array_key_exists('listQuiz', $_GET))
			return 'listQuiz';

		return 'startPage';
	}
}