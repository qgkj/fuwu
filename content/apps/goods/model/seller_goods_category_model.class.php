<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class seller_goods_category_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'seller_goods_category';
		parent::__construct();
	}
	
	/**
	 * 检查分类是否已经存在
	 *
	 * @param   string      $cat_name       分类名称
	 * @param   integer     $parent_cat     上级分类
	 * @param   integer     $exclude        排除的分类ID
	 *
	 * @return  boolean
	 */
	public function cat_exists($cat_name, $parent_cat, $exclude = 0, $seller_id) {
		return ($this->where(array('parent_id' => $parent_cat, 'cat_name' => $cat_name, 'seller_id' => $seller_id,'cat_id' => array('neq' => $exclude)))->count() > 0) ? true : false;
	}
	
	/**
	 * 获得商品类型的列表
	 *
	 * @access  public
	 * @param   integer     $selected   选定的类型编号
	 * @return  string
	 */
	public function goods_type_list($selected) {
		$db = RC_Model::model('goods/goods_type_model');
		$data = $db->field('cat_id, cat_name')->where(array('enabled' => 1))->select();
	
		$lst = '';
		if (!empty($data)) {
			foreach ($data as $row){
				$lst .= "<option value='$row[cat_id]'";
				$lst .= ($selected == $row['cat_id']) ? ' selected="true"' : '';
				$lst .= '>' . htmlspecialchars($row['cat_name']). '</option>';
			}
		}
		return $lst;
	}
	
	/**
	 * 获取属性列表
	 *
	 * @access  public
	 * @param
	 *
	 * @return void
	 */
	public function get_category_attr_list() {
		$db = RC_Model::model('goods/attribute_goods_viewmodel');
		$arr = $db->join('goods_type')->where("gt.enabled = 1")->order(array('a.cat_id' => 'asc','a.sort_order' => 'asc'))->select();
	
		$list = array();
	
		foreach ($arr as $val) {
			if (!empty($val['cat_id'])) {
				$list[$val['cat_id']][] = array($val['attr_id']=>$val['attr_name']);
			}
		}
	
		return $list;
	}
	
	/**
	 * 插入首页推荐扩展分类
	 *
	 * @access  public
	 * @param   array   $recommend_type 推荐类型
	 * @param   integer $cat_id     分类ID
	 *
	 * @return void
	 */
	public function insert_cat_recommend($recommend_type, $cat_id) {
		$db = RC_Model::model('goods/cat_recommend_model');
		/* 检查分类是否为首页推荐 */
		if (!empty($recommend_type)) {
			/* 取得之前的分类 */
			$recommend_res = $db->field('recommend_type')->where(array('cat_id' => $cat_id))->select();
			if (empty($recommend_res)) {
				foreach($recommend_type as $data) {
					$data = intval($data);
					$query = array(
							'cat_id' 			=> $cat_id,
							'recommend_type' 	=> $data
					);
					$db->insert($query);
				}
			} else {
				$old_data = array();
				foreach($recommend_res as $data) {
					$old_data[] = $data['recommend_type'];
				}
				$delete_array = array_diff($old_data, $recommend_type);
				if (!empty($delete_array)) {
					$db->where(array('cat_id' => $cat_id))->in(array('recommend_type' => $delete_array))->delete();
				}
				$insert_array = array_diff($recommend_type, $old_data);
				if (!empty($insert_array)) {
					foreach($insert_array as $data) {
						$data = intval($data);
						$query = array(
								'cat_id'          => $cat_id,
								'recommend_type'  => $data
						);
						$db->insert($query);
					}
				}
			}
		} else {
			$db->where(array('cat_id' => $cat_id))->delete();
		}
	}
	

	/**
	 * 添加类目证件标题
	 * @param unknown $dt_list
	 * @param int $cat_id
	 * @param array $dt_id
	 */
	public function get_documentTitle_insert_update($dt_list, $cat_id, $dt_id = array()){
		$db_merchants_documenttitle = RC_Model::model('goods/merchants_documenttitle_model');
	
		for($i=0; $i<count($dt_list); $i++){
	
			$dt_list[$i] = trim($dt_list[$i]);
	
			$catId = $db_merchants_documenttitle->where(array('dt_id'=>$dt_id[$i]))->get_field('cat_id');
	
			if(!empty($dt_list[$i])){
				$parent = array(
						'cat_id' 		=> $cat_id,
						'dt_title' 		=> $dt_list[$i]
				);
	
				if($catId > 0){
					$db_merchants_documenttitle->where(array('dt_id'=>$dt_id[$i]))->update($parent);
				}else{
					$db_merchants_documenttitle->insert($parent);
				}
			}else{
				if($catId > 0){
					//删除二级类目表数据
					$db_merchants_documenttitle->where(array('dt_id'=>$dt_id[$i],'user_id'=>$_SESSION['ru_id']))->delete();
				}
			}
		}
	}
	
	/**
	 * 获取属性列表
	 *
	 * @return  array
	 */
	function get_attr_list() {
		$dbview  = RC_Model::model('goods/attribute_goods_viewmodel');
		/* 查询条件 */
		$filter = array();
		$filter['cat_id'] = empty($_REQUEST['cat_id']) ? 0 : intval($_REQUEST['cat_id']);
		$filter['sort_by']    = empty($_REQUEST['sort_by']) ? 'sort_order' : trim($_REQUEST['sort_by']);
		$filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'asc' : trim($_REQUEST['sort_order']);
		
		$where = (!empty($filter['cat_id'])) ? " a.cat_id = '$filter[cat_id]' " : '';
		$count = $dbview->join(null)->where($where)->count();
	
		/* 加载分页类 */
		RC_Loader::load_sys_class('ecjia_page', false);
		$page = new ecjia_page($count, 15, 5);
	
		/* 查询 */
		$dbview->view =array(
			'goods_type' => array(
				'type'  => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 't',
				'field' => 'a.*, t.cat_name',
				'on'    => 'a.cat_id = t.cat_id'
				)
			);
		$row = $dbview->join('goods_type')->where($where)->order(array($filter['sort_by']=>$filter['sort_order']))->limit($page->limit())->select();
	
		if(!empty($row)) {
			foreach ($row AS $key => $val) {
				// $row[$key]['attr_input_type_desc'] = RC_Lang::get("goods::goods.value_attr_input_type.".$val[attr_input_type]);//暂时注释2016-07-08
				$row[$key]['attr_values'] = str_replace("\n", ", ", $val['attr_values']);
			}
		}
	
		return array('item' => $row, 'page' => $page->show(5), 'desc' => $page->page_desc());
	}
	
	/**
	 * 获得商品分类的所有信息
	 *
	 * @param   integer     $cat_id     指定的分类ID
	 *
	 * @return  mix
	 */
	public function get_cat_info($cat_id) {
		return $this->find(array('cat_id' => $cat_id));
	}
	
	
	/**
	 * 添加商品分类
	 *
	 * @param   integer $cat_id
	 * @param   array   $args
	 *
	 * @return  mix
	 */
	public function cat_update($cat_id, $args, $seller_id) {
		if (empty($args) || empty($cat_id)) {
			return false;
		}
	
		 $this->where(array('cat_id' => $cat_id, 'seller_id' => $seller_id))->update($args);
	}
	
	/**
	 * 保存某商品的扩展分类
	 *
	 * @param int $goods_id
	 *            商品编号
	 * @param array $cat_list
	 *            分类编号数组
	 * @return void
	 */
	function handle_other_cat($goods_id, $add_list)
	{
		/* 查询现有的扩展分类 */
		$db = RC_Model::model('goods/goods_cat_model');
	
		$db->where(array('goods_id' => $goods_id))->delete();
	
		if (!empty ($add_list)) {
			$data = array();
			foreach ($add_list as $cat_id) {
				// 插入记录
				$data[] = array(
						'goods_id'  => $goods_id,
						'cat_id'    => $cat_id
				);
			}
			$db->batch_insert($data);
		}

	}	
	
	/**
	 * 获取商家一级商品分类
	 * @param   string      $options   where条件
	 * @return  array()
	 */
	public function get_seller_goods_cat_ids($options) {
		$cat_ids = $this->where($options['where'])->field('cat_id')->select();
		return $cat_ids;
	}
	
	/**
	 * 获取商家一级商品分类名称
	 * @param   string      $options   where条件
	 * @return  array()
	 */
	public function get_seller_goods_cat_name($options) {
		$cat_ids = $this->where(array('cat_id' => $options['cat_id']))->get_field('cat_name');
		return $cat_ids;
	}
}

// end