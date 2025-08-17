<?php
namespace controller;

use Base;

abstract class PrivateCtrl extends Ctrl
{
	public static function beforeRoute (Base $f3, array $params, string $controller)
	{
		parent::beforeRoute($f3, $params, $controller);
		
		if (empty($f3->get("SESSION.auth.user"))) {
			$f3->reroute("@login");
			die;
		}
	}
    
	
	public static function afterRoute (Base $f3, array $params, string $controller)
	{
		parent::afterRoute($f3, $params, $controller);
	}

}
