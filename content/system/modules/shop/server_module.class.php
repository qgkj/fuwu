<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class server_module extends api_front implements api_interface
{

    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {
        return RC_ENV::phpinfo();
    }
}


// end