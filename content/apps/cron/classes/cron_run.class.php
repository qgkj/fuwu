<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class cron_run {
    private $cron_method;
    private $error;
    private $timestamp;
    private $db;
    
    public function __construct() {
        $this->cron_method = RC_Package::package('app::cron')->loadClass('cron_method');
        $this->error = new ecjia_error();
        $this->timestamp = RC_Time::gmtime();
        $this->db = RC_Package::package('app::cron')->loadModel('crons_model');
        RC_Package::package('app::cron')->loadClass('cron_nexttime', false);
        RC_Package::package('app::cron')->loadClass('cron_helper', false);
    }
    
    /**
     * 运行计划任务
     */
    public function run() {
        $this->check_method();
        
        $crondb = $this->cron_method->getCronInfo(); // 获得需要执行的计划任务数据
        
        foreach ($crondb AS $key => $cron_val) {
            if (!$this->check_allow_ip($cron_val)) {
                continue;
            }
             
            if (!$this->check_allow_files($cron_val)) {
                continue;
            }
            
            if (!$this->check_allow_hour($cron_val)) {
                continue;
            }
             
            if (!$this->check_allow_minute($cron_val)) {
                continue;
            }
            
            $handler = $this->cron_method->pluginInstance($cron_val['cron_code'], $cron_val['cron_config']);
            if (!$handler) {
                $this->error->add('code_not_found', $cron_val['cron_code'] . ' plugin not found!');
                continue;
            }
             
            $error = $handler->run();
            if (is_ecjia_error($error)) {
                $this->error->add($error->get_error_code(), $error->get_error_message());
            }
           
            $this->save_run_time($cron_val);
        }
        
        $this->write_error_log();
    }
    
    
    
    /**
     * 记录运行时间
     * @param array $param
     */
    protected function save_run_time($param) {
        $close = $param['run_once'] ? 0 : 1;
       
        $next_time = cron_nexttime::make($param['cron'])->getNextTime();
        
        $data = array(
        	'thistime' => $this->timestamp,
            'nextime' => $next_time,
            'enable' => $close,
        );
        
        $where = array(
        	'cron_id' => $param['cron_id'],
        );
        
        $this->db->where($where)->update($data);
    }
    
    /**
     * 保存错误日志
     */
    protected function write_error_log() {
        $error = $this->error->get_error_messages();
        if ( ! empty($error)) {
            RC_Logger::getLogger('cron')->error($error);
        }
    }
   
    /**
     * 检查设置了允许ip
     * @param unknown $param
     */
    protected function check_allow_ip($param) {
    	if (!$param['allow_ip']) {
    		return true;
    	}
    	
        $allow_ip = explode(',', $param['allow_ip']);
        $server_ip = RC_Ip::server_ip();
        if (!in_array($server_ip, $allow_ip)) {
            return false;
        }
        
        return true;
    }
    
    /**
     * 检查设置允许调用文件
     * @param unknown $param
     */
    protected function check_allow_files($param) {
        $f_info = parse_url($_SERVER['HTTP_REFERER']);
        
        $f_get = array();
        parse_str($f_info['query'], $f_get);
        
        if (isset($f_get['m'])) {
            $f_m = $f_get['m'];
        } else {
            $f_m = RC_Config::get('route.default.m');
        }
        
        if ($f_m == RC_Config::get('system.admin_entrance')) {
            $f_m = 'system';
        }
        
        $f = explode(',', $param['alow_files']);
        if (!in_array($f_m, $f)) {
            return false;
        }
        
        return true;
    }
    
    /**
     * 检查设置了允许小时段
     * @param unknown $param
     */
    protected function check_allow_hour($param) {
        $hour = $param['hour'];
        $hour_now = intval(RC_Time::local_date('G', $this->timestamp));
        if ($hour_now != $hour) {
            return false;
        }
    
        return true;
    }
    
    /**
     * 检查设置了允许分钟段
     * @param unknown $param
     */
    protected function check_allow_minute($param) {
        $m = explode(',', $param['minute']);
        $m_now = intval(RC_Time::local_date('i', $this->timestamp));
        if (!in_array($m_now, $m)) {
            return false;
        }
        
        return true;
    }
    
    /**
     * 检查计划任务运行的模式，是Web请求，还是CLI命令模式
     */
    protected function check_method() {
        $if_cron = PHP_SAPI == 'cli' ? true : false;
        
        if (ecjia::config('cron_method', ecjia::CONFIG_EXISTS)) {
            if (!$if_cron)
            {
                die('Hacking attempt');
            }
        } else {
            if ($if_cron) {
                die('Hacking attempt');
            } elseif (!isset($_GET['t']) || $this->timestamp - intval($_GET['t']) > 60 || empty($_SERVER['HTTP_REFERER'])) {
                exit('-1');
            }
        }
    }
}

// end