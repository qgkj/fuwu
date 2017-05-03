<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class platform_command {
    protected $request;
    protected $account_id;
    /**
     * 实例方法执行者
     */
    public function __construct($request, $account_id) {
        $this->request      = $request;
        $this->account_id   = $account_id;
    }
    
    /**
     * 执行一个命令
     * @param string $cmd
     */
    public function runCommand($cmd) {
        //查询$cmd命令是哪个插件的
        $db_platform_command = RC_Loader::load_app_model('platform_command_model', 'platform');
        
        $row = $db_platform_command->where(array('cmd_word' => $cmd, 'account_id' => $this->account_id))->find();
        if (!empty($row) && $row['ext_code']) {
            RC_Loader::load_app_class('platform_factory', 'platform', false);
            $handler = new platform_factory($row['ext_code'], array('parameter' => $this->request->getParameters(), 'sub_code' => $row['sub_code']));
            return $handler->event_reply();
        } else {
            return null;
        }
    }
    
    /**
     * 查询$cmd命令是否存在
     * @param string $cmd
     * @return boolean
     */
    public function hasCommand($cmd) {
        $db_platform_command = RC_Loader::load_app_model('platform_command_model', 'platform');
        $row = $db_platform_command->where(array('cmd_word' => $cmd, 'account_id' => $this->account_id))->find();
        if (!empty($row)) {
            return true;
        } else {
            return false;
        }
    }
}

// end