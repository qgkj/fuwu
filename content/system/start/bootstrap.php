<?php
  
use Royalcms\Component\ClassLoader\ClassManager;

/*
 |--------------------------------------------------------------------------
 | Register The Class Loader
 |--------------------------------------------------------------------------
 |
 | In addition to using Composer, you may use the Laravel class loader to
 | load your controllers and models. This is useful for keeping all of
 | your classes in the "global" namespace without Composer updating.
 |
 */

ClassManager::addNamespaces(array(
    'Ecjia\System' => SITE_SYSTEM_PATH . 'classes',
    
));

if (is_dir(SITE_PLUGIN_PATH.'ueditor')) {
    ClassManager::addNamespaces(array(
        'Royalcms\Component\UEditor' => SITE_PLUGIN_PATH.'ueditor/Royalcms/Component/UEditor',
    ));
} else {
    ClassManager::addNamespaces(array(
        'Royalcms\Component\UEditor' => RC_PLUGIN_PATH.'ueditor/Royalcms/Component/UEditor',
    ));
}

//注册Session驱动
RC_Session::extend('mysql', function () {
    RC_Package::package('system')->loadClass('session.ecjia_session_mysql', false);

    return new ecjia_session_mysql();
});
RC_Session::extend('memcache', function () {
    RC_Package::package('system')->loadClass('session.ecjia_session_memcache', false);

    return new ecjia_session_memcache();
});


