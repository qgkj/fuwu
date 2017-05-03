<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获取站点根目录网址
 *
 * @access  private
 * @return  Bool
 */
function get_site_root_url() {
	return 'http://' . $_SERVER['HTTP_HOST'] . str_replace('/' . '/shipping.php', '', PHP_SELF);

}

/**
 * 判断是否为默认安装快递单背景图片
 *
 * @param   string      $print_bg      快递单背景图片路径名
 * @access  private
 *
 * @return  Bool
 */
function is_print_bg_default($print_bg) {
	$_bg = basename($print_bg);
	$_bg_array = explode('.', $_bg);

	if (count($_bg_array) != 2) {
		return false;
	}
	if (strpos('|' . $_bg_array[0], 'dly_') != 1) {
		return false;
	}
	$_bg_array[0] = ltrim($_bg_array[0], 'dly_');
	$list = explode('|', SHIP_LIST);

	if (in_array($_bg_array[0], $list)) {
		return true;
	}

	return false;
}

/**
 * 取得配送区域列表
 * @param   int     $shipping_id    配送id
 */
// function get_shipping_area_list($shipping_id) {
// 	$db = RC_Model::model('shipping/shipping_area_model');
// 	$db_view = RC_Model::model('shipping/shipping_area_region_viewmodel');
	
// 	if ($shipping_id > 0) {
// 		$data = $db->where(array('shipping_id' => $shipping_id))->select();
// 	}
// 	else {
// 		$data = $db->select();	
// 	}
// 	$list = array();
// 	if (!empty($data)) {
// 		foreach ($data as $row) {
// 			$query = $db_view->join('region')->field('r.region_name')->where(array('a.shipping_area_id' => $row['shipping_area_id']))->select();
			
// 			$regions = $query[0]['region_name']; 
// 			$row['shipping_area_regions'] = empty($regions) ? '<a href="shipping_area.php?act=region&amp;id=' .$row['shipping_area_id']. '" style="color:red">' .RC_Lang::get('shipping::shipping.empty_regions'). '</a>' : $regions;
// 			$list[] = $row;
// 		}
// 	}
// 	return $list;
// }

function assign_adminlog_content() {
	ecjia_admin_log::instance()->add_object('shipping_print_template', RC_Lang::get('shipping::shipping.shipping_print_template'));
}

// end