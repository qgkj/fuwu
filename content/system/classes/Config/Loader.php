<?php
  
namespace Ecjia\System\Config;

class Loader implements LoaderInterface
{
    
    /**
     * All of the named path hints.
     *
     * @var array
     */
    protected $hints = array();
    
    /**
     * Load the given configuration group.
     *
     * @param  string  $group
     * @param  string  $namespace
     * @return array
     */
    public function load($group, $namespace = null)
    {

    }
    
    /**
     * Determine if the given group exists.
     *
     * @param  string  $group
     * @param  string  $namespace
     * @return bool
     */
    public function exists($group, $namespace = null)
    {

        
        
    }
    
    
    /**
     * Add a new namespace to the loader.
     *
     * @param  string  $namespace
     * @param  string  $hint
     * @return void
     */
    public function addNamespace($namespace, $hint)
    {
        $this->hints[$namespace] = $hint;
    }
    
    /**
     * Returns all registered namespaces with the config
     * loader.
     *
     * @return array
     */
    public function getNamespaces()
    {
        return $this->hints;
    }
    
    
}