<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 添加审核日志
 * @author
 */
class store_add_check_log_api extends Component_Event_Api {
	/**
	 *
	 * @param array $options
	 * @return  array
	 */
	public function call (&$options) {
		if (!is_array($options) ) {
			return new ecjia_error('invalid_parameter', RC_Lang::get('system::system.invalid_parameter'));
		}
		$options['time'] = RC_Time::gmtime();
		
		return RC_DB::table('store_check_log')->insert($options);
	}

}

// end
