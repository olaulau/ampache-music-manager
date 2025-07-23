<?php
namespace model;

class Artist extends Mdl
{
	
	final $table = "artist";
	
	final $fieldConf = [
		"albums" => [
			"relationType" => [Album::class, "album_artist"],
		],
	];
	
}
