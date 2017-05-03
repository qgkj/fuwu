<?php
  
namespace Ecjia\System\Theme;

use RC_File;

class ThemeLibrary {
    
    
    protected $file;
    
    protected $filePath;
    
    protected $fileInfo;
    
    /**
     * 主题对象
     * @var \Ecjia\System\Theme\Theme;
     */
    protected $theme;
    
    public function __construct(Theme $theme, $file)
    {
        if (substr($file, -4) != '.php')
        {
            $file .= '.php';
        }
        
        $this->theme = $theme;
        $this->file = $file;
        $this->filePath = $this->theme->getLibraryDir() . $file;
        $this->fileInfo = $this->loadFileinfo();
    }
    
    protected function loadFileinfo()
    {
        $default_headers = array(
	        'Name' => 'Name',
	        'Description' => 'Description',
	    );

        $data = RC_File::get_file_data( $this->filePath, $default_headers, 'library' );
        
        $data['File'] = $this->file;
        
        return $data;
    }
    
    public function getFileinfo()
    {
        return $this->fileInfo;
    }
    
    public function getFilePath()
    {
        return $this->filePath;
    }
    
    /**
     * 载入库项目内容
     *
     * @return  array
     */
    public function loadLibrary()
    {
        $this->filePath = str_replace("0xa", '', $this->filePath); // 过滤 0xa 非法字符
        
        $arr['mark'] = RC_File::file_mode_info($this->filePath);
        
        if (is_file($this->filePath)) {
            $arr['html'] = str_replace("\xEF\xBB\xBF", '', file_get_contents($this->filePath));
        } else {
            $arr['html'] = null;
        }

        return $arr;
    }
    
    /**
     * 更新库项目内容
     */
    public function updateLibrary($content)
    {
        $this->filePath = str_replace("0xa", '', $this->filePath); // 过滤 0xa 非法字符
        $this->filePath = str_replace("\\", '/', $this->filePath); //windows兼容处理
        if (!royalcms('files')->isWritable($this->filePath)) {
            return false;
        }
        
        $org_html = str_replace("\xEF\xBB\xBF", '', file_get_contents($this->filePath));
        
        if (file_exists($this->filePath) === true && file_put_contents($this->filePath, $content)) {
            file_put_contents($this->theme->getLibraryBakDir() . $this->theme->getThemeCode() . '-' . $this->file, $org_html);
            return true;
        } else {
            return false;
        }
        
    }
    
    /**
     * 还原库项目
     */
    public function restoreLibrary()
    {
        $this->filePath   = str_replace("0xa", '', $this->filePath); // 过滤 0xa 非法字符
        $this->filePath   = str_replace("\\", '/', $this->filePath); //windows兼容处理
        
        $lib_backup = $this->theme->getLibraryBakDir() . $this->theme->getThemeCode() . '-' . $this->file;
        $lib_backup = str_replace("0xa", '', $lib_backup); // 过滤 0xa 非法字符
        $lib_backup = str_replace("\\", '/', $lib_backup); //windows兼容处理
        
        if (file_exists($lib_backup) && filemtime($lib_backup) >= filemtime($this->filePath)) {
            return str_replace("\xEF\xBB\xBF", '', file_get_contents($lib_backup));
        } else {
            return str_replace("\xEF\xBB\xBF", '', file_get_contents($this->filePath));
        }
    }
    
    
}