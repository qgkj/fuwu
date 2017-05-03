<?php
  
namespace Ecjia\System\Theme;

class Theme
{
    /**
     * 当前主题代号
     * @var string
     */
    protected $theme_code;
    
    protected $theme_styles = array();
    
    protected $theme_dir;
    
    protected $library_dir;
    
    protected $library_bak_dir;
    
    protected $default_style;
    
    /**
     * 当前主题访问Url
     * @var string
     */
    protected $theme_url;
    
    public function __construct($themeCode) 
    {
        $this->theme_code = $themeCode;
        $this->theme_dir = SITE_THEME_PATH . $this->theme_code . DIRECTORY_SEPARATOR;
        $this->library_dir = $this->theme_dir . 'library' . DIRECTORY_SEPARATOR;
        $this->theme_url = \RC_Theme::get_theme_root_uri()  .'/'. $this->theme_code . '/';
        $this->theme_styles = $this->loadThemeStyles();
        $this->library_bak_dir = SITE_CACHE_PATH . 'backup' . DIRECTORY_SEPARATOR . 'library' . DIRECTORY_SEPARATOR;
        
        $this->createLibraryBakDir();
    }
    
    protected function createLibraryBakDir()
    {
        if (! is_dir($this->library_bak_dir)) {
            royalcms('files')->makeDirectory($this->library_bak_dir);
        }
    }
    
    /**
     * 获取可用的主题风格列表
     */
    protected function loadThemeStyles()
    {
        $available_styles = $this->findAvailableStyles();
        
        $themes = array();
        $themes[] = $this->loadDefaultStyle()->process();
        
        foreach ($available_styles as $key => $value) 
        {
            $themes[] = $this->loadSpecifyStyle($value)->process();
        }
        
        return $themes;
    }
    
    public function getThemeStyles()
    {
        return $this->theme_styles;
    }
    
    
    /**
     * 寻找激活的主题风格样式
     */
    public function findAvailableStyles()
    {
        
        $available_styles = array();
        
        if (file_exists($this->theme_dir)) 
        {
            $tpl_style_dir = opendir($this->theme_dir);
            while (false != ($file = readdir($tpl_style_dir)))
            {
                if ($file != '.' &&
                    $file != '..' &&
                    $file != '.svn' &&
                    $file != 'git' &&
                    $file != 'index.htm' &&
                    $file != 'index.html' &&
                    is_file($this->theme_dir . $file))
                {
                    if ($this->matchStyleFile($file)) {
                        $this->findStyleName($file, $available_styles);
                    }
                }
            }
            closedir($tpl_style_dir);
        }
        
        return $available_styles;
    }
    
    
    private function matchStyleFile($file)
    {
        if (preg_match("/^(style|style_)(.*)*/i", $file)) {
            return true;
        } else {
            return false;
        }
    }
    
    private function findStyleName($file, array & $styles)
    {
        $start = strpos($file, '.');
        $temp = substr($file, 0, $start);
        $temp = explode('_', $temp);
        if (count($temp) == 2) {
            $styles[] = $temp[1];
        }
    }
    
    protected function loadTemplateFiles()
    {
        $files = array();
        
        if (file_exists($this->theme_dir))
        {
            $template_handle = opendir($this->theme_dir);
            while (false != ($file = readdir($template_handle)))
            {
                if (substr($file, -7) == 'dwt.php')
                {
                    $filename = substr($file, 0, -8);
                    $files[$filename] = with(new ThemeTemplate($this, $file))->getFileinfo();
                }
            }
            closedir($template_handle);
        }
        
        return $files;
    }
    
    /**
     * 可以设置内容的模板
     * @return array
     */
    public function getAllowSettingTemplates()
    {
        $files = $this->loadTemplateFiles();
        
        foreach ($files as $key => & $file) 
        {
            if (!$file['Libraries']) {
                unset($files[$key]);
            }
        }
        
        return $files;
    }
    
    public function getLibraryFiles()
    {
        $files = $this->loadLibraryFiles();
        
        foreach ($files as $key => $file)
        {
            if (!$file['Name'] || !$file['Description']) {
                unset($files[$key]);
            }
        }
        
        return $files;
    }
    
    public function getAllLibraryFiles()
    {
        return $this->loadLibraryFiles();
    }
    
    protected function loadLibraryFiles()
    {
        $files = array();
        
        if (is_dir($this->library_dir)) {
            $library_handle = opendir($this->library_dir);
            while (false != ($file = readdir($library_handle))) 
            {
                if (substr($file, -7) == 'lbi.php')
                {
                    $filename         = substr($file, 0, -8);
                    $files[$filename] = with(new ThemeLibrary($this, $file))->getFileinfo();
                }
            }
            closedir($library_handle);
        }
        
        return $files;
    }
    
    public function getDefaultStyle()
    {
        return $this->default_style;
    }
    
    protected function loadDefaultStyle()
    {
        $this->default_style = new ParseThemeStyle($this);
        return $this->default_style;
    }
    
    public function loadSpecifyStyle($stylename)
    {
        return new ParseThemeStyle($this, $stylename);
    }
    
    public function getThemeDir()
    {
        return $this->theme_dir;
    }

    public function getThemeUrl()
    {
        return $this->theme_url;
    }
    
    public function getThemeCode()
    {
        return $this->theme_code;
    }
    
    public function getLibraryDir()
    {
        return $this->library_dir;
    }
    
    public function getLibraryBakDir()
    {
        return $this->library_bak_dir;
    }
}