<?php
namespace model;

use Base;
use DB\Cortex;
use DB\SQL;
use ErrorException;

abstract class Mdl extends Cortex
{
	
	protected $db = "db";
	protected $table;
	
	
	public static function parseDbLogs () : array
	{
		$f3 = Base::instance();
		$db = $f3->get("db"); /** @var SQL $db */
		$logs = $db->log();
		$res = preg_match_all('|\((\d+.\d+)ms\)|', $logs??"", $matches);
		if($res === false) {
			throw new ErrorException("error parsing db logs with regex");
		}
		return $matches [1];
	}
}
