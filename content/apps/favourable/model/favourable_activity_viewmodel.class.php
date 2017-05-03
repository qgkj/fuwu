<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class favourable_activity_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name       = 'favourable_activity';
		$this->table_alias_name = 'fa';
		
		$this->view = array(
			'store_franchisee' => array(
				'type' 	       => Component_Model_View::TYPE_LEFT_JOIN,
				'alias'        => 'ssi',
				'on' 	       => "ssi.store_id = fa.store_id"
			)
		);
		parent::__construct();
	}
	
	/*
	 * 取得优惠活动列表
	* @param   array()     $filter     查询条件
	* @return   array
	*/
	public function favourable_list($filter = array()) 
	{	
		/* 过滤条件 */
		$where = array();
		if (!empty($filter['keyword'])) {
			$where['act_name'] = array('like'=>"%" . mysql_like_quote($filter['keyword']) . "%");
		}
		$now = RC_Time::gmtime();
		if (isset($filter['is_going']) && $filter['is_going'] == 1) {
			$where['start_time'] = array('elt' => $now);
			$where['end_time']   = array('egt' => $now);
		}
		/* 正在进行中*/
		if (isset($filter['status']) && $filter['status'] == 'going') {
			$where['start_time'] = array('elt' => $now);
			$where['end_time']   = array('egt' => $now);
		}
		/* 即将开始*/
		if (isset($filter['status']) && $filter['status'] == 'coming') {
			$where['start_time'] = array('egt' => $now);
		}
		/* 已结束*/
		if (isset($filter['status']) && $filter['status'] == 'finished') {
			$where['end_time'] = array('elt' => $now);
		}
		
		/* 卖家*/
		if (isset($filter['store_id'])) {
		    $where['fa.store_id'] = $filter['store_id'];
		}
		
		/* 排序*/
		$filter['sort_by']    = empty($filter['sort_by']) ? 'act_id' : trim($filter['sort_by']);
		$filter['sort_order'] = empty($filter['sort_order']) ? 'DESC' : trim($filter['sort_order']);
		
		$join = null;
		
		$count = $this->where($where)->join(null)->count();
		//实例化分页
		$page_row = new ecjia_page($count, $filter['size'], 6, '', $filter['page']);
		
		$res = $this->join(array('store_franchisee'))
            ->field(array('fa.*', 'ssi.merchants_name'))
            ->where($where)->order(array($filter['sort_by'] => $filter['sort_order']))
            ->limit($page_row->limit())
            ->select();
		
		$list = array();
		if (!empty($res)) {
			foreach ($res as $row) {
				$row['start_time']  = RC_Time::local_date('Y-m-d H:i', $row['start_time']);
				$row['end_time']    = RC_Time::local_date('Y-m-d H:i', $row['end_time']);
				$list[] = $row;
			}
		}
		
		return array('item' => $list, 'page' => $page_row);
	}
	
	/*获取商家活动列表*/
	public function seller_activity_list($options) {
		$record_count = $this->join(array('store_franchisee'))->where($options)->count();
		//实例化分页
		$page_row = new ecjia_page($record_count, $options['size'], 6, '', $options['page']);
		$res      = $this->join(array('store_franchisee'))->where($options['where'])->field('ssi.merchants_name,fa.*')->limit($page_row->limit())->select();
		return array('favourable_list' => $res, 'page' => $page_row);
	}
}

// end