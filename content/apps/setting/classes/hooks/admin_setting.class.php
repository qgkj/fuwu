<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class setting_admin_hooks {
	
    public static function display_setting_nav($code) {
        RC_Package::package('app::setting')->loadClass('ecjia_admin_setting', false);
        
        $menus = ecjia_admin_setting::singleton()->load_groups();

        echo '<div class="setting-group">'.PHP_EOL;
        echo '<span class="setting-group-title"><i class="fontello-icon-cog"></i>商店设置</span>'.PHP_EOL;
        echo '<ul class="nav nav-list m_t10">'.PHP_EOL; //
    
        foreach ($menus as $key => $group) {
            if ($group->action == 'divider') {
                echo '<li class="divider"></li>';
            } elseif ($group->action == 'nav-header') {
                echo '<li class="nav-header">' . $group->name . '</li>';
            } else {
                echo '<li><a class="setting-group-item'; //data-pjax
                
                if ($code == $group->action) {
                    echo ' llv-active';
                }
                
                echo '" href="' . $group->link . '">' . $group->name . '</a></li>'.PHP_EOL;
            }
        }
    
        echo '</ul>'.PHP_EOL;
        echo '</div>'.PHP_EOL;
    }
	
    
    public static function form_config_region_select($item) {
        $db_region = RC_Loader::load_model('region_model');
        
        $url = RC_Uri::url('shipping/region/init');
        $countries = $db_region->get_regions();

        ecjia_admin::$controller->assign('countries', $countries);
        ecjia_admin::$controller->assign('var', $item);
        
        if (ecjia::config('shop_country') > 0) {
            ecjia_admin::$controller->assign('provinces', $db_region->get_regions(1, ecjia::config('shop_country')));
            if (ecjia::config('shop_province')) {
                ecjia_admin::$controller->assign('cities', $db_region->get_regions(2, ecjia::config('shop_province')));
            }
        }

        ecjia_admin::$controller->display(
            RC_Package::package('app::setting')->loadTemplate('admin/library/widget_config_region_select.lbi', true)
        );
    }
    
    
    public static function form_config_lang_select($item) {
        RC_Package::package('app::setting')->loadClass('ecjia_admin_setting', false);
        
        /* 可选语言 */
        ecjia_admin::$controller->assign('lang_list', ecjia_admin_setting::singleton()->get_lang_list());
        ecjia_admin::$controller->assign('var', $item);
        
        ecjia_admin::$controller->display(
            RC_Package::package('app::setting')->loadTemplate('admin/library/widget_config_lang_select.lbi', true)
        );
    }
    
    public static function form_config_invoice_type($item) {
        
        ecjia_admin::$controller->assign('invoice_type', ecjia::config('invoice_type'));
        ecjia_admin::$controller->assign('var', $item);
        
        ecjia_admin::$controller->display(
        RC_Package::package('app::setting')->loadTemplate('admin/library/widget_config_invoice_type.lbi', true)
        );
    }
    
    public static function update_config_invoice_type($invoice_type, $invoice_rate) {
        /* 处理发票类型及税率 */
        if (!empty($invoice_rate)) {
            foreach ($invoice_rate as $key => $rate) {
                $rate = round(floatval($rate), 2);
                if ($rate < 0) {
                    $rate = 0;
                }
                $invoice_rate[$key] = $rate;
            }
            $invoice = array(
                'type' => $invoice_type,
                'rate' => $invoice_rate
            );
            ecjia_config::instance()->write_config('invoice_type', serialize($invoice));
        }
    }
    
}

RC_Hook::add_action( 'admin_shop_config_nav', array('setting_admin_hooks', 'display_setting_nav') );

RC_Hook::add_action( 'config_form_shop_country', array('setting_admin_hooks', 'form_config_region_select') );
RC_Hook::add_action( 'config_form_shop_province', array('setting_admin_hooks', 'form_config_region_select') );
RC_Hook::add_action( 'config_form_shop_city', array('setting_admin_hooks', 'form_config_region_select') );
RC_Hook::add_action( 'config_form_lang', array('setting_admin_hooks', 'form_config_lang_select') );
RC_Hook::add_action( 'config_form_invoice_type', array('setting_admin_hooks', 'form_config_invoice_type') );
RC_Hook::add_action( 'update_config_invoice_type', array('setting_admin_hooks', 'update_config_invoice_type'), 10, 2 );

// end