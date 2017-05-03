<?php
  
use Royalcms\Component\Database\Eloquent\Model;
use Royalcms\Component\Uuid\Uuid;

defined('IN_ECJIA') or exit('No permission resources.');

class template_widget_model extends Model {
	
    protected $table = 'template_widget';
    
    public function getBackupRemarks($theme) 
    {
        
        $data = $this->select(RC_DB::raw('DISTINCT(remarks)'))
                        ->where('theme', $theme)
                        ->where('remarks', '>', '')
                        ->get()->toArray();
        return $data;
    }
    
    
    public function getTemplateFiles($theme) 
    {
        $data = $this->select(RC_DB::raw('DISTINCT(filename)'))
                        ->where('theme', $theme)
                        ->where('remarks', '')
                        ->lists('filename');
        return $data;
    }
    
    /**
     * 判断是否已经存在相同的备份
     * @param string $theme
     * @param string $remarks
     * @return boolean
     */
    public function hasTemplateSettingBackup($theme, $remarks)
    {
        $count = $this->where('theme', $theme)->where('remarks', $remarks)->count();
        if ($count > 0) {
            return true;
        }
        return false; 
    }
    
    /**
     * 备份指定的模板和文件的数据
     * @param string $theme
     * @param array $files
     */
    public function backupTemplateFiles($theme, array $files, $remarks) 
    {
        $data = $this->where('theme', $theme)->where('remarks', '')
                        ->whereIn('filename', $files)
                        ->get()->toArray();
        
        foreach ($data as $row) {
            
            $row['id'] = Uuid::generate();
            $row['remarks'] = $remarks;
            
            $this->insert($row);
        }
        
        return true;
    }
    
    
    public function restoreTemplateFiles($theme, $remarks)
    {
        
        $rows = $this->select(RC_DB::raw('DISTINCT(filename)'))
                        ->where('theme', $theme)
                        ->where('remarks', $remarks)
                        ->orderBy('filename', 'asc')
                        ->orderBy('region', 'asc')
                        ->orderBy('sort_order', 'asc')
                        ->lists('filename');
        
        if (!empty($rows)) 
        {
            $this->where('theme', $theme)->where('remarks', '')
                        ->whereIn('filename', $rows)
                        ->delete();
            
            $datas = $this->where('theme', $theme)
                            ->where('remarks', $remarks)
                            ->get()->toArray();
            foreach ($datas as $data)
            {
                $data['id'] = Uuid::generate();
                unset($data['remarks']);
                
                $this->insert($data);
            }
            
            return true;
        }
        else 
        {
            return new ecjia_error('not_found_remarks', __('没有找到该注释的模板备份'));
        }
    }

}

// end