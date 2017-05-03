<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 计划任务安装API
 * @author royalwang
 */
class cron_plugin_install_api extends Component_Event_Api {
	
	public function call(&$options) {

		if (isset($options['file'])) {
			$plugin_file = $options['file'];
			$plugin_data = RC_Plugin::get_plugin_data($plugin_file);
			 
			$plugin_file = RC_Plugin::plugin_basename($plugin_file);
			$plugin_dir = dirname($plugin_file);
			 
			$plugins = ecjia_config::instance()->get_addon_config('cron_plugins', true);
			$plugins[$plugin_dir] = $plugin_file;
			 
			ecjia_config::instance()->set_addon_config('cron_plugins', $plugins, true);
		}
		
		if (isset($options['config']) && !empty($plugin_data['Name'])) {
			$format_name = $plugin_data['Name'];
			$format_description = $plugin_data['Description'];
			 
			/* 检查输入 */
			if (empty($format_name) || empty($options['config']['cron_code'])) {
				return ecjia_plugin::add_error('plugin_install_error', RC_Lang::get('cron::cron.plugin_name_empty'));
			}
			 
			$db = RC_Loader::load_app_model('crons_model', 'cron');
		
			/* 检测名称重复 */
			$data = $db->where("`cron_name` = '" . $format_name . "' and `cron_code` = '" . $options['config']['cron_code'] . "'")->count();
			if ($data > 0) {
				return ecjia_plugin::add_error('plugin_install_error', RC_Lang::get('cron::cron.plugin_exist'));
			}
			
			/* 取得配置信息 */
			$cron_config = serialize($options['config']['forms']);
			$cron_config_file = $options['config'];
		
			//组织默认数据，将该计划任务的信息添加到数据库
			RC_Loader::load_app_func('global', 'cron');
			assign_adminlog_content();
			//判断默认时间配置
			if (array_get($cron_config_file, 'lock_time', false)) {
			    /*执行分钟，可多个*/
			    $cron_minute = array_get($cron_config_file['default_time'], 'minute', '');
			    	
			    /* 默认每日 当天00小时执行 */
			    $cron_day  = array_get($cron_config_file['default_time'], 'day', '');
			    $cron_week = array_get($cron_config_file['default_time'], 'week', '');
			    $cron_hour = array_get($cron_config_file['default_time'], 'hour', 0);
			} else {
			    /*执行分钟，可多个*/
			    RC_Package::package('app::cron')->loadClass('cron_helper');
			    $cron_minute = cron_helper::get_minute('');
			    	
			    /* 默认每日 当天00小时执行 */
			    $cron_day  = '';
			    $cron_week = '';
			    $cron_hour = 0;
			}
			
			/* 执行后关闭 */
			$cron_run_once = 0;
			
			$cron = array(
			    'day'	=> $cron_day,
			    'week'	=> $cron_week,
			    'm'		=> $cron_minute,
			    'hour'	=> $cron_hour
			);
			
			/* 下一次执行时间 */
			RC_Package::package('app::cron')->loadClass('cron_nexttime', false);
// 			$next = cron_helper::get_next_time($cron);
			$next = cron_nexttime::make($cron)->getNextTime();
			
			$alow_files  = array();
			$alow_files  = !empty($alow_files) ? implode(' ', $alow_files) : '';
			$allow_ip    = '';
		
			/* 安装，检查该支付方式是否曾经安装过 */
			$count = $db->where("`cron_code` = '" . $options['config']['cron_code'] . "'")->count();
		
			if ($count > 0) {
				/* 该支付方式已经安装过, 将该支付方式的状态设置为 enable */
				$data = array(
					'cron_name' 	=> $format_name,
					'cron_desc'     => $format_description,
					'cron_config' 	=> $cron_config,
				    'nextime' 		=> $next,
				    'day' 			=> $cron_day,
				    'week' 			=> $cron_week,
				    'hour' 			=> $cron_hour,
				    'minute' 		=> $cron_minute,
				    'run_once' 		=> $cron_run_once,
				    'allow_ip' 		=> $allow_ip,
				    'alow_files' 	=> $alow_files,
					'enabled' 		=> 1
				);
		
				$db->where("`cron_code` = '" . $options['config']['cron_code'] . "'")->update($data);
		
			} else {
				/* 该支付方式没有安装过, 将该支付方式的信息添加到数据库 */
				$data = array(
					'cron_code' 		=> $options['config']['cron_code'],
					'cron_name' 		=> $format_name,
					'cron_desc' 		=> $format_description,
					'cron_config' 		=> $cron_config,
				    'nextime' 		    => $next,
				    'day' 			    => $cron_day,
				    'week' 			    => $cron_week,
				    'hour' 			    => $cron_hour,
				    'minute' 		    => $cron_minute,
				    'run_once' 		    => $cron_run_once,
				    'allow_ip' 		    => $allow_ip,
				    'alow_files' 	    => $alow_files,
					'enabled' 		    => 1,
				);
				$db->insert($data);
			}
			 
			/* 记录日志 */
			ecjia_admin::admin_log($format_name, 'install', 'cron');
			return true;
		}
	}
}

// end