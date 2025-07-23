<?php
namespace model;

class Catalog extends Mdl
{
	
	final $table = "catalog";
	
	final $fieldConf = [
		"catalogLocal" => [
			"has-one" => [CatalogLocal::class, "catalog_id"],
		],
	];
	
}
