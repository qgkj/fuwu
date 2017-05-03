<?php
  
use Royalcms\Component\Database\Eloquent\Model;
defined('IN_ECJIA') or exit('No permission resources.');

class orm_store_franchisee_model extends Model {
	protected $table = 'store_franchisee';
	
	
	/* 将缓存数组添加至创建缓存数组（用于店铺列表）*/
	public function create_cache_key_array ($cache_key, $expiry = 10080) 
	{
		if (empty($cache_key)) {
			return '';
		}
		$cache_key = sprintf('%X', crc32($cache_key));
		$cache_array = RC_Cache::app_cache_get('store_list_cache_key_array', 'store');
		if (!in_array($cache_key, $cache_array)) {
			if (empty($cache_array)) $cache_array = array();
			array_push($cache_array, $cache_key);
			RC_Cache::app_cache_set('store_list_cache_key_array', $cache_array, 'store', $expiry);
		}
		return $cache_key;
	}
	
	/* 获取缓存数据*/
	public function get_cache_item ($cache_key) 
	{
		return RC_Cache::app_cache_get($cache_key, 'store');
	}
	
	/* 设置缓存数据*/
	public function set_cache_item ($cache_key, $item, $expiry = 10080)
	{
		return RC_Cache::app_cache_set($cache_key, $item, 'store', $expiry);
	}
	
	/* 释放缓存数据*/
	public function delete_cache_item ($cache_key)
	{
		return RC_Cache::app_cache_delete($cache_key, 'store');
	}
}

// end
