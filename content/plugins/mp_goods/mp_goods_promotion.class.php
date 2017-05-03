<?php
  
/**
 * 微信登录
 */
defined('IN_ECJIA') or exit('No permission resources.');

RC_Loader::load_app_class('platform_abstract', 'platform', false);
class mp_goods_promotion extends platform_abstract
{   
	
	/**
	 * 获取插件配置信息
	 */
	public function local_config() {
		$config = include(RC_Plugin::plugin_dir_path(__FILE__) . 'config.php');
		if (is_array($config)) {
			return $config;
		}
		return array();
	}
	
	//获取促销商品
    public function event_reply() {
    	$db_goods = RC_Loader::load_app_model('goods_model','goods');
   
    	$where = array('is_promote' => 1);
		$where['is_delete'] = array('neq' => 1);
		$time = RC_Time::gmtime();
		$where['promote_start_date'] = array('elt' => $time);
		$where['promote_end_date'] = array('egt' => $time);
    	$field = 'goods_id, goods_name, promote_price, promote_start_date, promote_end_date, goods_img';
    	$data = $db_goods->field($field)->where($where)->order('sort_order ASC')->limit(5)->select();
    	$articles = array();
    	foreach ($data as $key => $val) {
    		$articles[$key]['Title'] = $val['goods_name'];
    		$articles[$key]['Description'] = '';
    		$articles[$key]['PicUrl'] = RC_Upload::upload_url($val['goods_img']);
    		$articles[$key]['Url'] = RC_Uri::home_url().'/sites/m/index.php?m=goods&c=index&a=show&goods_id='.$val['goods_id'];
    	}
    	
    	$count = count($articles);
    	$content = array(
    		'ToUserName' => $this->from_username,
    		'FromUserName' => $this->to_username,
    		'CreateTime' => SYS_TIME,
    		'MsgType' => 'news',
    		'ArticleCount'=>$count,
    		'Articles'=>$articles
    	);
    	return $content;
    }
}

// end