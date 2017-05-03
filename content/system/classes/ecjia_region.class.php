<?php
  
class ecjia_region {
    private $region	= array();
    private $db_region;
    private $cache_key = 'shop_region';
    
    private static $instance = null;
    
    /**
     * 返回当前终级类对象的实例
     *
     * @param $cache_config 缓存配置
     * @return object
     */
    public static function instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function __construct() {
        $this->db_region = RC_Loader::load_model('region_model');
    }
    
    
    public function region_datas($type = 0, $parent = 0) {
        return $this->db_region->get_regions($type, $parent);
    }
    
    
    public function region_data($id) {
        
    }

    
    public function region_name($id) {
        if (is_int($id)) {
            return $this->db_region->where(array('region_id' => $id))->get_field('region_name');
        } else {
            return null;
        }
    }
}


// end