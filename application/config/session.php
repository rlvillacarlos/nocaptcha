<?php defined('SYSPATH') OR die('No direct access allowed.');

return array(
    'native' => array(
        'name' => 'nocaptcha',
        'lifetime' => 3600,
    ),
    'cookie' => array(
        'name' => 'nocaptcha',
        'encrypted' => TRUE,
        'lifetime' => 3600,
    ),
    'database' => array(
        'name' => 'nocaptcha',
        'encrypted' => TRUE,
        'lifetime' => 3600,
        'group' => Kohana::$environment === Kohana::PRODUCTION? 
                    'MySQLi_Production':Kohana::$environment === Kohana::STAGING?
                        'MySQLi_Staging':'MySQLi_Development',
        'table' => 'sessions',
        'columns' => array(
            'session_id'  => 'session_id',
            'last_active' => 'last_active',
            'contents'    => 'contents'
        ),
        'gc' => 500,
    ),
);