<?php
  
/**
 * 自动处理插件
 * 关闭未付款订单
 */
defined('IN_ECJIA') or exit('No permission resources.');

RC_Loader::load_app_class('cron_abstract', 'cron', false);

class cron_unpayed extends cron_abstract
{
    
    /**
     * 计划任务执行方法
     */
    public function run() {
        $limit_time = !empty($this->config['unpayed_hours']) ? $this->config['unpayed_hours'] : 24;
        $limit_time = $limit_time * 3600;
        RC_Loader::load_app_class('order_operate', 'orders', false);
        $order_operate = new order_operate();
        $time = RC_Time::gmtime();
        
        //条件：下单时间+时间周期  <= 当前时间，未付款
        $rows = RC_DB::TABLE('order_info')
        //         ->where('add_time', '>', $time - 31 * 86400)
        ->whereNotIn('order_status', array(OS_CANCELED,OS_INVALID))
        ->where('pay_status', PS_UNPAYED)
        ->where(RC_DB::raw('add_time + '.$limit_time), '<=', $time)
        ->get();
        
        foreach ($rows as $order) {
            $order_operate->operate($order, 'cancel', array('action_note' => '超时自动关闭'));
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