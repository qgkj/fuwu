<?php
  
use Royalcms\Component\Database\Eloquent\Model;
defined('IN_ECJIA') or exit('No permission resources.');

class orm_goods_model extends Model {
	protected $table = 'goods';
	
	
	/* 将缓存数组添加至创建缓存数组（用于商品列表）*/
	public function create_cache_key_array ($cache_key, $expiry = 10080) 
	{
		if (empty($cache_key)) {
			return '';
		}
		$cache_key = sprintf('%X', crc32($cache_key));
		$cache_array = RC_Cache::app_cache_get('goods_list_cache_key_array', 'goods');
		if (!in_array($cache_key, $cache_array)) {
			if (empty($cache_array)) $cache_array = array();
			array_push($cache_array, $cache_key);
			RC_Cache::app_cache_set('goods_list_cache_key_array', $cache_array, 'goods', $expiry);
		}
		return $cache_key;
	}
	
	/* 获取缓存数据*/
	public function get_cache_item ($cache_key) 
	{
		return RC_Cache::app_cache_get($cache_key, 'goods');
	}
	
	/* 设置缓存数据*/
	public function set_cache_item ($cache_key, $item, $expiry = 10080)
	{
		return RC_Cache::app_cache_set($cache_key, $item, 'goods', $expiry);
	}
	
	/* 释放缓存数据*/
	public function delete_cache_item ($cache_key)
	{
		return RC_Cache::app_cache_delete($cache_key, 'goods');
	}

}

// end
