<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 前台搜索商品返回商品列表
 * @author will.chen
 */
class goods_goods_list_api extends Component_Event_Api {
    /**
     * @param  $options['keyword'] 关键字
     *         $options['cat_id'] 分类id
     *         $options['brand_id'] 品牌id
     * @return array
     */
	public function call(&$options) {
		
	    $default_display_type = ecjia::config('show_order_type') == '0' ? 'list' : (ecjia::config('show_order_type') == '1' ? 'grid' : 'text');
		$options['display']  = (isset($options['display']) && in_array(trim(strtolower($options['display'])), array('list', 'grid', 'text'))) ? trim($options['display'])  : (isset($_COOKIE['ECS']['display']) ? $_COOKIE['ECS']['display'] : $default_display_type);
		$options['display']  = in_array($options['display'], array('list', 'grid', 'text')) ? $options['display'] : 'text';
		
		RC_Loader::load_app_class('goods_list', 'goods', false);
		if (isset($options['keywords']) && !empty($options['keywords'])) {
			goods_list::get_keywords_where($options['keywords']);
		}
		
	   	$row = goods_list::get_goods_list($options);
	    return $row;
	}
}

// end