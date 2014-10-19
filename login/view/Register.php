<?php

namespace login\view;

class Register {
	
	private static $registerButton = 'registerButton';
	private static $username = 'username';
	private static $password = 'password';
	private static $repeatedPassword = 'repeatedPassword';

	private $message;

	public function wantToRegister(){
		return isset($_POST[self::$registerButton]);
	}

	public function getUsername(){
		return $_POST[self::$username];
	}

	public function getPassword(){
		return $_POST[self::$password];
	}

	public function getRepeatedPassword(){
		return $_POST[self::$repeatedPassword];
	}

	public function getLoginPage() {
		header('Location: ' . $_SERVER['PHP_SELF']);
	}

	public function setNonMatchingPasswordsMessage() {
		$this->message = 'Lösenorden matchar inte';
	}

	public function setUsernameOccupiedMessage() {
		$this->message = 'Användarnamnet är upptaget';
	}

	public function setTooShortUsernameMessage() {
		$this->message = 'Användarnamnet skall vara minst 6 tecken';
	}

	public function setTooShortPasswordMessage() {
		$this->message = 'Lösenordet skall vara minst 6 tecken';
	}

	public function getRegisterHTML() {
		
		$html = '<h2>Registrera användare</h2>
				
				<form id="authentication" action="' . $_SERVER['PHP_SELF'] . '?action=register" method="post">		<!-- STRÄNGBEROENDE!!! -->
					<fieldset>
						<!--legend>Registrera ny användare</legend-->';
		
		if(isset($this->message))
			$html .= '<p class="message">' . $this->message . '</p>';
		
		$html .= '<label>Namn
					 	<input type="text" name="' . self::$username . '"';

		// Set value of username input tag
		if(isset($_POST[self::$username]))
			$html .= ' value="' . strip_tags($_POST[self::$username]) . '"';

		$html .= '/>
					</label><br/>
					<label>Lösenord
 						<input type="password" name="' . self::$password . '"/>
					</label><br/>
					<label>Repetera lösenord
						<input type="password" name="' .self::$repeatedPassword. '"/>
					</label><br/>
					<input type="submit" name="' . self::$registerButton . '" value="Registrera"/>
				</fieldset>
			</form>
			<p><a href="' . \Settings::$ROOT_PATH . '">Tillbaka</a></p>											<!-- STRÄNGBEROENDE!!! -->';
		
		return $html;
	}
}