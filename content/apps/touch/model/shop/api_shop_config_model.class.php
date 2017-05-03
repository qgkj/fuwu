<?php
  
defined('IN_ECJIA') or exit('No permission resources.');
use Ecjia\System\Api\ApiModel;

class api_shop_config_model extends ApiModel
{

    public function __construct(array $input = array())
    {
        $this->data = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_CONFIG)->run();
    }
    
}

// end