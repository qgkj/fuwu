<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 添加管理员记录日志操作对象
 */
function assign_adminlog_content() {
	ecjia_admin_log::instance()->add_action('batch_mark', '批量标记');
	ecjia_admin_log::instance()->add_action('mark', '标记');
	
	ecjia_admin_log::instance()->add_object('notice', '通知');
}

// 截取字符串
function mix_substr($str, $len = 12, $dot = true) {
	$i = 0;
	$l = 0;
	$c = 0;
	$a = array();
	while ($l < $len) {
		$t = substr($str, $i, 1);
		if (ord($t) >= 224) {
			$c = 3;
			$t = substr($str, $i, $c);
			$l += 2;
		} elseif (ord($t) >= 192) {
			$c = 2;
			$t = substr($str, $i, $c);
			$l += 2;
		} else {
			$c = 1;
			$l++;
		}
		// $t = substr($str, $i, $c);
		$i += $c;
		if ($l > $len) break;
		$a[] = $t;
	}
	$re = implode('', $a);
	if (substr($str, $i, 1) !== false) {
		array_pop($a);
		($c == 1) and array_pop($a);
		$re = implode('', $a);
		$dot and $re .= '...';
	}
	return $re;
}

//end