<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class token_module extends api_front implements api_interface
{
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {
    	$data = array(
    			'access_token' => RC_Session::session_id(),
    			'expires_in'   => RC_Config::load_config('session', 'lifetime'),
    	);
    	
    	return $data;
    }
}


// end