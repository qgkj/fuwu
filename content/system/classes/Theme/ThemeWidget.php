<?php
  
namespace Ecjia\System\Theme;

use Royalcms\Component\Uuid\Uuid;

class ThemeWidget extends ThemeLibrary
{
    
    /**
     * widget标识，唯一
     * @var string
     */
    protected $id;
    
    /**
     * 所在模板文件
     * @var string
     */
    protected $template;
    
    /**
     * 所属布局区域
     * @var string
     */
    protected $region;
    
    /**
     * 库项目路径，相对于模板位置的路径
     * @var string
     */
    protected $library;
    
    /**
     * This widget type as library file name
     * @var string
     */
    protected $type;
    
    /**
     * 添加类型，是单个还是允许多个，single or multi
     * @var string
     */
    protected $addNew;
    
    /**
     * 排序
     * @var integer
     */
    protected $sortOrder = 0;
    
    /**
     * 在当前页面是否可用
     * 
     * @var boolean
     */
    protected $enabled = true;
    
    /**
     * 自定义显示标题
     * @var string
     */
    protected $title;
    
    /**
     * Widget common configs sava array serialize values
     * @var array
     */
    protected $widgetConfig = array();
    
    /**
     * 该类型在同一个页面中只允许出现一个，不能重复
     * @var unknown
     */
    const ADDTYPESINGLE = 'single'; 
    
    /**
     * 该类型在同一个页面中允许出现多个
     * @var unknown
     */
    const ADDTYPEMULTI = 'multi';
    
    
    public function __construct($theme, $file)
    {
        parent::__construct($theme, $file);
        
        $this->type = basename(substr($this->file, 0, strpos($this->file, '.')));
        
        $this->library = '/library/' . $this->file;

        $this->id = Uuid::generate();
    }
    
    public function getType()
    {
        return $this->type;
    }
    
    public function getLibrary()
    {
        return $this->library;
    }
    
    /**
     * 设置模板变量
     * 
     * @param string $template
     * 
     * @return \Ecjia\System\Theme\ThemeWidget
     */
    public function setTemplate($template)
    {
        $this->template = $template;
        return $this;
    }
    
    public function getTemplate()
    {
        return $this->template;
    }
    
    /**
     * 设置页面区域变量
     * 
     * @param string $region
     * 
     * @return \Ecjia\System\Theme\ThemeWidget
     */
    public function setRegion($region)
    {
        $this->region = $region;
        return $this;
    }
    
    public function getRegion()
    {
        return $this->region;
    }
    
    /**
     * 设置添加类型
     * 
     * @param string $type
     * 
     * @return \Ecjia\System\Theme\ThemeWidget
     */
    public function setAddType($type)
    {
        $this->addNew = $type;
        return $this;
    }
    
    public function getAddType()
    {
        return $this->addNew;
    }
    
    /**
     * 设置ID标识符
     * 
     * @param string $id
     * 
     * @return \Ecjia\System\Theme\ThemeWidget
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * 设置排序
     * 
     * @param integer $sort
     * 
     * @return \Ecjia\System\Theme\ThemeWidget
     */
    public function setSortOrder($sort)
    {
        $this->sortOrder = $sort;
        return $this;
    }
    
    public function getSortOrder()
    {
        return $this->sortOrder;
    }
    
    /**
     * 设置当前模板是否可用
     * 
     * @param boolean $bool
     * 
     * @return \Ecjia\System\Theme\ThemeWidget
     */
    public function setEnabled($bool)
    {
        $this->enabled = $bool;
        return $this;
    }
    
    public function getEnabled()
    {
        return $this->enabled;
    }
    
    /**
     * 设置显示标题
     * 
     * @param string $title
     * 
     * @return \Ecjia\System\Theme\ThemeWidget
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }
    
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * 设置Widget的数据配置项
     * 
     * @param array $config
     * 
     * @return \Ecjia\System\Theme\ThemeWidget
     */
    public function setWidgetConfig(array $config)
    {
        $this->widgetConfig = $config;
        return $this;
    }
    
    public function getWidgetConfig()
    {
        return $this->widgetConfig;
    }
    
    /**
     * 拼装结果
     * 
     * @return array
     */
    public function process() {
        return array(
            'id'            => $this->id,
            'name'          => $this->fileInfo['Name'],
            'desc'          => $this->fileInfo['Description'],
            'theme'         => $this->theme->getThemeCode(),
            'template'      => $this->template,
            'library'       => $this->library,
            'region'        => $this->region,
            'sort_order'    => $this->sortOrder,
            'type'          => $this->type,
            'add_new'       => $this->addNew,
        );
    }
    
}