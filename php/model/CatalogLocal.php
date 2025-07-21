<?php
namespace model;

class CatalogLocal extends Mdl
{
	
	final $table = "catalog_local";
	
	final $fieldConf = [
		"catalog_id" => [
			"belongs-to-one" => Catalog::class,
		],
	];
	
}
