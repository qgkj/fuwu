<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

return array (

	'fetch' => PDO::FETCH_ASSOC,

	'connections' => array(

		'mysql' => array(
			'host'      => env('DB_HOST', 'localhost'),
			'driver'    => 'mysql',
			'database'  => env('DB_DATABASE', 'ecjia'),
			'username'  => env('DB_USERNAME', 'ecjia'),
			'password'  => env('DB_PASSWORD', ''),
			'charset'   => 'utf8mb4',
			'collation' => 'utf8mb4_unicode_ci',
			'prefix'    => env('DB_PREFIX', 'ecjia_'),
		    'port'      => env('DB_PORT', 3306),
		),
	),
    
    'redis' => array(
    
        'cluster' => false,
    
        'default' => array(
            'host'     => env('REDIS_HOST', 'localhost'),
            'password' => env('REDIS_PASSWORD', null),
            'port'     => env('REDIS_PORT', 6379),
            'database' => 0,
            ),
    
        'session' => array(
            'host'     => env('REDIS_HOST', 'localhost'),
            'password' => env('REDIS_PASSWORD', null),
            'port'     => env('REDIS_PORT', 6379),
            'database' => 1,
            ),
        ),
);

// end