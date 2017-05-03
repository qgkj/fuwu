<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 检查分类是否已经存在
 *
 * @param   string      $cat_name       分类名称
 * @param   integer     $parent_cat     上级分类
 * @param   integer     $exclude        排除的分类ID
 *
 * @return  boolean
 */
function cat_exists($cat_name, $parent_cat, $exclude = 0) {

	$db = RC_DB::table('store_category');
	return ($db->where('parent_id', $parent_cat)->where('cat_name', $cat_name)->where('cat_id', '<>', $exclude)->count() > 0) ? true : false;
}


/**
 * 获得店铺分类的所有信息
 *
 * @param   integer     $cat_id     指定的分类ID
 *
 * @return  mix
 */
function get_cat_info($cat_id) {
	$db = RC_DB::table('store_category');
	return $db->where('cat_id', $cat_id)->first();
}

/**
 * 修改店铺分类是否显示
 *
 * @param   integer $cat_id
 * @param   array   $args
 *
 * @return  mix
 */
function cat_update($cat_id, $args) {
	$db = RC_DB::table('store_category');   
	if (empty($args) || empty($cat_id)) {
		return false;
	}

	return $db->where('cat_id', $cat_id)->update($args);
}


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
 * @param int $is_show_all
 *        	如果为true显示所有分类，如果为false隐藏不可见分类。
 * @return mix
 */
function cat_list($cat_id = 0, $selected = 0, $re_type = true, $level = 0, $is_show_all = true) {
	// 加载方法
	//$db_shopinfo = RC_Loader::load_app_model('seller_shopinfo_model', 'seller');
	//$db_category = RC_Loader::load_app_model('seller_category_viewmodel', 'seller');
	$db_store_franchisee = RC_DB::table('store_franchisee');
	$db_store_category = RC_DB::table('store_category as c')
						->leftJoin('store_category as s', RC_DB::raw('s.parent_id'), '=', RC_DB::raw('c.cat_id'));
	static $res = NULL;

	if ($res === NULL) {
		$data = false;
		if ($data === false) {
			//$res = $db_category->join('seller_category')->group('c.cat_id')->order(array('c.parent_id' => 'asc', 'c.sort_order' => 'asc'))->select();
			//$res2 = $db_shopinfo->field ( 'cat_id, COUNT(*)|store_num' )->group ('cat_id asc')->select();
			$res = $db_store_category
					->selectRaw('c.cat_id, c.cat_name, c.parent_id, c.is_show, c.sort_order, COUNT(s.cat_id) AS has_children')
					->groupBy(RC_DB::raw('c.cat_id'))
					->orderBy(RC_DB::raw('c.parent_id'), 'asc')
					->orderBy(RC_DB::raw('c.sort_order', 'asc'))
					->get();
			$res2 = $db_store_franchisee
					 ->select(RC_DB::raw('cat_id'), RC_DB::raw('COUNT(*) as store_num'))
					 ->groupBy(RC_DB::raw('cat_id'))
					 ->get();
			//$res3 = $db_goods_cat->join('goods')->where(array('g.is_delete' => 0, 'g.is_on_sale' => 1))->group ('gc.cat_id')->select();
			$newres = array ();
			if (!empty($res2)) {
				foreach($res2 as $k => $v) {
					$newres [$v ['cat_id']] = $v ['store_num'];
// 					if (!empty($res3)) {
// 						foreach ( $res3 as $ks => $vs ) {
// 							if ($v ['cat_id'] == $vs ['cat_id']) {
// 								$newres [$v ['cat_id']] = $v ['goods_num'] + $vs ['goods_num'];
// 							}
// 						}
// 					}
				}
			}
			if (! empty ( $res )) {
				foreach ( $res as $k => $v ) {
					$res [$k] ['store_num'] = ! empty($newres [$v ['cat_id']]) ? $newres [$v['cat_id']] : 0;
				}
			}
				
		} else {
			$res = $data;
		}
	}
	if (empty ( $res ) == true) {
		return $re_type ? '' : array ();
	}

	$options = cat_options ( $cat_id, $res ); // 获得指定分类下的子分类的数组

	$children_level = 99999; // 大于这个分类的将被删除
	if ($is_show_all == false) {
		foreach ( $options as $key => $val ) {
			if ($val ['level'] > $children_level) {
				unset ( $options [$key] );
			} else {
				if ($val ['is_show'] == 0) {
					unset ( $options [$key] );
					if ($children_level > $val ['level']) {
						$children_level = $val ['level']; // 标记一下，这样子分类也能删除
					}
				} else {
					$children_level = 99999; // 恢复初始值
				}
			}
		}
	}

	/* 截取到指定的缩减级别 */
	if ($level > 0) {
		if ($cat_id == 0) {
			$end_level = $level;
		} else {
			$first_item = reset ( $options ); // 获取第一个元素
			$end_level  = $first_item ['level'] + $level;
		}

		/* 保留level小于end_level的部分 */
		foreach ( $options as $key => $val ) {
			if ($val ['level'] >= $end_level) {
				unset ( $options [$key] );
			}
		}
	}

	if ($re_type == true) {
		$select = '';
		if (! empty ( $options )) {
			foreach ( $options as $var ) {
				$select .= '<option value="' . $var ['cat_id'] . '" ';
				$select .= ($selected == $var ['cat_id']) ? "selected='ture'" : '';
				$select .= '>';
				if ($var ['level'] > 0) {
					$select .= str_repeat ( '&nbsp;', $var ['level'] * 4 );
				}
				$select .= htmlspecialchars ( addslashes($var ['cat_name'] ), ENT_QUOTES ) . '</option>';
			}
		}
		return $select;
	} else {
		if (! empty($options )) {
// 			foreach ($options as $key => $value ) {
// 				$options [$key] ['url'] = build_uri ('category', array('cid' => $value ['cat_id']), $value ['cat_name']);
// 			}
		}
		return $options;
	}
}

