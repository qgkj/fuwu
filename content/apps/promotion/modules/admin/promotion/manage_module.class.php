<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 促销商品添加编辑处理
 * @author
 */
class manage_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

        $this->authadminSession();
        if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }
        $priv = $this->admin_priv('goods_manage');
        if (is_ecjia_error($priv)) {
            return $priv;
        }

        $goods_id = $this->requestData('goods_id', 0);
        if ($goods_id <= 0) {
            return new ecjia_error(101, '参数错误');
        }
        $count = RC_DB::table('goods')
        ->where('store_id', $_SESSION['store_id'])->where('goods_id', $goods_id)
        ->count();
        if(empty($count)){
            return new ecjia_error(101, '参数错误');
        }
        $promotion_info = RC_Model::Model('goods/goods_model')->promote_goods_info($goods_id);
        /* 多商户处理*/
        if (isset($_SESSION['store_id']) && $_SESSION['store_id'] > 0 && $promotion_info['store_id'] != $_SESSION['store_id']) {
            return new ecjia_error(8, 'fail');
        }

        $promotion = array(
            'goods_id'              => $goods_id,
            'is_promote'            => '1',
            'promote_price'         => $this->requestData('promote_price'),
            'promote_start_date'    => RC_Time::local_strtotime($this->requestData('start_time')),
            'promote_end_date'      => RC_Time::local_strtotime($this->requestData('end_time')),
        );

        /* 检查促销时间 */
        if ($promotion['promote_start_date'] >= $promotion['promote_end_date']) {
            return new ecjia_error('time_error', __('促销开始时间不能大于或等于结束时间'));
        }

        RC_Model::Model('goods/goods_model')->promotion_manage($promotion);

        RC_Loader::load_app_func('global', 'promotion');
        assign_adminlog_content();
        if ($_SESSION['store_id'] > 0) {
//             ecjia_merchant::admin_log($promotion_info['goods_name'].'【来源掌柜】', 'edit', 'promotion');
            RC_Api::api('merchant', 'admin_log', array('text'=>$promotion_info['goods_name'].'【来源掌柜】', 'action'=>'edit', 'object'=>'promotion'));
        } else {
            ecjia_admin::admin_log($promotion_info['goods_name'].'【来源掌柜】', 'edit', 'promotion');
        }
        
        $orm_goods_db = RC_Model::model('goods/orm_goods_model');
        /* 释放app缓存*/
        $goods_cache_array = $orm_goods_db->get_cache_item('goods_list_cache_key_array');
        if (!empty($goods_cache_array)) {
        	foreach ($goods_cache_array as $val) {
        		$orm_goods_db->delete_cache_item($val);
        	}
        	$orm_goods_db->delete_cache_item('goods_list_cache_key_array');
        }
        /*释放商品基本信息缓存*/
        $cache_goods_basic_info_key = 'goods_basic_info_'.$goods_id;
        $cache_basic_info_id = sprintf('%X', crc32($cache_goods_basic_info_key));
        $orm_goods_db->delete_cache_item($cache_basic_info_id);
        return array();
    }
}

// end
