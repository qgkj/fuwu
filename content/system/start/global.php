<?php
  
use Royalcms\Component\Support\Facades\Royalcms;

// Load the default text localization domain.
RC_Locale::load_default_textdomain();

//加载项目函数库
RC_Loader::load_sys_func('functions');

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a basic log file setup which creates a single file for logs.
|
*/

RC_Log::useDailyFiles(SITE_CACHE_PATH . 'logs/royalcms.log', 30);

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

Royalcms::error(function(Exception $exception)
{
    $err = array(
        'file'      => $exception->getFile(),
        'line'      => $exception->getLine(),
        'code'      => $exception->getCode(),
        'url'       => RC_Request::fullUrl(),
    );

    RC_Logger::getLogger(RC_Logger::LOG_ERROR)->error($exception->getMessage(), $err);
});
Royalcms::error(function(ErrorException $exception)
{
    $err = array(
        'file'      => $exception->getFile(),
        'line'      => $exception->getLine(),
        'code'      => $exception->getCode(),
        'url'       => RC_Request::fullUrl(),
    );
    
    RC_Logger::getLogger(RC_Logger::LOG_ERROR)->error($exception->getMessage(), $err);
    royalcms('sentry')->captureException($exception);
});
Royalcms::fatal(function(Exception $exception)
{
    $err = array(
        'file'      => $exception->getFile(),
        'line'      => $exception->getLine(),
        'code'      => $exception->getCode(),
        'url'       => RC_Request::fullUrl(),
    );
    
    RC_Logger::getLogger(RC_Logger::LOG_ERROR)->error($exception->getMessage(), $err);
    royalcms('sentry')->captureException($exception);
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
*/

Royalcms::down(function()
{
    return RC_Response::make("Be right back!", 503);
});

Royalcms::missing(function($exception)
{
    return RC_Response::make('404 Not Found', 404);
});


RC_Event::listen('royalcms.query', function($query) {
    if (royalcms('config')->get('system.debug')) {
        RC_Logger::getLogger(RC_Logger::LOG_SQL)->info($query);
    }
});

RC_Event::listen('royalcms.warning.exception', function($exception) {
    if (royalcms('config')->get('system.debug')) {
        $err = array(
		            'file'      => $exception->getFile(),
		            'line'      => $exception->getLine(),
		            'code'      => $exception->getPrevious(),
		            'url'       => RC_Request::fullUrl(),
	            );
        RC_Logger::getLogger(RC_Logger::LOG_WARNING)->info($exception->getMessage(), $err);
    }
});
