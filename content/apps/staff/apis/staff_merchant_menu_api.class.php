<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 商家员工管理菜单
 * @author songqian
 */
class staff_merchant_menu_api extends Component_Event_Api {

    public function call(&$options) {
        $menus = ecjia_merchant::make_admin_menu('staff', '员工管理', '', 5)->add_icon('fa-group')->add_purview(array('staff_manage','staff_group_manage','staff_log_manage'))->add_base('staff');
        
        $submenus = array(
            ecjia_merchant::make_admin_menu('01_goods_list', '我的员工', RC_Uri::url('staff/merchant/init'), 1)->add_purview('staff_manage')->add_icon('fa-user'),
            ecjia_merchant::make_admin_menu('02_goods_type', '员工组', RC_Uri::url('staff/mh_group/init'), 2)->add_purview('staff_group_manage')->add_icon('fa-share-alt'),
            ecjia_merchant::make_admin_menu('03_goods_trash', '员工日志', RC_Uri::url('staff/mh_log/init'), 3)->add_purview('staff_log_manage')->add_icon('fa-list-alt'),
        );
        
        $menus->add_submenu($submenus);
        return $menus;
    }
}

// end