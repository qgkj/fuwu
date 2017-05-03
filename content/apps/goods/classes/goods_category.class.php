<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 商品分类相关处理类
 * @author will.chen
 *
 */
class goods_category {
	/**
	 * 获得商品分类的所有信息
	 *
	 * @param   integer     $cat_id     指定的分类ID
	 *
	 * @return  mix
	 */
	public static function get_cat_info($cat_id) {
		$db = RC_Loader::load_app_model('category_model', 'goods');
		return $db->find(array('cat_id' => $cat_id));
	}
	
	/**
	 * 获得指定分类下所有底层分类的ID
	 *
	 * @access public
	 * @param integer $cat
	 *        	指定的分类ID
	 * @return string
	 */
    public static function get_children($cat = 0, $field = 'g.cat_id') {
    	
    	return $field . self::db_create_in (array_unique(array_merge(array($cat), array_keys(self::cat_list($cat, 0, false )))));
    }
    
    /**
     * 获得所有扩展分类属于指定分类的所有商品ID
     *
     * @access public
     * @param string $cat_id
     *        	分类查询字符串
     * @return string
     */
    public static function get_extension_goods($cats) {
    	$db_goods_cat = RC_Loader::load_app_model('cat_viewmodel', 'goods');
    	$extension_goods_array = array();
    	$data = $db_goods_cat->field('goods_id')->where($cats)->select();
    	if (!empty($data)) {
	    	foreach ( $data as $row ) {
	    		$extension_goods_array[] = $row ['goods_id'];
	    	}
    	}
    	
    	return self::db_create_in ( $extension_goods_array, 'g.goods_id' );
    }
    
	/**
	 * 取得最近的上级分类的grade值
	 *
	 * @access  public
	 * @param   int     $cat_id    //当前的cat_id
	 *
	 * @return int
	 */
	public static function get_parent_grade($cat_id) {
		$db = RC_Loader::load_app_model('category_model', 'goods');
		static $res = NULL;
		if ($res === NULL) {
			$data = false;
			if ($data === false) {
				$res =  $db->field('parent_id, cat_id, grade')->select();
			} else {
				$res = $data;
			}
		}
	
		if (!$res) {
			return 0;
		}
	
		$parent_arr = array();
		$grade_arr = array();
		
		foreach ($res as $val) {
			$parent_arr[$val['cat_id']] = $val['parent_id'];
			$grade_arr[$val['cat_id']] = $val['grade'];
		}
	
		while ($parent_arr[$cat_id] > 0 && $grade_arr[$cat_id] == 0) {
			$cat_id = $parent_arr[$cat_id];
		}
	
		return $grade_arr[$cat_id];
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
    public static function cat_list($cat_id = 0, $selected = 0, $re_type = true, $level = 0, $is_show_all = true) {
    	// 加载方法
    	RC_Loader::load_app_func('global', 'goods');
    	$db_goods = RC_Loader::load_app_model('goods_model', 'goods');
    	$db_category = RC_Loader::load_app_model('category_viewmodel', 'goods');
    	$db_goods_catview = RC_Loader::load_app_model('goods_cat_viewmodel', 'goods');
    	static $res = NULL;
    
    	if ($res === NULL) {
    		$data = false;
    		if ($data === false) {
    			$res = $db_category->join('category')->field('c.cat_id, c.cat_name, c.measure_unit, c.parent_id, c.is_show, c.show_in_nav, c.grade, c.sort_order, COUNT(s.cat_id) AS has_children')->group('c.cat_id')->order(array('c.parent_id' => 'asc', 'c.sort_order' => 'asc'))->select();
    			$res2 = $db_goods->field ( 'cat_id, COUNT(*)|goods_num' )->where(array('is_delete' => 0,'is_on_sale' => 1))->group ('cat_id asc')->select();
    			$res3 = $db_goods_catview->join('goods')->field('gc.cat_id, COUNT(*)|goods_num')->where(array('g.is_delete' => 0,'g.is_on_sale' => 1))->group ('gc.cat_id')->select();
    			$newres = array ();
    			if (!empty($res2)) {
    				foreach($res2 as $k => $v) {
    					$newres [$v ['cat_id']] = $v ['goods_num'];
    					if (!empty($res3)) {
    						foreach ( $res3 as $ks => $vs ) {
    							if ($v ['cat_id'] == $vs ['cat_id']) {
    								$newres [$v ['cat_id']] = $v ['goods_num'] + $vs ['goods_num'];
    							}
    						}
    					}
    				}
    			}
    			
    			if (! empty ( $res )) {
    				foreach ( $res as $k => $v ) {
    					$res [$k] ['goods_num'] = ! empty($newres [$v ['cat_id']]) ? $newres [$v['cat_id']] : 0;
    				}
    			}
    				
    		} else {
    			$res = $data;
    		}
    	}
    	if (empty ( $res ) == true) {
    		return $re_type ? '' : array ();
    	}
    	$options = self::cat_options ( $cat_id, $res ); // 获得指定分类下的子分类的数组
    
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
    			$end_level = $first_item ['level'] + $level;
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
    			foreach ($options as $key => $value ) {
    				$options [$key] ['url'] = build_uri ('category', array('cid' => $value ['cat_id']), $value ['cat_name']);
    			}
    		}
    		return $options;
    	}
    }
    
    /**
     * 获得指定分类同级的所有分类以及该分类下的子分类
     *
     * @access public
     * @param integer $cat_id
     *        	分类编号
     * @return array
     */
   public static function get_categories_tree($cat_id = 0) {
    	$db_category = RC_Model::model('goods/category_model');
    	$cat_arr = array();
    	if ($cat_id > 0) {
    		$parent = $db_category->where(array('cat_id' => $cat_id))->get_field('parent_id');
    		$parent_id = $parent ['parent_id'];
    	} else {
    		$parent_id = 0;
    	}
    	
    	/**
    	 * 判断当前分类中全是是否是底级分类，
    	 * 如果是取出底级分类上级分类，
    	 * 如果不是取当前分类及其下的子分类
    	 */
    	$get_child_tree = self::get_child_tree ($parent_id);
    	
    	$cat_arr = $get_child_tree;
    	return $cat_arr;
    }
    
    private static function get_child_tree($tree_id = 0) {
    	$db_category = RC_Loader::load_app_model('category_model', 'goods');
    	
    	$three_arr = array ();
    	$category_db = RC_Model::model('goods/orm_category_model');
    	$cache_key = sprintf('%X', crc32('category-'. $tree_id));
    	$res = $category_db->get_cache_item($cache_key);
    	if (empty($res)) {
    		$res = $db_category->field('cat_id, cat_name, parent_id, is_show, category_img')->where(array('parent_id' => $tree_id, 'is_show' => 1))->order(array('sort_order' => 'asc', 'cat_id' => 'asc'))->select();
    		$category_db->set_cache_item($cache_key, $res);
    	}
		
		if (!empty($res)) {
			foreach ( $res as $row ) {
				$three_arr [$row ['cat_id']] ['id']		= $row ['cat_id'];
				$three_arr [$row ['cat_id']] ['name']	= $row ['cat_name'];
    			if (isset ( $row ['cat_id'] ) != NULL) {
    				$three_arr [$row ['cat_id']] ['cat_id'] = self::get_child_tree ( $row ['cat_id'] );
    			}
    			$three_arr [$row['cat_id']]['img'] = empty($row['category_img']) ? '' : RC_Upload::upload_url($row['category_img']);
    		}
    	}
    	
    	return $three_arr;
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
    private static function db_create_in($item_list, $field_name = '') {
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
    private static function cat_options($spec_cat_id, $arr) {
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
}

// end