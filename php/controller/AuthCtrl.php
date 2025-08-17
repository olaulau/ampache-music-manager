<?php
namespace controller;

use Base;
use ErrorException;
use model\User;
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
		
		$login = $f3->get("POST.login");
		$password = $f3->get("POST.password");
		if(empty($login) || empty($password)) {
			throw new ErrorException("parameter problem");
		}
		
		$user = new User()->findone(["username = ?", $login]);
		if(empty($user)) {
			sleep(3);
			echo "user not found";
			die;
		}
		
		if ($user->password !== hash("sha256", $password)) {
			sleep(3);
			echo "password missmatch";
			die;
		}
		
		if($user->access !== 100) {
			throw new ErrorException("insuffisant access");
		}
		
		$f3->set("SESSION.auth.login", $login);
		$f3->reroute("@homepage");
	}
	
	
	public static function logoutGET (Base $f3, array $params, string $controller)
	{
		$f3->clear("SESSION.auth.login");
		$f3->reroute("@homepage");
	}
	
}
