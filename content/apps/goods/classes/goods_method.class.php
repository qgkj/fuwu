<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 商品操作类
 * @author royalwang
 */
class goods_method {
    
    private $goods_id;
    
    public function __construct($goods_id = '') {
        $this->goods_id = $goods_id;
    }
    
    /**
     * 插入或更新商品属性
     *
     * @param int $goods_id
     *            商品编号
     * @param array $id_list
     *            属性编号数组
     * @param array $is_spec_list
     *            是否规格数组 'true' | 'false'
     * @param array $value_price_list
     *            属性值数组
     * @return array 返回受到影响的goods_attr_id数组
     */
    function handle_goods_attr($id_list, $is_spec_list, $value_price_list) {
        $goods_id = $this->goods_id;
        
        $db = RC_Loader::load_app_model('goods_attr_model', 'goods');
    
        $goods_attr_id = array();
    
        /* 循环处理每个属性 */
        foreach ($id_list as $key => $id) {
            $is_spec = $is_spec_list [$key];
            if ($is_spec == 'false') {
                $value = $value_price_list [$key];
                $price = '';
            } else {
                $value_list = array();
                $price_list = array();
                if ($value_price_list [$key]) {
                    $vp_list = explode(chr(13), $value_price_list [$key]);
                    foreach ($vp_list as $v_p) {
                        $arr = explode(chr(9), $v_p);
                        $value_list [] = $arr [0];
                        $price_list [] = $arr [1];
                    }
                }
                $value = join(chr(13), $value_list);
                $price = join(chr(13), $price_list);
            }
    
            // 插入或更新记录
            $result_id = $db->where(array('goods_id' => $goods_id, 'attr_id' => $id, 'attr_value' => $value))->get_field('goods_attr_id');
            $result_id = $result_id ['goods_attr_id'];
            if (!empty ($result_id)) {
                $data = array(
                    'attr_value' => $value
                );
                $db->where(array('goods_id' => $goods_id, 'attr_id' => $id, 'goods_attr_id' => $result_id))->update($data);
                $goods_attr_id [$id] = $result_id;
            } else {
                $data = array(
                    'goods_id' => $goods_id,
                    'attr_id' => $id,
                    'attr_value' => $value,
                    'attr_price' => $price
                );
                $insert_id = $db->insert($data);
            }
            if ($goods_attr_id [$id] == '') {
                $goods_attr_id [$id] = $insert_id;
            }
        }
    
        return $goods_attr_id;
    }
}

// end