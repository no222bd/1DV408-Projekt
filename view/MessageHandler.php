<?php

namespace view;

// Handles the user feedback
class MessageHandler {

	private $currentMessage;
	
	// Check if message exists
	public function hasMessage() {
		return !empty($_COOKIE['message']);
	}

	public function setMessage($message) {
		setcookie('message', $message, 0);
	}

	public function getMessage() {
		$output = $_COOKIE['message'];
			
		$this->removeMessage();

		return $output;
	}

	public function removeMessage() {
		setcookie('message', '', time() - 1);
	}
}