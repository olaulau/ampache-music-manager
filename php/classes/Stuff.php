<?php
namespace classes;


class Stuff
{
	
	public static function secondesToDurationString (int $seconds) : string
	{
		$minuts = intdiv($seconds, 60);
		$seconds =  $seconds % 60;
		return "{$minuts}'{$seconds}";
	}
	
}
