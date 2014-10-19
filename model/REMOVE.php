<?php 

namespace model;

class MessageHandler {

	public function hasMessage() {
		return isset($_SESSION['message']);
	}


	public function setMessage($message) {
		$_SESSION['message'] = $message;
	}

	public function getMessage() {
		var_dump($_SESSION['message']); die();

		if(isset($_SESSION['message']))
			$message = $_SESSION['message'];
			unset($_SESSION['message']);
			return $message;
	}
}