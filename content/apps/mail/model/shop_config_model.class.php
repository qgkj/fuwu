<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class shop_config_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'shop_config';
		parent::__construct();
	}
    
	/* 获取邮件配置信息 */
	function get_email_setting () {
	    $mail_config = $this->field('code,value')->where(array('parent_id'=>5))->order(array('id' => 'asc'))->select();
	    $arr = array();
	    foreach ($mail_config as $v){
	        $arr[$v['code']] = $v['value'];
	    }
	    return $arr;
	}
  
}

// end