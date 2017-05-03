<?php
  
defined('IN_ECJIA') or exit('No permission resources.');
use Doctrine\Common\Persistence\ObjectManager;

/**
 *促销商品信息
 * @author
 */
class detail_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {

        $this->authadminSession();

        if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
            return new ecjia_error(100, 'Invalid session');
        }
        $priv = $this->admin_priv('goods_manage');

        if (is_ecjia_error($priv)) {
            return $priv;
        }

        $id = $this->requestData('goods_id', '0');
        if ($id <= 0) {
            return new ecjia_error(101, '参数错误');
        }

        $result = RC_Model::Model('goods/goods_model')->promote_goods_info($id);

        /* 多商户处理*/
        if (isset($_SESSION['seller_id']) && $_SESSION['seller_id'] > 0 && $result['seller_id'] != $_SESSION['seller_id']) {
            return new ecjia_error(8, 'fail');
        }

        if (!empty($result)) {
            return array('data' => $result);
        } else {
            return new ecjia_error(13, '不存在的信息');
        }
    }
}

// end
