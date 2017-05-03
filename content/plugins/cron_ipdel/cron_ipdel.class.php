<?php
  
/**
 * 定期删除
 */
defined('IN_ECJIA') or exit('No permission resources.');

RC_Loader::load_app_class('cron_abstract', 'cron', false);

class cron_ipdel extends cron_abstract
{
    
    /**
     * 计划任务执行方法
     */
    public function run() {
        $limit = !empty($this->config['ipdel_day']) ? $this->config['ipdel_day'] : 7;
        $deltime = RC_Time::gmtime() - $this->config['ipdel_day'] * 3600 * 24;
        RC_DB::table('stats')->where('access_time', '<', $deltime)->delete();
    }
    
	/**
	 * 获取插件代号
	 *  
     * @see \Ecjia\System\Plugin\PluginInterface::getCode()
     */
    public function getCode()
    {
        return $this->loadConfig('cron_code');
    }

	/** 
	 * 加载配置文件
	 * 
     * @see \Ecjia\System\Plugin\PluginInterface::loadConfig()
     */
    public function loadConfig($key = null, $default = null)
    {        
        return $this->loadPluginData(RC_Plugin::plugin_dir_path(__FILE__) . 'config.php', $key, $default);
    }

	/** 
	 * 加载语言包
	 * 
     * @see \Ecjia\System\Plugin\PluginInterface::loadLanguage()
     */
    public function loadLanguage($key = null, $default = null)
    {
        $locale = RC_Config::get('system.locale');
                
        return $this->loadPluginData(RC_Plugin::plugin_dir_path(__FILE__) . '/languages/'.$locale.'/plugin.lang.php', $key, $default);
    }

}

// end