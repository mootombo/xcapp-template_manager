<?php
return [
	'resources' => [
		'theme_switch' => ['url' => '/template_manager'],
		'theme_switch_api' => ['url' => '/api/0.1/template_manager']
	],
	'routes' => [
		['name' => 'settings#set', 'url' => '/settings/{setting}/{value}', 'verb' => 'POST'],
		['name' => 'settings#get', 'url' => '/settings', 'verb' => 'GET'],
		['name' => 'page#index', 'url' => '/', 'verb' => 'GET'],
		['name' => 'theme_switch_api#preflighted_cors', 'url' => '/api/0.1/{path}',
		 'verb' => 'OPTIONS', 'requirements' => ['path' => '.+']]
	]
];
