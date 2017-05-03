<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class cron_helper {
    
    public static function assign_adminlog_content() {
        ecjia_admin_log::instance()->add_action('enable', RC_Lang::get('cron::cron.enable'));
        ecjia_admin_log::instance()->add_action('disable', RC_Lang::get('cron::cron.disable'));
        ecjia_admin_log::instance()->add_action('run', RC_Lang::get('cron::cron.cron_do'));
        ecjia_admin_log::instance()->add_object('cron', RC_Lang::get('cron::cron.cron'));
    }
    
    public static function get_minute($cron_minute) {
        $cron_minute = explode(',', $cron_minute);
        $cron_minute = array_unique($cron_minute);
        foreach ($cron_minute as $key => $val) {
            if ($val) {
                $val = intval($val);
                $val < 0 && $val = 0;
                $val > 59 && $val = 59;
                $cron_minute[$key] = $val;
            }
        }
        return trim(implode(',', $cron_minute));
    }
    
    
    public static function get_dwh() {
        $days = $week = $hours = array();
        for ($i = 1 ; $i<=31 ; $i++) {
            $days[$i] = $i.RC_Lang::get('cron::cron.cron_day');
        }
    
        for ($i = 1 ; $i<8 ; $i++) {
            $week[$i] = RC_Lang::get('cron::cron.week.'.$i);
        }
    
        for ($i = 0 ; $i<24 ; $i++) {
            $hours[$i] = $i.RC_Lang::get('cron::cron.cron_hour');
        }
        return array($days,$week,$hours);
    }
    
}

// end