<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 收藏店铺
 * @author will.chen
 */
class create_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

    	$this->authSession();
		$user_id   = EM_Api::$session['uid'];
		$seller_id = $this->requestData('seller_id');

		if (empty($seller_id)) {
			return new ecjia_error( 'invalid_parameter', RC_Lang::get ('system::system.invalid_parameter' ));
		}
		$cs_db = RC_Model::model('store/collect_store_model');
		$row   = $cs_db->find(array('user_id' => $user_id, 'store_id' => $seller_id));
		if (!empty($row)) {
			$result = new ecjia_error('is_collected', __('该店铺已收藏！'));
			return $result;
		}

		// $ssi_db = RC_Model::model('store/seller_shopinfo_model');
// 		$msi_dbview = RC_Loader::load_app_model('merchants_shop_information_viewmodel', 'seller');
		$where            = array();
		$where['status']  = 1;
		$where['id']      = $seller_id;
		$count            = RC_DB::table('store_franchisee')->where('status', '1')->where('store_id', $seller_id)->count();
		if ($count == 0 ) {
			$result = new ecjia_error('shop_error', __('店铺不存在！'));
			return $result;
		}
		$data = array(
				'user_id'	     => $user_id,
				'store_id'       => $seller_id,
				'add_time'	     => RC_Time::gmtime(),
				'is_attention'   => 1,
		);
		$cs_db->insert($data);

		return array();
	}
}

// end
