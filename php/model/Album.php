<?php
namespace model;

class Album extends Mdl
{
	
	final $table = "album";
	
	final $fieldConf = [
		"album_artist" => [
			"belongs-to-one" => Artist::class,
		],
	];
	
}
