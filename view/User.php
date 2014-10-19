<?php

namespace view;

require_once('view/MessageHandler.php');

class User {

	private $messageHandler;

	public function __construct() {
		$this->messageHandler = new \view\MessageHandler();
	}

	public function getUserListHTML(array $users) {

		$html = '<h2 style="border-bottom: 4px solid #aaa">Användare</h2>';

		if($this->messageHandler->hasMessage())
			$html .= '<p>' . $this->messageHandler->getMessage() . '</p>';

		foreach ($users as $user) {

			$html .= '<p>' . $user->getUserId(). ' ' . $user->getUsername() . ' ' . $user->getIsAdmin() . '
				     <a href="?action=' . \view\QuizzyMaster::$PATH_DELETE_USER . '&user=' . $user->getUserId() . '">Ta bort</a>
				     <a href="?action=' . \view\QuizzyMaster::$PATH_MAKEADMIN . '&user=' . $user->getUserId() . '">Gör till admin</a></p>'; 
		}

		return $html;
	}
}