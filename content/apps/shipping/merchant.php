<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 配送方式管理程序
 */
class merchant extends ecjia_merchant {
	private $db_shipping;

	public function __construct() {
		parent::__construct();

		RC_Loader::load_app_func('global');
		assign_adminlog_content();

		$this->db_shipping 	= RC_Model::model('shipping/shipping_model');
		
		/* 加载全局 js/css */
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		
		RC_Script::enqueue_script('merchant_shipping', RC_App::apps_url('statics/js/merchant_shipping.js', __FILE__));
		RC_Style::enqueue_style('merchant_shipping', RC_App::apps_url('statics/css/merchant_shipping.css', __FILE__), array(), false, false);
		RC_Script::enqueue_script('ecjia.utils');
		RC_Script::enqueue_script('ecjia.common');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Loader::load_app_class('shipping_factory', null, false);
		
      	//时间控件
        RC_Script::enqueue_script('bootstrap-datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.js'));
		RC_Style::enqueue_style('datetimepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datetimepicker.min.css'));
		
		
		RC_Script::localize_script('merchant_shipping', 'js_lang', RC_Lang::get('shipping::shipping.js_lang'));
		RC_Script::localize_script('shopping_admin', 'js_lang', RC_Lang::get('shipping::shipping.js_lang'));
		
		ecjia_merchant_screen::get_current_screen()->set_parentage('shipping', 'shipping/merchant.php');
		ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here('配送管理', RC_Uri::url('shipping/merchant/init')));
	}

	/**
	 * 配送方式列表  get
	 */
	public function init() { 
		$this->admin_priv('ship_merchant_manage');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here('我的配送'));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('shipping::shipping.overview'),
			'content'	=> '<p>' . RC_Lang::get('shipping::shipping.shipping_list_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('shipping::shipping.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:配送方式" target="_blank">'. RC_Lang::get('shipping::shipping.about_shipping_list') .'</a>') . '</p>'
		);
		$this->assign('ur_here', '我的配送');
		
		//已启用的配送方式
		$enabled_data = RC_DB::table('shipping as s')
			->leftJoin('shipping_area as a', function($join) {
				$join->on(RC_DB::raw('s.shipping_id'), '=', RC_DB::raw('a.shipping_id'))
					->where(RC_DB::raw('a.store_id'), '=', $_SESSION['store_id']);
			})
			->groupBy(RC_DB::raw('s.shipping_id'))
			->orderBy(RC_DB::raw('s.shipping_order'))
			->selectRaw('s.*, a.shipping_area_id')
			->where(RC_DB::raw('s.enabled'), 1)
			->whereNotNull(RC_DB::raw('a.shipping_area_id'))
			->get();
		
		//未启用的配送方式
		$disabled_data = RC_DB::table('shipping as s')
			->leftJoin('shipping_area as a', function($join) {
				$join->on(RC_DB::raw('s.shipping_id'), '=', RC_DB::raw('a.shipping_id'))
					->where(RC_DB::raw('a.store_id'), '=', $_SESSION['store_id']);
			})
			->groupBy(RC_DB::raw('s.shipping_id'))
			->orderBy(RC_DB::raw('s.shipping_order'))
			->selectRaw('s.*, a.shipping_area_id')
			->where(RC_DB::raw('s.enabled'), 1)
			->whereNull(RC_DB::raw('a.shipping_area_id'))
			->get();
		
		$plugins = ecjia_config::instance()->get_addon_config('shipping_plugins', true);
		
		/* 插件已经安装了，获得名称以及描述 */
		$enabled_modules = $disabled_modules = array();
		
		//已启用
		foreach ($enabled_data as $_key => $_value) {
			if (isset($plugins[$_value['shipping_code']])) {
				$enabled_modules[$_key]['id']      			= $_value['shipping_id'];
				$enabled_modules[$_key]['code']      		= $_value['shipping_code'];
				$enabled_modules[$_key]['name']    			= $_value['shipping_name'];
				$enabled_modules[$_key]['desc']    			= $_value['shipping_desc'];
				$enabled_modules[$_key]['cod']     			= $_value['support_cod'];
				$enabled_modules[$_key]['shipping_order'] 	= $_value['shipping_order'];
				$enabled_modules[$_key]['insure_fee']  		= $_value['insure'];
				$enabled_modules[$_key]['enabled'] 			= $_value['enabled'];
				 
				/* 判断该派送方式是否支持保价 支持报价的允许在页面修改保价费 */
				$shipping_handle = new shipping_factory($_value['shipping_code']);
				$config          = $shipping_handle->configure_config();
		
				/* 只能根据配置判断是否支持保价  只有配置项明确说明不支持保价，才是不支持*/
				if (isset($config['insure']) && ($config['insure'] === false)) {
					$enabled_modules[$_key]['is_insure'] = false;
				} else {
					$enabled_modules[$_key]['is_insure'] = true;
				}
			}
		}
		$this->assign('enabled', $enabled_modules);
		
		//未启用
		foreach ($disabled_data as $_key => $_value) {
			if (isset($plugins[$_value['shipping_code']])) {
				$disabled_modules[$_key]['id']      			= $_value['shipping_id'];
				$disabled_modules[$_key]['code']      		= $_value['shipping_code'];
				$disabled_modules[$_key]['name']    			= $_value['shipping_name'];
				$disabled_modules[$_key]['desc']    			= $_value['shipping_desc'];
				$disabled_modules[$_key]['cod']     			= $_value['support_cod'];
				$disabled_modules[$_key]['shipping_order'] 	= $_value['shipping_order'];
				$disabled_modules[$_key]['insure_fee']  		= $_value['insure'];
				$disabled_modules[$_key]['enabled'] 			= $_value['enabled'];
					
				/* 判断该派送方式是否支持保价 支持报价的允许在页面修改保价费 */
				$shipping_handle = new shipping_factory($_value['shipping_code']);
				$config          = $shipping_handle->configure_config();
		
				/* 只能根据配置判断是否支持保价  只有配置项明确说明不支持保价，才是不支持*/
				if (isset($config['insure']) && ($config['insure'] === false)) {
					$disabled_modules[$_key]['is_insure'] = false;
				} else {
					$disabled_modules[$_key]['is_insure'] = true;
				}
			}
		}
		$this->assign('disabled', $disabled_modules);
		
		$this->display('shipping_list.dwt');
	}
}	

// end