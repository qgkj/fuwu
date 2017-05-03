<?php
  
class ecjia_open
{
    /**
     * An array of registered Response macros.
     *
     * @var array
     */
    protected static $macros = array();
    
    protected $openType;
    
    protected $url;
    
    protected $scheme;
    
    protected $host;
    
    protected $queryString;
    
    protected $querys = array();
    
    public function __construct($url)
    {
        $this->url = $url;
        $this->parseUrl();
    }
    
    protected function parseUrl()
    {
        $parts = parse_url($this->url);
        
        $this->scheme = $parts['scheme'];
        
        if ($this->scheme != 'ecjiaopen') {
            throw new InvalidArgumentException(__('Url Scheme不是ecjiaopen。'));
        }
        
        $this->host = $parts['host'];
        $this->queryString = $parts['query'];
        
        parse_str($this->queryString, $this->querys);

        if (isset($this->querys['open_type'])) {
            $this->openType = array_get($this->querys, 'open_type');
            unset($this->querys['open_type']);
        }

    }
    
    public function getScheme()
    {
        return $this->scheme;
    }
    
    public function getHost()
    {
        return $this->host;
    }
    
    public function getOpenType()
    {
        return $this->openType;
    }
    
    public function getQuerys()
    {
        return $this->querys;
    }
    
    public function toHttpUrl() 
    {
        if (isset(static::$macros[$this->openType]))
        {
            return call_user_func_array(static::$macros[$this->openType], array($this->querys));
        }
        
        throw new \BadMethodCallException("Call to undefined opentype $this->openType");
    }
    
    /**
     * Register a macro with the Response class.
     *
     * @param  string  $name
     * @param  callable  $callback
     * @return void
     */
    public static function macro($name, $callback)
    {
        static::$macros[$name] = $callback;
    }
    
    /**
     * Handle dynamic calls into Response macros.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     *
     * @throws \BadMethodCallException
     */
    public static function __callStatic($method, $parameters)
    {
        if (isset(static::$macros[$method]))
        {
            return call_user_func_array(static::$macros[$method], $parameters);
        }
    
        throw new \BadMethodCallException("Call to undefined method $method");
    }
    
}