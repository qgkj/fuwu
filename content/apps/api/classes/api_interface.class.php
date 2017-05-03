<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * API接口类
 * @author royalwang
 */
interface api_interface {
    /**
     * API接口响应方法
     * @param \Royalcms\Component\HttpKernel\Request $request
     * @param unknown $response
     */
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request);
    
}

// end