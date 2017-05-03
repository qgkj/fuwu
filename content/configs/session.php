<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

return array(
    
    'driver'                => env('SESSION_DRIVER', 'mysql'),

    'session_name'          => 'ecjia_token',
    'session_admin_name'    => 'ecjia_admin_token',
    
    'lifetime'              => 43200,
    'domain'                => env('SESSION_DOMAIN', null),
    'secure'                => env('SESSION_SECURE_COOKIE', false),
    
    'httponly'              => true,

);

// end