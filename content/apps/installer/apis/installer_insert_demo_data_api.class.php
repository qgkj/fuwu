<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

RC_Package::package('app::installer')->loadClass('install_utility', false);

/**
 * 安装测试数据
 * @author huangyuyuan@ecmoban.com
 */
class installer_insert_demo_data_api extends Component_Event_Api {
	public function call(&$options) {
        $sql_files = array(DATA_PATH . 'data_demo_zh_cn.sql');
	    	
	    $result = install_utility::installData($sql_files);

	    
	    return $result;
	}
}

// end