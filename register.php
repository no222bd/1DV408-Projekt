<?php

require_once('login/controller/Register.php');
require_once("view/HTML5Base.php");

session_start();

$register = new \login\controller\Register();

$html = new \view\Html5Base();

$html->getHTML($register->doRegister());