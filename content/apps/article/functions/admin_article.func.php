<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获得指定的文章的详细信息
 * @access  private
 * @param   integer     $article_id
 * @return  array
 */
function get_article_info($article_id) {
	$db = RC_Model::model('article/article_viewmodel');
	$db->view = array(
		'comment'  => array(
		'type'     => Component_Model_View::TYPE_LEFT_JOIN,
		'alias'    => 'r',
		'field'    => 'a.*, IFNULL(AVG(r.comment_rank), 0) AS comment_rank',
		'on'       => 'r.id_value = a.article_id AND comment_type = 1',
		),
	);
	$row = $db->group('a.article_id')->find(array('a.is_open' => 1, 'a.article_id' => $article_id));
	if ($row !== false) {
		/* 用户评论级别取整  */
		$row['comment_rank'] = ceil($row['comment_rank']);
		/* 修正添加时间显示  */
		$row['add_time'] = RC_Time::local_date(ecjia::config('date_format'), $row['add_time']);

		/* 作者信息如果为空，则用网站名称替换 */
		if (empty($row['author']) || $row['author'] == '_SHOPHELP') {
			$row['author'] = ecjia::config('shop_name');
		}
	}
	return $row;
}

// end