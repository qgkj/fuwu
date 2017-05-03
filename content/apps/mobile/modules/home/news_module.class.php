<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * news 今日热点
 * @author will.chen
 */
class news_module extends api_front implements api_interface {

	 public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    	$this->authSession();
		
		$db_mobile_news = RC_Model::model('mobile/mobile_news_model');
		/* 查询今日热点总数*/
		$count = $db_mobile_news->where(array('group_id' => 0, 'status' => 1))->count();
		
		/* 查询总数为0时直接返回  */
		if ($count == 0) {
			$pager = array(
					'total' => 0,
					'count' => 0,
					'more'	=> 0,
			);
			return array('data' => array(), 'pager' => $pager);
		}
		
		/* 获取数量 */
		$size = $this->requestData('pagination.count', 10);
		$page = $this->requestData('pagination.page', 1);
		
		//实例化分页
		$page_row = new ecjia_page($count, $size, 6, '', $page);
		
		$result = $db_mobile_news->where(array('group_id' => 0, 'status' => 1))->limit($page_row->limit())->order(array('id' => 'desc'))->select();
		
		$list = array();
		if ( !empty ($result)) {
			foreach ($result as $val) {
				if (substr($val['image'], 0, 4) == 'http' || substr($val['image'],0, 9) == 'ecjiaopen') {
					$image = $val['image'];
				} else {
					$image = empty($val['image']) ? '' : RC_Upload::upload_url(). '/' .$val['image'];
				}
				$list[$val['id']][] = array(
						'id'		  => $val['id'],
						'title'		  => $val['title'],
						'description' => $val['description'],
						'image'		  => $image,
						'content_url' => $val['content_url'],
						'create_time' => RC_Time::local_date(ecjia::config('time_format'), $val['create_time']),
				);
				
				$child_result = $db_mobile_news->where(array('group_id' => $val['id']))->select();
				if ( !empty($child_result)) {
					foreach ($child_result as $v) {
						if (substr($v['image'], 0, 4) == 'http' || substr($v['image'],0, 9) == 'ecjiaopen') {
							$child_image = $v['image'];
						} else {
							$child_image = empty($v['image']) ? '' : RC_Upload::upload_url(). '/' .$v['image'];
						}
						$list[$v['group_id']][] = array(
								'id'		  => $v['id'],
								'title'		  => $v['title'],
								'description' => $v['description'],
								'image'		  => $child_image,
								'content_url' => $v['content_url'],
								'create_time' => RC_Time::local_date(ecjia::config('time_format'), $v['create_time']),
						);
					}
				}
			}
		}
		
		$list = array_merge($list);
		$pager = array(
				"total" => $page_row->total_records,
				"count" => $page_row->total_records,
				"more"	=> $page_row->total_pages <= $page ? 0 : 1,
		);
		
		return array('data' => $list, 'pager' => $pager);
		
	}
}

// end