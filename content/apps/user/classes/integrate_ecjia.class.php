<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 会员数据处理类
 */
RC_Loader::load_app_class('integrate_abstract', 'user', false);

class integrate_ecjia extends integrate_abstract {
    
    protected $is_ecjia = 1;
    
    public function __construct($cfg) {
		parent::__construct($cfg);
		
		$this->user_table 		= 'users';
		$this->field_id 		= 'user_id';
		$this->ec_salt 			= 'ec_salt';
		$this->field_name 		= 'user_name';
		$this->field_pass 		= 'password';
		$this->field_email 		= 'email';
		$this->field_gender 	= 'sex';
		$this->field_bday 		= 'birthday';
		$this->field_reg_date 	= 'reg_time';
		$this->need_sync 		= false;
		$this->is_ecjia 		= 1;	
    }


    /**
     *  编译密码函数
     *
     * @access  public
     * @param   array   $cfg 包含参数为 $password, $md5password, $salt, $type
     *
     * @return void
     */
    public function compile_password($cfg) {
    	if (isset($cfg['password'])) {
    		$cfg['md5password'] = md5($cfg['password']);
    	}
    	if (empty($cfg['type'])) {
    		$cfg['type'] = PWD_MD5;
    	}
    
    	switch ($cfg['type']) {
    		case PWD_MD5 :
    			if(!empty($cfg['ec_salt'])) {
    				return md5($cfg['md5password'] . $cfg['ec_salt']);
    			} else {
    				return $cfg['md5password'];
    			}
    
    		case PWD_PRE_SALT :
    			if (empty($cfg['salt'])) {
    				$cfg['salt'] = '';
    			}
       			return md5($cfg['salt'] . $cfg['md5password']);
    
    		case PWD_SUF_SALT :
    			if (empty($cfg['salt'])) {
    				$cfg['salt'] = '';
    			}
    			return md5($cfg['md5password'] . $cfg['salt']);
    
    		default:
    			return '';
    	}
    }
    
    /**
     *  检查指定用户是否存在及密码是否正确(重载基类check_user函数，支持zc加密方法)
     *
     * @access  public
     * @param   string  $username   用户名
     *
     * @return  int
     */
    function check_user($username, $password = null) {
    	$post_username = $username;
    	 
        if ($password === null) {
			$user_id = $this->db->where(array('user_name' => $post_username))->get_field('user_id');
        	return  $user_id;
        } else {
        	$row 	 = $this->db->field('user_id, password, salt,ec_salt')->find(array('user_name' => $post_username));
			$ec_salt = $row['ec_salt'];
            if (empty($row)) {
                return 0;
            }

            if (empty($row['salt'])) {
                if ($row['password'] != $this->compile_password(array('password' => $password,'ec_salt' => $ec_salt))) {
                    return 0;
                } else {
					if (empty($ec_salt)) {
						$ec_salt = rand(1,9999);
						$new_password = md5(md5($password) . $ec_salt);
						$data = array(
								'password' => $new_password,
								'ec_salt'  => $ec_salt
						);
						$this->db->where(array('user_name' => $post_username))->update($data);
					}
                    return $row['user_id'];
                }
            } else {
                /* 如果salt存在，使用salt方式加密验证，验证通过洗白用户密码 */
                $encrypt_type = substr($row['salt'], 0, 1);
                $encrypt_salt = substr($row['salt'], 1);

                /* 计算加密后密码 */
                $encrypt_password = '';
                switch ($encrypt_type) {
                    case ENCRYPT_ZC :
                        $encrypt_password = md5($encrypt_salt.$password);
                        break;
                   
                    case ENCRYPT_UC :
                        $encrypt_password = md5(md5($password).$encrypt_salt);
                        break;

                    default:
                        $encrypt_password = '';

                }

                if ($row['password'] != $encrypt_password) {
                    return 0;
                }

                $data = array(
                		'password' 	=> $this->compile_password(array('password' => $password)),
                		'salt'  	=> ''
                );
                $this->db->where(array('user_id' => $row['user_id']))->update($data);

                return $row['user_id'];
            }
        }
    }
}

// end