<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class order_info_viewmodel extends Component_Model_View {
    public $table_name = '';
    public $view = array();
    public function __construct() {
        $this->table_name = 'order_info';
        $this->table_alias_name = 'oi';
        
        $this->view = array(
        	'order_goods' => array(
            	'type'	=> Component_Model_View::TYPE_LEFT_JOIN,
              	'alias' => 'g',
               	'field' => 'IFNULL(SUM(g.goods_number), 0) as goods_number',
              	'on'  	=> 'oi.order_id = g.order_id '
          	)
        );
        parent::__construct();
    }
}

// end
