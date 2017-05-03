<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class order_pay_viewmodel extends Component_Model_View {
    public $table_name = '';
    public $view = array();
    public function __construct() {
        $this->table_name 	= 'order_info';
        $this->table_alias_name	= 'oi';

        $this->view = array(
        	'order_goods' => array(
        		'type' => Component_Model_View::TYPE_LEFT_JOIN,
        		'alias' => 'og',
        		'on'   => 'oi.order_id = og.order_id'
        	),
            'pay_log' => array(
                'type' => Component_Model_View::TYPE_LEFT_JOIN,
                'alias' => 'pl',
                'on'   => 'pl.order_id = oi.order_id'
            )
        );
        parent::__construct();
    }
}

// end