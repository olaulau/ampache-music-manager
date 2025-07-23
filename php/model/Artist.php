<?php
namespace model;

class Artist extends Mdl
{
	
	final $table = "artist";
	
	final $fieldConf = [
		"albums" => [
			"has-many" => [Album::class, "album_artist"],
		],
	];
	
}
