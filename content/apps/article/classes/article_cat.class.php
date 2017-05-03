<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 文章分类类
 */
class article_cat {
	/**
	 * 获得指定分类下的子分类的数组
	 *
	 * @access public
	 * @param int $cat_id
	 *        	分类的ID
	 * @param int $selected
	 *        	当前选中分类的ID
	 * @param boolean $re_type
	 *        	返回的类型: 值为真时返回下拉列表,否则返回数组
	 * @param int $level
	 *        	限定返回的级数。为0时返回所有级数
	 * @return mix
	 */
	public static function article_cat_list($cat_id = 0, $selected = 0, $re_type = true, $level = 0) {

		$res = $db_article = RC_DB::table('article_cat as c')
			->leftJoin('article_cat as s', RC_DB::raw('s.parent_id'), '=', RC_DB::raw('c.cat_id'))
			->leftJoin('article as a', RC_DB::raw('a.cat_id'), '=', RC_DB::raw('c.cat_id'))
			->select(RC_DB::raw('c.*'), RC_DB::raw('COUNT(s.cat_id) as has_children'), RC_DB::raw('COUNT(a.article_id) as article_num'))
			->whereNotIn(RC_DB::raw('c.parent_id'), array(1,2,3))
			->where(RC_DB::raw('c.cat_id'), '!=', 1)
			->groupby(RC_DB::raw('c.cat_id'))
			->orderby('parent_id', 'asc')
			->orderby('sort_order', 'asc')
			->get();
		
		if (empty($res) == true) {
			return $re_type ? '' : array ();
		}
		$options = self::article_cat_options($cat_id, $res); // 获得指定分类下的子分类的数组
	
		/* 截取到指定的缩减级别 */
		if ($level > 0) {
			if ($cat_id == 0) {
				$end_level = $level;
			} else {
				$first_item = reset ( $options ); // 获取第一个元素
				$end_level  = $first_item['level'] + $level;
			}
	
			/* 保留level小于end_level的部分 */
			foreach ($options as $key => $val ) {
				if ($val['level'] >= $end_level) {
					unset ( $options[$key] );
				}
			}
		}
		$pre_key = 0;
		if (! empty ( $options )) {
			foreach ( $options as $key => $value ) {
				$options[$key]['has_children'] = 1;
				if ($pre_key > 0) {
					if ($options[$pre_key]['cat_id'] == $options[$key]['parent_id']) {
						$options[$pre_key]['has_children'] = 1;
					}
				}
				$pre_key = $key;
			}
		}
		if ($re_type == true) {
			$select = '';
			foreach ( $options as $var ) {
				$select .= '<option value="' . $var['cat_id'] . '" ';
				$select .= ' cat_type="' . $var['cat_type'] . '" ';
				$select .= ($selected == $var['cat_id']) ? "selected='ture'" : '';
				$select .= '>';
				if ($var['level'] > 0) {
					$select .= str_repeat ( '&nbsp;', $var['level'] * 4 );
				}
				$select .= htmlspecialchars ( addslashes ( $var['cat_name'] ) ) . '</option>';
			}
	
			return $select;
		} else {
			if (!empty($options)) {
				foreach($options as $key => $value) {
					$options[$key]['url'] = build_uri('article_cat', array ('acid' => $value['cat_id']), $value['cat_name'] );
				}
			}
			return $options;
		}
	}

