<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 计划任务信息
 * @author wutifang
 */
class cron_cron_info_api extends Component_Event_Api {
	
    /**
     * @param  array $options	条件参数
     * @return array
     */
	public function call(&$options) {
		$db = RC_Loader::load_app_model('crons_model', 'cron');
		
		return $db->find($options);
	}
}

// end