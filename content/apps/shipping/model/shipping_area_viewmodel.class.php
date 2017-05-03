<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class shipping_area_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	
	public function __construct() {
		$this->table_name = 'shipping_area';
		$this->table_alias_name	= 'sa';
		
		$this->view = array(
			'store_franchisee' => array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 's',
				'on' 	=> 'sa.store_id = s.store_id', 
			),
		);
		parent::__construct();
	}
	
	/**
	 *  获取配送区域列表
	 */
	public function get_shipareas_list($args = array()){
		$db_shipping_area = RC_DB::table('shipping_area as sa')
		->leftJoin('store_franchisee as s', RC_DB::raw('sa.store_id'), '=', RC_DB::raw('s.store_id'));
		
		/* 过滤条件  为查询*/
		$filter['keywords'] = empty($args['keywords']) ? '' : trim($args['keywords']);
	
		if ($args['shipping_id']) {
			$db_shipping_area->where('shipping_id', $args['shipping_id']);
		}
		if ($filter['keywords']) {
			$db_shipping_area->whereRaw('(sa.shipping_area_name like "%'.mysql_like_quote($filter['keywords']).'%" or s.merchants_name like "%'.mysql_like_quote($filter['keywords']).'%")');
		}
		
		isset($_SESSION['store_id']) ? $db_shipping_area->where(RC_DB::raw('sa.store_id'), $_SESSION['store_id']) : '';
		!empty($args['store_id']) ? $db_shipping_area->where(RC_DB::raw('sa.store_id'), $args['store_id']) : '';
	
		$count = $db_shipping_area->count();
		$page = new ecjia_page($count, 10, 6);
	
		/* 查询所有配送方式信息  */
		$shipping_areas_list = array();
		$list = $db_shipping_area->take(10)->skip($page->start_id-1)->get();
	
		if (!empty($list)) {
			foreach ($list as $row) {
				$db_region = RC_Model::model('shipping/shipping_area_region_viewmodel');
				
				$region_names = RC_DB::table('area_region as a')
					->leftJoin('region as r', RC_DB::raw('r.region_id'), '=', RC_DB::raw('a.region_id'))
					->where(RC_DB::raw('a.shipping_area_id'), $row['shipping_area_id'])
					->select(RC_DB::raw('r.region_name'))
					->get();
				
				if (is_array($region_names) && count($region_names)>0 ) {
					$region_array = array();
					foreach ($region_names as $name) {
						//如果所对应的区域已在区域列表设置中被删除
						if( empty($name['region_name']) ) {
							$region_array[] = '<lable  style="color:red">' .RC_Lang::get('shipping::shipping_area.removed_region'). '</lable>';
						} else{
							$region_array[] = $name['region_name'];
						}
					}
					$regions = implode(',', $region_array);
				}
					
				$row['shipping_area_regions'] = empty($regions) ? '<lable  style="color:red">' .RC_Lang::get('shipping::shipping_area.empty_regions'). '</lable>': $regions;
				$shipping_areas_list[] = $row;
			}
		}
			
		$filter['keywords'] = stripslashes($filter['keywords']);
		return array('areas_list' => $shipping_areas_list, 'filter' => $filter, 'page' => $page->show(10), 'desc' => $page->page_desc());
	}
}

// end