	/**
	 * 过滤和排序所有文章分类，返回一个带有缩进级别的数组
	 *
	 * @access private
	 * @param int $cat_id
	 *        	上级分类ID
	 * @param array $arr
	 *        	含有所有分类的数组
	 * @param int $level
	 *        	级别
	 * @return void
	 */
	public static function article_cat_options($spec_cat_id, $arr) {
		static $cat_options = array ();
	
		if (isset ( $cat_options [$spec_cat_id] )) {
			return $cat_options [$spec_cat_id];
		}
		if (!isset ( $cat_options [0] )) {
			$level = $last_cat_id = 0;
			$options = $cat_id_array = $level_array = array ();
			while ( ! empty ( $arr ) ) {
				foreach ( $arr as $key => $value ) {
					$cat_id = $value ['cat_id'];
					if ($level == 0 && $last_cat_id == 0) {
						if ($value ['parent_id'] > 0) {
							break;
						}
	
						$options [$cat_id] = $value;
						$options [$cat_id] ['level'] = $level;
						$options [$cat_id] ['id'] = $cat_id;
						$options [$cat_id] ['name'] = $value ['cat_name'];
						unset ( $arr [$key] );
	
						if ($value ['has_children'] == 0) {
							continue;
						}
						$last_cat_id = $cat_id;
						$cat_id_array = array (
								$cat_id
						);
						$level_array [$last_cat_id] = ++ $level;
						continue;
					}
	
					if ($value ['parent_id'] == $last_cat_id) {
						$options [$cat_id] = $value;
						$options [$cat_id] ['level'] = $level;
						$options [$cat_id] ['id'] = $cat_id;
						$options [$cat_id] ['name'] = $value ['cat_name'];
						unset ( $arr [$key] );
	
						if ($value ['has_children'] > 0) {
							if (end ( $cat_id_array ) != $last_cat_id) {
								$cat_id_array [] = $last_cat_id;
							}
							$last_cat_id = $cat_id;
							$cat_id_array [] = $cat_id;
							$level_array [$last_cat_id] = ++ $level;
						}
					} elseif ($value ['parent_id'] > $last_cat_id) {
						break;
					}
				}
	
				$count = count ( $cat_id_array );
				if ($count > 1) {
					$last_cat_id = array_pop ( $cat_id_array );
				} elseif ($count == 1) {
					if ($last_cat_id != end ( $cat_id_array )) {
						$last_cat_id = end ( $cat_id_array );
					} else {
						$level = 0;
						$last_cat_id = 0;
						$cat_id_array = array ();
						continue;
					}
				}
	
				if ($last_cat_id && isset ( $level_array [$last_cat_id] )) {
					$level = $level_array [$last_cat_id];
				} else {
					$level = 0;
				}
			}
			$cat_options [0] = $options;
		} else {
			$options = $cat_options [0];
		}
	
		if (! $spec_cat_id) {
			return $options;
		} else {
			if (empty ( $options [$spec_cat_id] )) {
				return array ();
			}
	
			$spec_cat_id_level = $options [$spec_cat_id] ['level'];
	
			foreach ( $options as $key => $value ) {
				if ($key != $spec_cat_id) {
					unset ( $options [$key] );
				} else {
					break;
				}
			}
	
			$spec_cat_id_array = array ();
			foreach ( $options as $key => $value ) {
				if (($spec_cat_id_level == $value ['level'] && $value ['cat_id'] != $spec_cat_id) || ($spec_cat_id_level > $value ['level'])) {
					break;
				} else {
					$spec_cat_id_array [$key] = $value;
				}
			}
			$cat_options [$spec_cat_id] = $spec_cat_id_array;
			return $spec_cat_id_array;
		}
	}
	
	/**
	 * 获得指定文章分类下所有底层分类的ID
	 *
	 * @access public
	 * @param integer $cat 指定的分类ID
	 * @return void
	 */
	public static function get_article_children($cat = 0) {
		return self::db_create_in(array_unique(array_merge(array($cat), array_keys(self::article_cat_list($cat, 0, false)))), 'cat_id');
	}
	
	/**
	 * 创建像这样的查询: "IN('a','b')";
	 *
	 * @access public
	 * @param mix $item_list
	 *        	列表数组或字符串
	 * @param string $field_name
	 *        	字段名称
	 *
	 * @return void
	 */
	public static function db_create_in($item_list, $field_name = '') {
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
	 * 获得指定文章分类下所有底层分类的ID数组
	 *
	 * @access public
	 * @param integer $cat 指定的分类ID
	 * @return array
	 */
	public static function get_children_list($cat = 0) {
		return array_unique(array_merge(array($cat), array_keys(self::article_cat_list($cat, 0, false))));
	}
}

// end