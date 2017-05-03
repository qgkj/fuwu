<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 自动处理插件
 */
RC_Loader::load_app_class('cron_abstract', 'cron', false);

class cron_auto_manage extends cron_abstract
{
    
    /**
     * 计划任务执行方法
     */
    public function run() {
    	
        $time = RC_Time::gmtime();
        $limit = !empty($this->config['auto_manage_count']) ? $this->config['auto_manage_count'] : 5;
        $autodb = RC_DB::TABLE('auto_manage')
	    ->where(RC_DB::raw('starttime'), '>', 0)
	    ->where(RC_DB::raw('starttime'), '<=', $time)
	    ->orWhere(RC_DB::raw('endtime'), '>', 0)
	    ->where(RC_DB::raw('endtime'), '<=', $time)
        ->get();
        
        foreach ($autodb as $key => $val) {
            $del = $up = false;
            if ($val['type'] == 'goods') {
                $goods = true;
                $where = "goods_id = '$val[item_id]'";
            } else {
                $goods = false;
                $where = "article_id = '$val[item_id]'";
            }
            //上下架判断
            if(!empty($val['starttime']) && !empty($val['endtime'])) {
                //上下架时间均设置
                if($val['starttime'] <= $time && $time < $val['endtime']) {
                    //上架时间 <= 当前时间 < 下架时间
                    $up = true;
                    $del = false;
                } elseif($val['starttime'] >= $time && $time > $val['endtime']) {
                    //下架时间 <= 当前时间 < 上架时间
                    $up = false;
                    $del = false;
                }
                elseif($val['starttime'] == $time && $time == $val['endtime']) {
                    //下架时间 == 当前时间 == 上架时间
                    RC_DB::table('auto_manage')->where('item_id', $val[item_id])->where('type', $val[type])->delete();
                    continue;
                } elseif($val['starttime'] > $val['endtime']) {
                    // 下架时间 < 上架时间 < 当前时间
                    $up = true;
                    $del = true;
                } elseif($val['starttime'] < $val['endtime']) {
                    // 上架时间 < 下架时间 < 当前时间
                    $up = false;
                    $del = true;
                } else {
                    // 上架时间 = 下架时间 < 当前时间
                    RC_DB::table('auto_manage')->where('item_id', $val[item_id])->where('type', $val[type])->delete();
                    continue;
                }
            }
            elseif(!empty($val['starttime'])) {
                //只设置了上架时间
                $up = true;
                $del = true;
            } else {
                //只设置了下架时间
                $up = false;
                $del = true;
            }
        
            if ($goods) {
                if ($up) {
                    RC_DB::table('goods')->whereRaw($where)->update(array('is_on_sale' => 1));
                } else {
                    RC_DB::table('goods')->whereRaw($where)->update(array('is_on_sale' => 0));
                    
                }
            } else {
                if ($up) {
                    RC_DB::table('article')->whereRaw($where)->update(array('is_open' => 1));
                } else {
                    RC_DB::table('article')->whereRaw($where)->update(array('is_open' => 0));
                }
            }
            if ($del) {
                RC_DB::table('auto_manage')->where('item_id', $val[item_id])->where('type', $val[type])->delete();
            } else {
                if($up) {
                    RC_DB::table('auto_manage')->where('item_id', $val[item_id])->where('type', $val[type])->update(array('starttime' => 0));
                } else {
                    RC_DB::table('auto_manage')->where('item_id', $val[item_id])->where('type', $val[type])->update(array('endtime' => 0));
                }
            }
        }
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