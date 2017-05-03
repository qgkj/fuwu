<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class ecjia_merchant_purview extends ecjia_purview
{
    
    protected function loadSystemPurivew($priv_str)
    {
    	//
    }

    /**
     * 请求权限API，获取配置数据
     * @param string $app_dir
     */
    protected function requestPurviewApi($app_dir)
    {
        $res = RC_Api::api($app_dir, 'merchant_purview');
        return $res;
    }
}

// end