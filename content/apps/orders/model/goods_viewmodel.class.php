<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 站外投放JS数据模型
 */
class goods_viewmodel extends Component_Model_View {
    public $table_name = '';
    public $view = array();
    public function __construct() {
        $this->table_name = 'goods';
        $this->table_alias_name = 'g';
        
        $this->view = array(
            'order_goods' => array(
                'type' => Component_Model_View::TYPE_LEFT_JOIN,
                'alias'=> 'og',
                'field'=> "",
                'on'   => 'og.goods_id = g.goods_id'
            ),
            'order_info' => array(
                    'type' =>Component_Model_View::TYPE_LEFT_JOIN,
                    'alias'=> 'o',
                    'field'=> "",
                    'on' => 'o.order_id = og.order_id'
            )
        );
        parent::__construct();
    }
}

// end
