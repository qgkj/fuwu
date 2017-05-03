<?php
  
namespace Ecjia\System\Theme;

use RC_File;

class ThemeTemplate
{
    
    protected $file;
    
    protected $file_shortname;
    
    protected $filePath;
    
    protected $fileInfo;
    
    protected $libraries;
    
    protected $regions;
    
    /**
     * 动态库项目
     * @var array
     */
    protected $dynamic_libraries;
    
    /**
     * 主题对象
     * @var \Ecjia\System\Theme\Theme;
     */
    protected $theme;
    
    /**
     * Widget数据库更新
     * 
     * @var \Ecjia\System\Theme\WidgetMethod;
     */
    protected $mtehod;
    
    public function __construct(Theme $theme, $file)
    {
        if (substr($file, -4) != '.php')
        {
            $file .= '.php';
        }
        
        $this->theme = $theme;
        $this->file = $file;
        $this->file_shortname = basename(substr($this->file, 0, strpos($this->file, '.')));
        $this->filePath = $this->theme->getThemeDir() . $file;
        $this->fileInfo = $this->loadFileinfo();
        $this->libraries = $this->loadEditableLibraries();
        $this->regions = $this->loadEditableRegions();
        $this->mtehod = new WidgetMethod($this->theme, $this->file);
    }
    
    protected function loadFileinfo()
    {
        $default_headers = array(
            'Name' => 'Name',
            'Description' => 'Description',
            'Libraries' => 'Libraries',
        );
        
        $data = RC_File::get_file_data( $this->filePath, $default_headers, 'template' );
        
        if ($data['Libraries']) {
            $data['Libraries'] = explode(',', $data['Libraries']);
        }
        
        $data['File'] = $this->file;
        
        return $data;
    }
    
    public function getFileinfo()
    {
        return $this->fileInfo;
    }

    /**
     * 每个模板允许设置的库项目
     */
    public function getAllowSettingLibraries()
    {
        return $this->fileInfo['Libraries'];
    }
    
    /**
     * 获得模版文件中的所有编辑区域
     * 
     * @return array
     */
    protected function loadEditableRegions()
    {
        /* 将模版文件的内容读入内存 */
        $content = file_get_contents($this->filePath);
        
        /* 获得所有编辑区域 */
        static $regions = array();
        
        if (empty($regions)) {
            $matches = array();
            $result  = preg_match_all('/(<!--\\s*TemplateBeginEditable\\sname=")([^"]+)("\\sdesc=")([^"]+)("\\s*-->)/', $content, $matches, PREG_SET_ORDER);
        
            if ($result && $result > 0) {
                foreach ($matches AS $key => $val) {
                    if ($val[2] != 'doctitle' && $val[2] != 'head') {
                        $regions[$key]['name'] = $val[2];
                        $regions[$key]['desc'] = $val[4];
                    }
                }
            }
        
        }

        return $regions;
    }
    
    /**
     * 获得模版文件中的编辑区域中所有的库项目文件
     * 
     * @return array
     */
    protected function loadEditableLibraries()
    {
        $libs = array();
        
        $regions = $this->loadEditableRegions();

        /* 将模版文件的内容读入内存 */
        $content = file_get_contents($this->filePath);
        
        /* 遍历所有编辑区 */
        foreach ($regions AS $key => $val) {
            $matches = array();
            $pattern = '/(<!--\\s*TemplateBeginEditable\\sname="%s"\\sdesc="%s"\\s*-->)(.*?)(<!--\\s*TemplateEndEditable\\s*-->)/s';

            if (preg_match(sprintf($pattern, $val['name'], $val['desc']), $content, $matches)) {
                /* 找出该编辑区域内所有库项目 */
                $lib_matches = array();

                $result      = preg_match_all('/([\s|\S]{0,20})(<!--\\s#BeginLibraryItem\\s")([^"]+)("\\s-->)<!--\\s#EndLibraryItem\\s-->/', $matches[2], $lib_matches, PREG_SET_ORDER);
                
                if ($result && $result > 0) {
                    $i = 0;
                    foreach ($lib_matches AS $k => $v) {
                        $v[3]   = strtolower($v[3]);
                        $library = basename($v[3]);
                        $libs[] = with(new ThemeWidget($this->theme, $library))->setTemplate($this->file_shortname)->setRegion($val['name'])->setSortOrder($i);
                        $i++;
                    }
        
                }
            }
        }

        return $libs;
    }
    
    /**
     * 获得指定库项目在模板中的设置内容
     *
     * @access  public
     * @param   string  $lib    库项目
     * @return  void
     */
    public function getEditableSettedLibrary($lib)
    {
        //$libs 包含设定内容区域的library数组
        $libs = $this->getEditableLibraries();

        foreach ($libs as $key => $widget) {
            $val = $widget->process();
            if ($lib == $val['type']) {
                return $widget;
            }
        }
        
        $library = $lib . '.lbi.php';
        return with(new ThemeWidget($this->theme, $library));
    } 
    
    /**
     * 获取数据库中设置过的Libraray
     * 
     * @return array
     */
    public function getDBSettedLibraries()
    {
        $data = $this->mtehod->readRegionWidgets();
        return $data;
    }
    
    public function getEditableRegions()
    {
        return $this->regions;
    }
    
    public function getEditableLibraries()
    {
        return $this->libraries;
    }
    
    public function getDynamicLibraries()
    {
        $this->dynamic_libraries = array(
            'cat_goods',
            'brand_goods',
            'cat_articles',
            'ad_position',
        );
        
        return $this->dynamic_libraries;
    }
    
    public function getWidgetMethod()
    {
        return $this->mtehod;
    }
    
}
