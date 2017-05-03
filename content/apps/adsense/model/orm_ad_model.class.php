<?php
  
use Royalcms\Component\Database\Eloquent\Model;
defined('IN_ECJIA') or exit('No permission resources.');

class orm_ad_model extends Model {
	protected $table = 'ad';
	protected $primaryKey = 'ad_id';
	public function ad_position() {
		return $this->belongsTo('orm_ad_position_model', 'position_id', 'position_id');
	}
	
	/* 获取缓存数据 */
	public function get_cache_item($cache_key) {
		return RC_Cache::app_cache_get($cache_key, 'adsense');
	}
	
	/* 设置缓存数据 */
	public function set_cache_item($cache_key, $item) {
		return RC_Cache::app_cache_set($cache_key, $item, 'adsense', 10080);
	}
	
	/* 释放缓存数据 */
	public function delete_cache_item($cache_key) {
		return RC_Cache::app_cache_delete($cache_key, 'adsense');
	}
}

// end
