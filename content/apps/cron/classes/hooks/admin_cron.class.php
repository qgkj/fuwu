<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class admin_cron_hooks {
    
    public static function cron_run() {

        /* 加入触发cron代码 */
        if (!ecjia::config('cron_method', ecjia::CONFIG_EXISTS)) {
            $timestamp = RC_Time::gmtime();
            $cron_api_url = RC_Uri::url('cron/api/init', array('t' => $timestamp));
            
            echo PHP_EOL;
            echo "\t\t\t".'<div id="cron" class="hidden"><img src="' . $cron_api_url . '" style="width:0px;height:0px;" /></div>';
        }
    }
}

RC_Hook::add_action( 'admin_print_main_bottom', array('admin_cron_hooks', 'cron_run'), 90);

// end