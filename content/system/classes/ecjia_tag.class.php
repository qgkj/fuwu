<?php
  
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 模版标签接口类
 * @author royalwang
 *
 */
interface ecjia_tag {
    public function run(&$options);
}

// end