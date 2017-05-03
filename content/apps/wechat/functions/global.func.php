<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

function assign_adminlog_content() {
	ecjia_admin_log::instance()->add_object('wechat', RC_Lang::get('wechat::wechat.wechat'));
	ecjia_admin_log::instance()->add_object('menu', RC_Lang::get('wechat::wechat.weixin_menu'));
	ecjia_admin_log::instance()->add_object('template', RC_Lang::get('wechat::wechat.message_template'));
	ecjia_admin_log::instance()->add_object('qrcode', RC_Lang::get('wechat::wechat.channel_code'));
	ecjia_admin_log::instance()->add_object('share', RC_Lang::get('wechat::wechat.sweep_recommend'));
	ecjia_admin_log::instance()->add_object('customer', RC_Lang::get('wechat::wechat.service'));
	
	ecjia_admin_log::instance()->add_object('article_material', RC_Lang::get('wechat::wechat.map_material'));
	ecjia_admin_log::instance()->add_object('articles_material', RC_Lang::get('wechat::wechat.maps_material'));
	
	ecjia_admin_log::instance()->add_object('picture_material', RC_Lang::get('wechat::wechat.picture_material'));
	ecjia_admin_log::instance()->add_object('voice_material', RC_Lang::get('wechat::wechat.voice_material'));
	ecjia_admin_log::instance()->add_object('video_material', RC_Lang::get('wechat::wechat.video_material'));
	
	ecjia_admin_log::instance()->add_object('reply_subscribe', RC_Lang::get('wechat::wechat.attention_auto_reply'));
	ecjia_admin_log::instance()->add_object('reply_msg', RC_Lang::get('wechat::wechat.message_auto_reply'));
	ecjia_admin_log::instance()->add_object('reply_keywords_rule', RC_Lang::get('wechat::wechat.keyword_auto_reply'));
	
	ecjia_admin_log::instance()->add_action('batch_move', RC_Lang::get('wechat::wechat.batch_move'));
	ecjia_admin_log::instance()->add_action('send', RC_Lang::get('wechat::wechat.send_msg'));
	
	ecjia_admin_log::instance()->add_object('users_tag', RC_Lang::get('wechat::wechat.user_tag'));
	ecjia_admin_log::instance()->add_object('users_info', RC_Lang::get('wechat::wechat.user_info'));
	ecjia_admin_log::instance()->add_object('subscribe_message', RC_Lang::get('wechat::wechat.user_message'));
	
	ecjia_admin_log::instance()->add_object('config', RC_Lang::get('wechat::wechat.config'));
}

/**
 * 创建像这样的查询: "IN('a','b')";
 */
function db_create_in($item_list, $field_name = '') {
	if (empty ( $item_list )) {
		return $field_name . " IN ('') ";
	} else {
		if (! is_array ( $item_list )) {
			$item_list = explode ( ',', $item_list );
		}
		$item_list = array_unique ( $item_list );
		$item_list_tmp = '';
		foreach ( $item_list as $item ) {
			if ($item !== '') {
				$item_list_tmp .= $item_list_tmp ? ",'$item'" : "'$item'";
			}
		}
		if (empty ( $item_list_tmp )) {
			return $field_name . " IN ('') ";
		} else {
			return $field_name . ' IN (' . $item_list_tmp . ') ';
		}
	}
}


/**
 * 截取字符串，字节格式化
 * @param unknown $str
 * @param unknown $length
 * @param number $start
 * @param string $charset
 * @param string $suffix
 * @return string
 */
function msubstr($str, $length, $start = 0, $charset = "utf-8", $suffix = true) {
	if (function_exists("mb_substr")) {
		$slice = mb_substr($str, $start, $length, $charset);
	} elseif (function_exists('iconv_substr')) {
		$slice = iconv_substr($str, $start, $length, $charset);
	} else {
		$re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
		$re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
		$re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
		$re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
		preg_match_all($re[$charset], $str, $match);
		$slice = join("", array_slice($match[0], $start, $length));
	}
	return $suffix ? $slice . '...' : $slice;
}

/**
 * html代码输出
 * @param unknown $str
 * @return string
 */
function html_out($str) {
	if (function_exists('htmlspecialchars_decode')) {
		$str = htmlspecialchars_decode($str);
	} else {
		$str = html_entity_decode($str);
	}
	$str = stripslashes($str);
	return $str;
}

//end