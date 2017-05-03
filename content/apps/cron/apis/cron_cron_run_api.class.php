<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 计划任务信息
 * @author wutifang
 */
class cron_cron_run_api extends Component_Event_Api {
    /**
     * @param  array $options	条件参数
     * @return array
     */
	public function call( & $options) {	    

	    $timestamp = RC_Time::gmtime();
	    $cron_api_url = RC_Uri::url('cron/api/init', array('t' => $timestamp));

	    $args = array(
	        'headers' => array(
	           'Referer' => RC_Uri::url(ROUTE_M.'/'.ROUTE_C.'/'.ROUTE_A, $_GET)
	        ),
	    );
	    RC_Http::remote_get($cron_api_url, $args);
	    
	    return true;
	}
}

// end