<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class affiliate_order_info_viewmodel extends Component_Model_View {
    public $table_name = '';
    public $view = array();
    public function __construct() {
		$this->table_name = 'order_info';
		$this->table_alias_name = 'o';

		$this->view = array(
			'users' => array(
				'type'  => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'u',
				'on'    => 'o.user_id = u.user_id',
			),
			'affiliate_log' => array(
				'type'  => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'a',
				'on'    => 'o.order_id = a.order_id',
			),
			'order_goods' => array (
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'g',
				'on' 	=> 'o.order_id = g.order_id '
			)
		);
		parent::__construct();
    }
    
    public function order_info_select($option) {
    	return $this->join($option['table'])->field($option['field'])->where($option['where'])->order($option['order'])->limit($option['limit'])->select();
    }
    
    public function order_info_count($option) {
    	return $this->join($option['table'])->where($option['where'])->count('*');
    }
    
    public function order_info_find($where, $field='*') {
    	return $this->where($where)->field($field)->find();
    }
}

// end