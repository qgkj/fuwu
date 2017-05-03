<?php
  
namespace Ecjia\System\Theme;

class ParseThemeStyle
{
    private $template_name;
    
    private $template_uri;
    
    private $template_desc;
    
    private $template_version;
    
    private $template_author;
    
    private $author_uri;
    
    private $logo_filename;
    
    private $template_type;
    
    private $template_color;
    
    private $stylename;
    
    /**
     * 模板缩略图
     * @var string
     */
    private $screenshot;
    
    private $style;
    private $style_path;
    
    /**
     * 主题对象
     * @var \Ecjia\System\Theme\Theme;
     */
    private $theme;
    
    public function __construct(Theme $theme, $stylename = null)
    {
        $this->theme = $theme;
        $this->stylename = $stylename;
        
        $this->parseScreenshot();
        $this->parseStyle();
    }
    
    
    /**
     * 解析模板的缩略图Screenshot
     */
    protected function parseScreenshot()
    {
        $ext  = array('png', 'gif', 'jpg', 'jpeg');
        
        if ($this->stylename) 
        {
            foreach ($ext as $val) {
                if (file_exists($this->theme->getThemeDir() . 'images/screenshot_' . $this->stylename . '.' . $val)) {
                    $this->screenshot = $this->theme->getThemeUrl() . 'images/screenshot_' . $this->stylename . '.' . $val;
                    break;
                }
            }
        }
        else {
            $this->screenshot = null;
        }
        
        if (! $this->screenshot)
        {
            foreach ($ext as $val) {
                if (file_exists($this->theme->getThemeDir() . 'images/screenshot.' . $val)) {
                    $this->screenshot = $this->theme->getThemeUrl() . 'images/screenshot.' . $val;
                    break;
                }
            }
        }
 
    }
    
    protected function parseStyle()
    {
        $this->style = $this->theme->getThemeUrl() . 'style.css';
        $this->style_path = $this->theme->getThemeDir() . 'style.css';
        
        if ($this->stylename) {
            $css_stylename_path = $this->theme->getThemeDir() . 'style_' . $this->stylename . '.css';
            $css_stylename_url = $this->theme->getThemeUrl() . 'style_' . $this->stylename . '.css';
        } else {
            $css_stylename_path = null;
        }
        
        if (file_exists($css_stylename_path)) {
            $this->style = $css_stylename_url;
            $this->style_path = $css_stylename_path;
        }
        
        if (file_exists($this->style_path))
        {
            $arr = array_slice(file($this->style_path), 0, 10);
            $template_name      = explode(': ', $arr[1]);
            $template_uri       = explode(': ', $arr[2]);
            $template_desc      = explode(': ', $arr[3]);
            $template_version   = explode(': ', $arr[4]);
            $template_author    = explode(': ', $arr[5]);
            $author_uri         = explode(': ', $arr[6]);
            $logo_filename      = explode(': ', $arr[7]);
            $template_type      = explode(': ', $arr[8]);
            $template_color     = explode(': ', $arr[9]);
            
            $this->template_name = isset($template_name[1]) ? trim($template_name[1]) : '';
            $this->template_uri = isset($template_uri[1]) ? trim($template_uri[1]) : '';
            $this->template_desc = isset($template_desc[1]) ? trim($template_desc[1]) : '';
            $this->template_version = isset($template_version[1]) ? trim($template_version[1]) : '';
            $this->template_author = isset($template_author[1]) ? trim($template_author[1]) : '';
            $this->author_uri = isset($author_uri[1]) ? trim($author_uri[1]) : '';
            $this->logo_filename = isset($logo_filename[1]) ? trim($logo_filename[1]) : '';
            $this->template_type = isset($template_type[1]) ? trim($template_type[1]) : '';
            $this->template_color = isset($template_color[1]) ? trim($template_color[1]) : ''; 
        }
    }
    
    /**
     * 拼装结果
     *
     * @api
     */
    public function process() {
        return array(
            'name'      => $this->template_name,
            'uri'       => $this->template_uri,
            'desc'      => $this->template_desc,
            'version'   => $this->template_version,
            'author'        => $this->template_author,
            'author_uri'    => $this->author_uri,
            'logo'      => $this->logo_filename,
            'type'      => $this->template_type,
            'color'     => $this->template_color,
            'screenshot'    => $this->screenshot,
            'style'         => $this->style,
            'stylename' => $this->stylename,
            'code'      => $this->theme->getThemeCode(),
        );
    }
    
    /**
     * 魔术方法
     *
     * @api
     */
    public function __toString() {
        return var_export($this->process(), true);
    }
    
    public function getName()
    {
        return $this->template_name;
    }
    
    public function getUri()
    {
        return $this->template_uri;
    }
    
    public function getDesc()
    {
        return $this->template_desc;
    }
    
    public function getVersion()
    {
        return $this->template_version;
    }
    
    public function getAuthor()
    {
        return $this->template_author;
    }
    
    public function getAuthorUri()
    {
        return $this->author_uri;
    }
    
    public function getLogo()
    {
        return $this->logo_filename;
    }
    
    public function getType()
    {
        return $this->template_type;
    }
    
    public function getColor()
    {
        return $this->template_color;
    }
    
    public function getScreenshot()
    {
        return $this->screenshot;
    }
    
    public function getStyle()
    {
        return $this->style;
    }
    
}