<?php namespace Royalcms\Component\UEditor;
  

use Royalcms\Component\Support\ServiceProvider;

class UEditorServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @param  \Royalcms\Component\Routing\Router $router
     * @return void
     */
    public function boot()
    {
        $this->royalcms['translator']->addNamespace('UEditor', realpath(__DIR__ . '/languages'));

        $this->royalcms['config']->package('royalcms/ueditor', __DIR__ . '/configs');
        
        $this->royalcms['router']->any(
            '_ueditor/server',
            array(
                'uses' => 'Royalcms\Component\UEditor\UEditorController@server',
                'as' => 'ueditor.server',
            )
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {}


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {}

}
