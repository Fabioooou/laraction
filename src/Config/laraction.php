<?php

 return [


 	/**
	 * Laraction configuration
	 * ---------------------------
	 *
	 **/

 	'crud' =>
 	[
 		'action' => 
 		[
 			'list' => [
 				'method' 	=> 'list',
 				'name'   	=> 'list',
 				'paginate'  => 30,
 				'search'	=> 'search',
 			],
 			'update' => [
 				'method' => 'update',
 				'name'   => 'update',
 				'pk'     => 'id',
 			],
 			'delete' => [
 				'method' => 'delete',
 				'name' => 'delete',
 				'pk' => 'id',
 			],
 		],
 	],




 	'stubs' => app_path('stubs'),

 

 	'manager' => 
 	[
 		'route' => 'laraction',
 		'schemas' => storage_path('laraction_schemas'),
 		'table' => 'laractions',
 	],


 ];