<?php

namespace view;

class MessageHandler {

    private static $message = 'message';

    public function hasMessage() {
        return !empty($_COOKIE[self::$message]);
    }

    public function setMessage($message) {
        setcookie(self::$message, $message, 0);
    }

    public function getMessage() {
        $output = $_COOKIE[self::$message];

        $this->removeMessage();

        return $output;
    }

    public function removeMessage() {
        setcookie(self::$message, '', time() - 1);
    }
}
