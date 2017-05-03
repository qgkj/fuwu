<?php
  
/**
 * 微信登录
 */
defined('IN_ECJIA') or exit('No permission resources.');

RC_Loader::load_app_class('platform_abstract', 'platform', false);
class mp_goods_best extends platform_abstract
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
	
	//获取精品
    public function event_reply() {
    	$goods_db = RC_Loader::load_app_model('goods_model','goods');
    	$data = $goods_db->where(array('is_best'=>1,'is_delete'=>0))->order('sort_order ASC')->limit(5)->select();
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