/**
 * 过滤和排序所有分类，返回一个带有缩进级别的数组
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
function cat_options($spec_cat_id, $arr) {
	static $cat_options = array ();
	
	if (isset ( $cat_options [$spec_cat_id] )) {
		return $cat_options [$spec_cat_id];
	}
	
	if (! isset ( $cat_options [0] )) {
		$level = $last_cat_id = 0;
		$options = $cat_id_array = $level_array = array ();
		$data = false;
		if ($data === false) {
			while ( ! empty ( $arr ) ) {
				foreach ( $arr as $key => $value ) {
					$cat_id = $value ['cat_id'];
					if ($level == 0 && $last_cat_id == 0) {
						if ($value ['parent_id'] > 0) {
							break;
						}
						
						$options [$cat_id]            = $value;
						$options [$cat_id] ['level']  = $level;
						$options [$cat_id] ['id']     = $cat_id;
						$options [$cat_id] ['name']   = $value ['cat_name'];
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
						$options [$cat_id]            = $value;
						$options [$cat_id] ['level']  = $level;
						$options [$cat_id] ['id']     = $cat_id;
						$options [$cat_id] ['name']   = $value ['cat_name'];
						unset ( $arr [$key] );
						
						if ($value ['has_children'] > 0) {
							if (end ( $cat_id_array ) != $last_cat_id) {
								$cat_id_array [] = $last_cat_id;
							}
							$last_cat_id                 = $cat_id;
							$cat_id_array []             = $cat_id;
							$level_array [$last_cat_id]  = ++ $level;
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
						$level        = 0;
						$last_cat_id  = 0;
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
		} else {
			$options = $data;
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
 * 获得指定分类下所有底层分类的ID
 *
 * @access public
 * @param integer $cat
 *        	指定的分类ID
 * @return string
 */
function get_children($cat = 0) {
	return array_unique(array_merge(array($cat), array_keys(cat_list($cat, 0, false ))));
}

// end