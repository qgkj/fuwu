<?php
  
defined('IN_ECJIA') or exit('No permission resources.');
use Ecjia\System\Plugin\PluginModel;

/**
 * 自动处理
 * @author royalwang
 */
class cron_method extends PluginModel
{

    protected $table = 'crons';
    
    /**
     * 当前插件种类的唯一标识字段名
     */
    public function codeFieldName()
    {
        return 'cron_code';
    }
    
    /**
     * 激活的支付插件列表
     */
    public function getInstalledPlugins()
    {
        return ecjia_config::instance()->get_addon_config('cron_plugins', true, true);
    }
    
    /**
     * 获取数据库中启用的插件列表
     */
    public function getEnableList()
    {        
        $data = $this->where('enable', 1)->order('cron_order', 'asc')->get()->toArray();
        return $data;
    }
    
    /**
     * 获取数据库中插件数据
     */
    public function getPluginDataById($id)
    {
        return $this->where('cron_id', $id)->where('enable', 1)->first();
    }
    
    public function getPluginDataByCode($code)
    {
        return $this->where('cron_code', $code)->where('enable', 1)->first();
    }
    
    public function getPluginDataByName($name)
    {
        return $this->where('cron_name', $name)->where('enable', 1)->first();
    }
    
    /**
     * 获取数据中的Config配置数据，并处理
     */
    public function configData($code)
    {
        $pluginData = $this->getPluginDataByCode($code);

        $config = $this->unserializeConfig($pluginData['cron_config']);

        $config['cron_code'] = $code;
        $config['cron_name'] = $pluginData['cron_name'];
        
        return $config;
    }
	
	/**
	 * 获取计划任务信息
	 * 
	 * @return array
	 */
	public function getCronInfo()
	{
	    $crondb = array();
	    
	    $timestamp = RC_Time::gmtime();
	    
	    $rows = $this->where('enable', 1)->where('nextime', '<', $timestamp)->get()->toArray();
        
	    foreach ($rows as $rt)
	    {
	        $rt['cron'] = array( 
	            'day'  =>$rt['day'],
	            'week' =>$rt['week'],
	            'm'    =>$rt['minute'],
	            'hour' =>$rt['hour']
	        );
	        $rt['cron_config'] = unserialize($rt['cron_config']);
	        $rt['minute']      = trim($rt['minute']);
	        $rt['allow_ip']    = trim($rt['allow_ip']);
	        $crondb[] = $rt;
	    }
	   
	    return $crondb;
	}
}

// end