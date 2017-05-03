<?php
  
namespace Ecjia\System\Theme;

use ecjia;
use RC_Hook;
use Royalcms\Component\Support\Manager;

class ThemeManager extends Manager
{
    
    private $availableThemes = array();
    
    /**
     * Create a new manager instance.
     *
     * @param  \Royalcms\Component\Foundation\Royalcms  $royalcms
     * @return void
     */
    public function __construct($royalcms)
    {
        parent::__construct($royalcms);
        
        $this->loadAvailableThemes();
    }
    
    
    public function hasDriver($driver)
    {
        return isset($this->drivers[$driver]) ? true : false;
    }
    
    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->getTemplateName();
    }
    
    public function getAvailableThemes()
    {
        $availableThemes = array();
        
        foreach ($this->availableThemes as $theme) 
        {
            $availableThemes[$theme] = new Theme($theme);
        }
        
        return $availableThemes;
    }
    
    protected function loadAvailableThemes()
    {
        if (is_dir(SITE_THEME_PATH)) {
            $theme_dir = opendir(SITE_THEME_PATH);
    
            while (false != ($file = readdir($theme_dir))) {
                if ($file != '.' &&
                    $file != '..' &&
                    $file != '.svn' &&
                    $file != '.git' &&
                    $file != 'index.htm' &&
                    $file != 'index.html' &&
                    is_dir(SITE_THEME_PATH . $file)) {
                        $this->availableThemes[] = $file;
                        
                        $this->extend($file, function ($royalcms) use ($file) {
                        	return new Theme($file);
                        });
                    }
            }
    
            closedir($theme_dir);
        }
    }
    
    public function getTemplateCode()
    {
        return RC_Hook::apply_filters('ecjia_theme_template_code', 'template');
    }
    
    public function getTemplateName()
    {
        return ecjia::config($this->getTemplateCode());
    }
    
    public function getStyleCode()
    {
        return RC_Hook::apply_filters('ecjia_theme_stylename_code', 'stylename');
    }
    
    public function getStyleName()
    {
        return ecjia::config($this->getStyleCode());
    }
    
}
