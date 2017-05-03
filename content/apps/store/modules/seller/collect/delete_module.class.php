<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 删除收藏店铺
 * @author will.chen
 */
class delete_module extends api_front implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

    	$this->authSession();
		$user_id   = EM_Api::$session['uid'];
		$seller_id = $this->requestData('seller_id');
		if (empty($seller_id)) {
			return new ecjia_error( 'invalid_parameter', RC_Lang::get ('system::system.invalid_parameter' ));
		}
		RC_DB::table('collect_store')->where('user_id', $user_id)->where('store_id', $seller_id)->delete();

		return array();
	}
}

// end
