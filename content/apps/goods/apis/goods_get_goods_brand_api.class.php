<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获取所有商品品牌
 * @author songqian
 */
class goods_get_goods_brand_api extends Component_Event_Api {
    public function call(&$options) {
        $row = $this->brandlist($options);
        return $row;
    }
    private function brandlist() {
        $db = RC_Model::model('goods/brand_model');
        $res = $db->field('brand_id, brand_name')->order('sort_order asc')->select();
        $brand_list = array();
        if (!empty($res)) {
            foreach ($res as $row) {
                $brand_list[$row['brand_id']] = addslashes($row['brand_name']);
            }
        }
        return $brand_list;
    }
}
// end