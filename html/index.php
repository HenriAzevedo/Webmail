<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../config/config.php';

use Api\Tools as Tools;
use Api\TranslatorError as TranslatorError;

try{
	var_dump($_GET);
		
}catch(Exception $er){
	$error 	  = TranslatorError::getTranslate($er)[0];
	$solution = TranslatorError::getTranslate($er)[1];
	if(Tools::isAjax()){
		//$response[]
	}else{
		$_SESSION['error'] = $error;
		$_SESSION['solution'] = $solution;
	}
	var_dump($error);
}
?>