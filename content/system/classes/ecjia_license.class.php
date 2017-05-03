<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class ecjia_license {
    
    private $license = array();
    
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
    
    
    /**
     * 获得网店 license 信息
     *
     * @access  public
     * @param   integer     $size
     *
     * @return  array
     */
    public static function get_shop_license()
    {
        return self::instance()->license;
    }
    
    
    public function __construct() {
        if (!ecjia::config('certificate_sn', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', 'certificate_sn', '', array('type' => 'hidden'));
        }
        if (!ecjia::config('certificate_file', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', 'certificate_file', '', array('type' => 'hidden'));
        }
        
        // 取出网店 license
        $this->license['certificate_sn'] = ecjia::config('certificate_sn');
        $this->license['certificate_file'] = ecjia::config('certificate_file');
    }
    
    
    /**
     * 解析证书文件内容
     * @param string $file  file path
     * @return multitype:array|boolean
     */
    public function parse_certificate($file) {
        if (file_exists($file)) {
            $cert = openssl_x509_read(file_get_contents($file));
            $cert_data = openssl_x509_parse($cert, false);
            openssl_x509_free($cert);
            return $cert_data;
        } else {
            return false;
        }
    }
    
    
    /**
     * license check
     * @return  bool
     */
    public function license_check() {
        // 检测网店 license
        if (!empty($this->license['certificate_sn']) && !empty($this->license['certificate_file'])) {
            return true;
        } else {
            return false;
        }
    }

}


// end