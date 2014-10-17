<?php

namespace model;

class User {

	private $userId;
	private $username;
	private $password;
	private $userType;

	public function __construct($username, $password) {
		$this->username = $username;
		$this->password = $password;
	}

	public function equals(\model\User $otherUser) {
		if($this->username !== $otherUser->username)
			return false;

		if($this->password !== $otherUser->password)
			return false;

		return true;
	}

	public function getUserId() {
		return $this->userId;
	}

	public function getUsername() {
		return $this->username;
	}

	public function getPassword() {
		return $this->password;
	}

	public function getUserType() {
		return $this->password;
	}

	public function setUserId($userId) {
		$this->userId = $userId;
	}

	public function setUserType($userType) {
		$this->userType = $userType;
	}
}