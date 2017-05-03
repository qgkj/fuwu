<?php
  
/**
 * 自动确认收货
 */
defined('IN_ECJIA') or exit('No permission resources.');

RC_Loader::load_app_class('cron_abstract', 'cron', false);

class cron_order_receive extends cron_abstract
{
    
    /**
     * 计划任务执行方法
     */
    public function run() {
        $limit_time = !empty($this->config['order_receive_day']) ? $this->config['order_receive_day'] : 15;
        $limit_time = $limit_time * 86400;
        RC_Loader::load_app_class('order_operate', 'orders', false);
        $order_operate = new order_operate();
        $time = RC_Time::gmtime();
        
        //条件，发货时间+时间周期 < 当前时间，已发货，未收货，
        $rows = RC_DB::TABLE('order_info')
        ->where(RC_DB::raw('shipping_time'), '>', 0)
//         ->where(RC_DB::raw('shipping_time'), '>', $time - 31 * 86400)
        ->where(RC_DB::raw('shipping_status'), SS_SHIPPED)
        ->where(RC_DB::raw('shipping_time + '.$limit_time), '<=', $time)
        ->get();
        
        foreach ($rows as $order) {
            $order_operate->operate($order, 'receive', array('action_note' => '自动确认收货'));
        }
        unset($rows);
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