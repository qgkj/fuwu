<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class seller_goods_cat {            
    /**
     * 获得指定分类下所有底层分类的ID
     *
     * @access public
     * @param integer $cat
     *        	指定的分类ID
     * @return string
     */
    function get_children($options) {
    	$cat_list =  RC_Api::api('goods', 'seller_goods_category', $options);
        return 'g.seller_cat_id ' .self::db_create_in (array_unique(array_merge(array($options['cat_id']), array_keys($cat_list))));
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
    function db_create_in($item_list, $field_name = '') {
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
}

//end