<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class platform_account {
    protected static $uuid_pool = array();
    
    protected $uuid;
    protected $row;
    
    public static function make($uuid) {
        if (isset(self::$uuid_pool[$uuid]) && self::$uuid_pool[$uuid]) {
            return self::$uuid_pool[$uuid];
        } else {
            return new static($uuid);
        }
    }
    
    public function __construct($uuid) {
        $this->uuid = $uuid;
        $this->row = $this->getAccountRow();
        self::$uuid_pool[$uuid] = $this;
    }
    
    protected function getAccountRow() {
        //查询数据库
        $db_platform_command = RC_Loader::load_app_model('platform_account_model', 'platform');
        $row = $db_platform_command->where(array('uuid' => $this->uuid))->find();
        if (empty($row)) {
            return new ecjia_error('platform_not_found_uuid', RC_Lang::get('platform::platform.unidentification_uuid'));
        }
        return $row;
    }
    
    public function getAccountID() {
        if (is_ecjia_error($this->row)) {
            return $this->row;
        }
        return $this->row['id'];
    }
    
    public function getAccountName() {
        if (is_ecjia_error($this->row)) {
            return $this->row;
        }
        return $this->row['name'];
    }
    
    /**
     * 获取当前帐号的基本信息
     * @return unknown|multitype:unknown
     */
    public function getAccount() {
        if (is_ecjia_error($this->row)) {
            return $this->row;
        }
        
        $data = array(
            'uuid'      => $this->row['uuid'],
            'name'      => $this->row['name'],
            'type'      => $this->row['type'],
            'token'     => $this->row['token'],
            'appid'     => $this->row['appid'],
            'appsecret' => $this->row['appsecret'],
            'aeskey'    => $this->row['aeskey'],
        );
        return $data;
    }
    
    /**
     * 获取当前帐号的状态
     * @return unknown|boolean
     */
    public function getStatus() {
        if (is_ecjia_error($this->row)) {
            return $this->row;
        }
        
        if ($this->row['status']) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 获取当前帐号的平台类型
     */
    public function getPlatform() {
        if (is_ecjia_error($this->row)) {
            return $this->row;
        }
        
        return $this->row['platform'];
    }
    
    /**
     * 获取指定平台的公众号列表
     * @param string $platform
     */
    public static function getAccountList($platform, $shopid = 0) {
        $db_platform_account = RC_Loader::load_app_model('platform_account_model', 'platform');
        $accountlist = $db_platform_account->where(array('platform' => $platform, 'shop_id' => $shopid, 'status'=>1))->order('sort DESC, id DESC')->select();
        return $accountlist;
    }
    
    /**
     * 判断UUID是否属于账号的
     * @param string $platform
     * @param string $uuid
     * @param number $shopid
     * @return boolean
     */
    public static function hasAccountUUID($platform, $uuid, $shopid = 0) {
    	$account_list = self::getAccountList($platform, $shopid);
		if(!empty($account_list)) {
			foreach ($account_list as $item => $val) {
				$uuids[] = $val['uuid'];
			}
			if (in_array($uuid, $uuids)) {
				return true;
			}
			return false;
		}
    }
    
    /**
     * 获取当前选择的公众号列表
     * @param string $platform
     */
    public static function getCurrentUUID($platform, $shopid = 0) {
        $db = RC_Loader::load_model('term_meta_model');
        $meta_key       = $platform . '_current_account';
        $object_type    = 'ecjia.system';
        $object_group   = 'admin_user';
        $object_id      = $_SESSION['admin_id'];
        
        $data = array(
            'object_id'     => $object_id,
            'object_type'   => $object_type,
            'object_group'  => $object_group,
            'meta_key'      => $meta_key,
        );
        $row = $db->where($data)->find();
        if ($row) {
            $uuid = $row['meta_value'];
            if (self::hasAccountUUID($platform, $uuid, $shopid)) {
            	return $uuid;
            }
        }
       
        $accountlist = self::getAccountList($platform, $shopid);
        $uuid = $accountlist[0]['uuid'];
        self::setCurrentUUID($platform, $uuid);
        return $uuid;
    }
    
    /**
     * 切换当前公众号
     * @param string $platform
     * @param string $uuid
     */
    public static function setCurrentUUID($platform, $uuid) {
    	if (!$_SESSION['admin_id']) {
    		return new ecjia_error('is_not_admin_id', RC_Lang::get('platform::platform.must_root_operation'));
    	}
        $db = RC_Loader::load_model('term_meta_model');
        $meta_key       = $platform . '_current_account';
        $object_type    = 'ecjia.system';
        $object_group   = 'admin_user';
        $object_id      = $_SESSION['admin_id'];
        
        $data = array(
            'object_id'     => $object_id,
            'object_type'   => $object_type,
            'object_group'  => $object_group,
            'meta_key'      => $meta_key,
        );
        $row = $db->where($data)->find();
        
        if ($row && $uuid) {
            $where_data = array(
                'meta_id'     => $row['meta_id'],
            );
            $update_data = array(
                'meta_value'    => $uuid,
            );
            $db->where($where_data)->update($update_data);
        } else {
            $data = array(
                'object_id'     => $object_id,
                'object_type'   => $object_type,
                'object_group'  => $object_group,
                'meta_key'      => $meta_key,
                'meta_value'    => $uuid,
            );
            $db->insert($data);
        }
        
    }
    
    public static function getAccountSwtichDisplay($platform, $shopid = 0) {
        $account_list = platform_account::getAccountList($platform, $shopid);
        $current_uuid = platform_account::getCurrentUUID($platform, $shopid);
        
        echo <<<EOF
        <div>
        <div class="btn-group">
EOF;
        
        if (empty($account_list)) {
            echo '<button data-toggle="dropdown" class="btn dropdown-toggle">请先添加公众号 <span class="caret"></span></button>';
        } else {
        	$new_account_list = array();
            foreach ($account_list as $item => $val) {
                $new_account_list[$val['uuid']] = $val;
            }
            $uuids = array_keys($new_account_list);
            if (in_array($current_uuid, $uuids)) {
            	echo '<button data-toggle="dropdown" class="btn dropdown-toggle">' . $new_account_list[$current_uuid]['name'] . ' <span class="caret"></span></button>';
            } else {
            	echo '<button data-toggle="dropdown" class="btn dropdown-toggle">请先选择公众号 <span class="caret"></span></button>';
            }
        }

		echo <<<EOF
			<ul class="dropdown-menu">
EOF;
        
        foreach ($account_list as $item => $val) {
            if ($val['uuid'] == $current_uuid) {
                $url = RC_Uri::url('platform/admin_switch/init', array('platform' => $platform, 'uuid' => $val['uuid']));
                echo '<li><a>' . $val['name'] . ' <i class=" fontello-icon-ok"></i></a></li>';
            } else {
                $url = RC_Uri::url('platform/admin_switch/init', array('platform' => $platform, 'uuid' => $val['uuid']));
                echo '<li><a class="ajaxswitch" href="' . $url . '">' . $val['name'] . '</a></li>';
            }
        }
        
        if (!empty($account_list)) {
            echo '<li class="divider"></li>';
        }

        $list_url = RC_Uri::url('platform/admin/init');
        $add_url = RC_Uri::url('platform/admin/add');
        
		echo <<<EOF
				<li><a href="{$list_url}" target="_blank">公众号管理</a></li>
				<li><a href="{$add_url}" target="_blank">添加公众号</a></li>
			</ul>
		</div>	
    </div>
	<br>
EOF;

    }
}

// end