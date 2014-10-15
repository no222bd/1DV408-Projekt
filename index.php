<?php

require_once('login/controller/AuthenticationRouter.php');
require_once('view/HTML5Base.php');

session_start();

$login = new \login\controller\AuthenticationRouter();

$html = new \view\Html5Base();

$html->getHTML($login->authenticationRouter());



// <?php

//  require_once("view/HTML5Base.php");
// // require_once("model/Question.php");
// // require_once("view/Question.php");
// // require_once("model/Quiz.php");
//  require_once("controller/Master.php");

// session_start();

// $router = new \controller\Master();
// $html = new \view\Html5Base();

// $html->getHTML($router->doRoute());

