<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class ecjia_admin_setting extends RC_Object {
    
    public function __construct(){
        
    }
    
    
    public function load_groups() {
        $menus = array(
            ecjia_admin::make_admin_menu('shop_info', $this->cfg_name_langs('shop_info'), RC_Uri::url('setting/shop_config/init', array('code' => 'shop_info')), 2)->add_purview('shop_config')->add_icon('fontello-icon-wrench'),
            ecjia_admin::make_admin_menu('basic', $this->cfg_name_langs('basic'), RC_Uri::url('setting/shop_config/init', array('code' => 'basic')), 1)->add_purview('shop_config')->add_icon('fontello-icon-info'),
            ecjia_admin::make_admin_menu('display', $this->cfg_name_langs('display'), RC_Uri::url('setting/shop_config/init', array('code' => 'display')), 3)->add_purview('shop_config')->add_icon('fontello-icon-desktop'),
            ecjia_admin::make_admin_menu('shopping_flow', $this->cfg_name_langs('shopping_flow'), RC_Uri::url('setting/shop_config/init', array('code' => 'shopping_flow')), 4)->add_purview('shop_config')->add_icon('fontello-icon-truck'),
            ecjia_admin::make_admin_menu('goods', $this->cfg_name_langs('goods'), RC_Uri::url('setting/shop_config/init', array('code' => 'goods')), 5)->add_purview('shop_config')->add_icon('fontello-icon-gift'),
        );
        
        $menus = RC_Hook::apply_filters('append_admin_setting_group', $menus);
        return $menus;
    }
    
    
    public function load_items($group) {
        $parent_id = $this->get_parent_id($group);
        
        $item_list = RC_DB::table('shop_config')
                    ->where('parent_id', $parent_id)
                    ->where('type', '<>', 'hidden')
                    ->orderBy('sort_order', 'asc')->orderBy('id', 'asc')->get();

        foreach ($item_list AS $key => & $item) {
            $item['name'] = $this->cfg_name_langs($item['code'], $item['code']);
            $item['desc'] = $this->cfg_desc_langs($item['code'], '');
            
            if ($item['type']=='file' && !empty($item['value'])) {
                if ($item['code'] == 'icp_file') {
                	$value = explode('/', $item['value']);
                    $item['file_name'] = array_pop($value);
                }
                $item['value'] = RC_Upload::upload_url() .'/'. $item['value'];
            }
            
            if ($item['code'] == 'sms_shop_mobile') {
                $item['url'] = 1;
            }
            
            if ($item['store_range']) {
                $item['store_options'] = explode(',', $item['store_range']);
            
                foreach ($item['store_options'] AS $k => $v) {
                    $item['display_options'][$k] = $this->cfg_range_langs($item['code'].'.'.$v, $v);
                }
            }
        }
        
        return $item_list;
    }

    
    public function get_lang_list() {
        return array(
        	'zh_CN'
        );
    }
    
    protected function get_parent_id($code) {
        $id = RC_DB::table('shop_config')->where('parent_id', 0)->where('type', 'group')->where('code', $code)->pluck('id');
        return $id;
    }
    
    public function cfg_name_langs($key, $default = null) {
        $cfg_name_lang  = RC_Lang::get('setting::shop_config.cfg_name');
        
        return array_get($cfg_name_lang, $key, $default);
    }
    
    public function cfg_desc_langs($key, $default = null) {
        $cfg_desc_lang  = RC_Lang::get('setting::shop_config.cfg_desc');
        
        return array_get($cfg_desc_lang, $key, $default);
    }
    
    public function cfg_range_langs($key, $default = null) {
        $cfg_range_lang = RC_Lang::get('setting::shop_config.cfg_range');
        
        return array_get($cfg_range_lang, $key, $default);
    }
    
    /**
     * 是否覆盖文件
     * @param string $code
     * @return boolean
     */
    public function is_replace_file($code) {
        //定义需要替换的文件
        $files = array('shop_logo', 'watermark', 'wap_logo', 'no_picture');
         
        return in_array($code, $files);
    }
    
    /**
     * 删除需要覆盖的文件
     *
     * @param string $code
     * @param string $value
     */
    public function replace_file($code, $value) {
        //删除原有文件
        if ($this->is_replace_file($code)) {
            if (file_exists(RC_Upload::upload_path() . $value)) {
                $disk = RC_Filesystem::disk();
                $disk->delete(RC_Upload::upload_path() . $value);
            }
        }
    }
    
}

// end