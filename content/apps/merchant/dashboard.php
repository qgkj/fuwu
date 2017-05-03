<?php 
  
defined('IN_ECJIA') or exit('No permission resources.');

class dashboard extends ecjia_merchant {
	
    public function init() {
        
        ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(__('仪表盘')));
        ecjia_merchant_screen::get_current_screen()->set_parentage('dashboard', 'merchant/dashboard.php');
        
        ecjia_merchant::$controller->assign('ur_here', __('仪表盘'));
        ecjia_merchant::$controller->display('index.dwt');
    }
}

//end