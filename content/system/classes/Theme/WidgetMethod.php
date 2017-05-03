<?php
  
namespace Ecjia\System\Theme;

use RC_DB;
use Royalcms\Component\Uuid\Uuid;

class WidgetMethod
{
    protected $file;
    
    protected $filename;
    
    protected $region;
    
    /**
     * 主题对象
     * @var \Ecjia\System\Theme\Theme;
     */
    private $theme;
    
    
    public function __construct(Theme $theme, $file)
    {
        $this->theme = $theme;
        $this->file = $file;
        $this->filename = basename(substr($this->file, 0, strpos($this->file, '.')));
    }
    
    public function insertOrUpdateWidget($id, $data)
    {
        $row = RC_DB::table('template_widget')->where('theme', $this->theme->getThemeCode())
                                        ->where('filename', $this->filename)
                                        ->where('region', array_get($data, 'region'))
                                        ->where('type', array_get($data, 'type'))
                                        ->where('library', array_get($data, 'library'))
                                        ->where('id', $id)->first();

        if (!empty($row)) 
        {
            return $this->updateWidget($id, $data);
        }
        else 
        {
            return $this->insertWidget($id, $data);
        }
    }

    public function insertWidget($id, $data)
    {
        $insertData = array(
            'id' => $id ?: (string) Uuid::generate(),
        	'theme' => $this->theme->getThemeCode(),
            'filename'  => $this->filename,
            'region' => array_get($data, 'region'),
            'type' => array_get($data, 'type'),
            'library' => array_get($data, 'library'),
            'sort_order' => array_get($data, 'sort_order'),
            'title' => array_get($data, 'title'),
            'widget_config' => serialize(array_get($data, 'widget_config', array())),
        );
        
        return RC_DB::table('template_widget')->insert($insertData);
    }

    public function updateWidget($id, $data)
    {
        $updateData = array(
            'sort_order' => array_get($data, 'sort_order'),
            'title' => array_get($data, 'title'),
            'widget_config' => serialize(array_get($data, 'widget_config', array())),
        );
        
        return RC_DB::table('template_widget')->where('theme', $this->theme->getThemeCode())
                                        ->where('filename', $this->filename)
                                        ->where('region', array_get($data, 'region'))
                                        ->where('type', array_get($data, 'type'))
                                        ->where('library', array_get($data, 'library'))
                                        ->where('id', $id)
                                        ->update($updateData);
    }

    public function deleteWidget($id)
    {
        return RC_DB::table('template_widget')->where('id', $id)->delete();
    }
    
    
    public function sortWidget($region, array $data)
    {
        foreach ($data as $key => $value)
        {
            RC_DB::table('template_widget')->where('id', $value)
                        ->update(array('sort_order' => $key, 'region' => $region));
        }
    }

    public function readWidgets()
    {
        $data = RC_DB::table('template_widget')->where('theme', $this->theme->getThemeCode())
                                        ->where('filename', $this->filename)
                                        ->where('remarks', '')
                                        ->orderBy('region', 'asc')
                                        ->orderBy('sort_order', 'asc')
                                        ->get();
        $widgets = array();
        foreach ($data as $key => $value) 
        {
            $widget = new ThemeWidget($this->theme, basename($value['library']));
            
            $widget_config = unserialize($value['widget_config']);
            $widget_config or $widget_config = array();
            
            $widget->setWidgetConfig($widget_config);
            $widget->setRegion($value['region']);
            $widget->setSortOrder($value['sort_order']);
            $widget->setTitle($value['title']);
            $widget->setId($value['id']);
            $widget->setTemplate($value['filename']);

            $widgets[] = $widget;
        }
        
        return $widgets;
    }
    
    public function readRegionWidgets()
    {
        $data = $this->readWidgets();
        
        $widgets = array();
        foreach ($data as $key => $widget)
        {
            $widgets[$widget->getRegion()][$key] = $widget;
        }
        
        return $widgets;
    }


}