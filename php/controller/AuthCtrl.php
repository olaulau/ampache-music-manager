<?php
namespace controller;

use Base;
use View;


class AuthCtrl extends Ctrl
{

	public static function beforeRoute ()
	{
		parent::beforeRoute();
	}
    
	
	public static function afterRoute ()
	{
		parent::afterRoute();
	}

	
	public static function loginGET (Base $f3, array $params, string $controller)
	{
		
		
		$view = new View();
		echo $view->render('login.phtml');
	}
	
	
	public static function loginPOST (Base $f3, array $params, string $controller)
	{
		
		
		$f3->reroute("@homepage");
	}
	
}
