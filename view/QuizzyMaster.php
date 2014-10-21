<?php

namespace view;

class QuizzyMaster {

	// Admin
	
	public static $PATH_MANAGE_USER = 'manageuser';
	public static $PATH_DELETE_USER = 'deleteuser';
	public static $PATH_MAKEADMIN = 'makeadmin';

	public static $PATH_MANAGE_QUIZ = 'managequiz';
	public static $PATH_CREATE_QUIZ = 'createquiz';
	public static $PATH_DELETE_QUIZ = 'deletequiz';

	// User 
	public static $PATH_DO_QUIZ = 'doquiz';
	public static $PATH_LIST_AVALIBLE = 'avaliblequiz';
	public static $PATH_LIST_DONE = 'donequiz';
	public static $PATH_SHOW_RESULT = 'showresult';

	// Övriga
	public static $USER_ID = 'user';
	public static $QUIZ_ID = 'quiz';

	public static $PATH_REGISTER = 'register';
	public static $PATH_HOME = 'home';

	private $user;

	public function __construct($user) {
		$this->user = $user;
	}

	public static function getAction() {

		if(isset($_GET['action'])) {

			switch ($_GET['action']) {

				case self::$PATH_MANAGE_USER:
					return self::$PATH_MANAGE_USER;
					break;
				case self::$PATH_DELETE_USER:
					return self::$PATH_DELETE_USER;
					break;
				case self::$PATH_MAKEADMIN:
					return self::$PATH_MAKEADMIN;
					break;

				case self::$PATH_MANAGE_QUIZ:
					return self::$PATH_MANAGE_QUIZ;
					break;
				case self::$PATH_CREATE_QUIZ:
					return self::$PATH_CREATE_QUIZ;
					break;




				case self::$PATH_REGISTER:
					return self::$PATH_REGISTER;
					break;

				case self::$PATH_LIST_AVALIBLE:
					return self::$PATH_LIST_AVALIBLE;
					break;
				case self::$PATH_LIST_DONE:
					return self::$PATH_LIST_DONE;
					break;
				case self::$PATH_SHOW_RESULT:
					return self::$PATH_SHOW_RESULT;
					break;
				case self::$PATH_DO_QUIZ:
					return self::$PATH_DO_QUIZ;
					break;
				
				
				
				
				
				default:
					return self::$PATH_HOME;
					break;
			}
		} else
			return self::$PATH_HOME;
	}

	public function getAdminHTML() {

		$html = '<h2>Välkommen ' . $this->user->getUsername() . '</h2>
				 <a href="?action=' . self::$PATH_CREATE_QUIZ . '">Skapa quiz</a><br/>
				 <a href="?action=' . self::$PATH_MANAGE_QUIZ . '">Quizlista</a><br/>
				 <a href="?action=' . self::$PATH_MANAGE_USER . '">Användarlista</a><br/>';
		$html .= '<form method="post">
					<input type="submit" name="logout" value="Logga ut">
				  </form>';

		return $html;
	}

	public function getUserHTML() {

		$html = '<h2>Välkommen ' . $this->user->getUsername() . '</h2>
				 <a href="?action=' . self::$PATH_LIST_AVALIBLE . '">Tillgängliga quiz</a><br/>
				 <a href="?action=' . self::$PATH_LIST_DONE . '">Gjorda quiz</a><br/>';
		$html .= '<form method="post">
					<input type="submit" name="logout" value="Logga ut">
				  </form>';

		return $html;
	}
}

// case \view\QuizzyMaster::$PATH_LIST_AVALIBLE:
// 						return (new \controller\Quiz())->listAvalibleQuiz();
// 						break;