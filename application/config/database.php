<?php defined('SYSPATH') OR die('No direct access allowed.');

return array
(	
 	'MySQLi_Development' => array
 	(
 		'type'       => 'MySQLi',
 		'connection' => array(
 			'hostname'   => 'localhost',
 			'database'   => 'db_nocaptcha',//'db_zion',
 			'username'   => 'root',
 			'password'   => FALSE,
 			'persistent' => FALSE,
 			'ssl'        => NULL,
 		),
 		'table_prefix' => '',
 		'charset'      => 'utf8',
 		'caching'      => FALSE,
 	),
 	'MySQLi_Staging' => array
 	(
 		'type'       => 'MySQLi',
 		'connection' => array(
 			'hostname'   => 'sql107.ultimatefreehost.in',
 			'database'   => 'ltm_16851951_db_zion_2',
 			'username'   => 'ltm_16851951',
 			'password'   => '123456seven',
 			'persistent' => FALSE,
 			'ssl'        => NULL,
 		),
 		'table_prefix' => '',
 		'charset'      => 'utf8',
 		'caching'      => FALSE,
 	),
 	'MySQLi_Production' => array
 	(
 		'type'       => 'MySQLi',
 		'connection' => array(
 			'hostname'   => 'localhost',
 			'database'   => 'zionphin_db_zion_v2',
 			'username'   => 'zionphin_root',
 			'password'   => 'aPTC6+OaI~a~$CR*d-',
 			'persistent' => FALSE,
 			'ssl'        => NULL,
 		),
 		'table_prefix' => '',
 		'charset'      => 'utf8',
 		'caching'      => FALSE,
 	),
);
