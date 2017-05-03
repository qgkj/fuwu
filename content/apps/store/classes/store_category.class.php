<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 店铺街分类类文件
 */
class store_category {


	/**
	 * 获得指定分类同级的所有分类以及该分类下的子分类
	 *
	 * @access public
	 * @param integer $cat_id
	 *        	分类编号
	 * @return array
	 */
	public static function get_categories_tree($where) {
		$db_category = RC_Model::model('store/store_franchisee_viewmodel');
		if (!empty($where['sc.cat_id']) && is_array($where['sc.cat_id'])) {
			foreach ($where['sc.cat_id'] as $val) {
				if ($val > 0) {
					$where['sc.cat_id'] = $val;
					$parent = $db_category->join('store_category')->where($where)->get_field('parent_id');
					$parent_id = $parent['parent_id'];
				} else {
					$parent_id = 0;
				}
			}
		}

		/**
		 * 判断当前分类中全是是否是底级分类，
		 * 如果是取出底级分类上级分类，
		 * 如果不是取当前分类及其下的子分类
		 */

		$count = $db_category->join('store_category')->where(array('sc.parent_id' => $parent_id, 'is_show' => 1))->count('sc.cat_id');

		if ($count || $parent_id == 0) {
			/* 获取当前分类及其子分类 */
			$res = $db_category->join('store_category')->field('sc.cat_id, sc.cat_name, sc.parent_id, sc.is_show')->where(array('sc.parent_id' => $parent_id, 'is_show' => 1))->order(array('sc.sort_order'=>'asc','sc.cat_id'=> 'asc'))->select();
			foreach ( $res as $row ) {
				if ($row ['is_show']) {
    				$cat_arr [$row ['cat_id']] ['id'] = $row ['cat_id'];
    				$cat_arr [$row ['cat_id']] ['name'] = $row ['cat_name'];
    				if (isset($row ['cat_id'] ) != NULL) {
    					$cat_arr[$row ['cat_id']] ['cat_id'] = self::get_child_tree ( $row['cat_id'] );
    				}
				}
			}
		}
		if (isset ( $cat_arr )) {
			return $cat_arr;
		}
	}

	public static function get_child_tree($tree_id = 0, $geohash) {
		$db_category = RC_Model::model('store/store_franchisee_viewmodel');
		$three_arr = array ();

		$count = $db_category->join('store_category')->where(array('parent_id' => $tree_id, 'is_show' => 1))->count('ssi.cat_id');
		if ($count > 0 || $tree_id == 0) {

			$res = $db_category->join('store_category')->field('sc.cat_id, sc.cat_name , sc.parent_id, sc.is_show')->where(array('sc.parent_id' => $tree_id, 'is_show' => 1))->order(array('sort_order' => 'asc', 'sc.cat_id' => 'asc'))->select();

			foreach ( $res as $row ) {
				if ($row ['is_show'])
				$three_arr [$row ['cat_id']] ['id'] = $row ['cat_id'];
				$three_arr [$row ['cat_id']] ['name'] = $row ['cat_name'];
				if (isset ( $row ['cat_id'] ) != NULL) {
					$three_arr [$row ['cat_id']] ['cat_id'] = self::get_child_tree ( $row ['cat_id'] );
				}
			}
		}
		return $three_arr;
	}
}

// end
