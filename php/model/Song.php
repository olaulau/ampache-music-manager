<?php
namespace model;

class Song extends Mdl
{
	
	final $table = "song";
	
	final $fieldConf = [
		"album" => [
			"belongs-to-one" => Album::class,
		],
	];
	
}
