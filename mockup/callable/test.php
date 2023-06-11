<?php


function test ($text)
{
	echo $text;
}


class Tester {
	public static function test($text) {
		echo $text;
	}
}






function call(callable $func, $args)
{
	$func($args);
}




// call("test", "THE TEXT");

call("Tester::test", "THE TEXT");
