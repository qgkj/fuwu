<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 商品品牌类
 * @author wu
 *
 */
class goods_brand {
	
	/**
	 * 取得商品品牌信息
	 * @param	int		$brand_id
	 * @return	array	商品品牌信息
	 */
	public function brand_info($brand_id) {
		return RC_DB::table('brand')->where('brand_id', $brand_id)->first();
	}
	
	/**
	 * 查询品牌总数
	 * @param	array	$where	条件数组
	 * @return 	int		品牌总数
	 */
	public function brand_count($where) {
		$db_brand = RC_DB::table('brand');
		if (is_array($where)) {
			foreach ($where as $k => $v) {
				if (is_array($v)) {
					foreach ($v as $key => $val) {
						switch ($key) {
							case 'neq':
								$db_brand->where($k, '!=', $val);
								break;
						}
					}
				} else {
					$db_brand->where($k, $v);
				}
			}
		}
		return $db_brand->count();
	}
	
	/**
	 * 根据品牌id查询字段信息
	 * @param	int		$brand_id	品牌id
	 * @param	string	$field		要查询的字段
	 * @return	string	字段信息
	 */
	public function brand_field($brand_id, $field) {
		return RC_DB::table('brand')->where('brand_id', $brand_id)->pluck($field);
	}
	
	/**
	 * 添加品牌
	 * @param	string	$brand_name	品牌名称
	 * @param	string	$site_url	品牌名称
	 * @param	string	$brand_desc	品牌名称
	 * @param	string	$brand_logo	品牌名称
	 * @param	int		$sort_order	排序
	 * @param	bool	$is_show	是否显示
	 * @return 	int		新增品牌id
	 */
	public function insert_brand($brand_name, $site_url, $brand_desc, $brand_logo, $sort_order, $is_show) {
		$data = array(
			'brand_name'	=> $brand_name,
			'site_url'		=> $site_url,
			'brand_desc'  	=> $brand_desc,
			'brand_logo'	=> $brand_logo,
			'sort_order'	=> $sort_order,
			'is_show'		=> $is_show,
		);
		return RC_DB::table('brand')->insertGetId($data);
	}
	
	/**
	 * 更新品牌
	 * @param	int		$brand_id	品牌id
	 * @param	array	$data		品牌信息数组
	 */
	public function update_brand($brand_id, $data) {
		return RC_DB::table('brand')->where('brand_id', $brand_id)->update($data);
	}
	
	/**
	 * 根据品牌id删除品牌
	 * @param	int	$brand_id	品牌id
	 */
	public function brand_delete($brand_id) {
		return RC_DB::table('brand')->where('brand_id', $brand_id)->delete();
	}
}

// end