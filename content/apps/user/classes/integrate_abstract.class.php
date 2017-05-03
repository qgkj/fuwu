<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJia 整合插件类的基类
 */
abstract class integrate_abstract
{

    /*------------------------------------------------------ */
    //-- PUBLIC ATTRIBUTEs
    /*------------------------------------------------------ */

    /* 整合对象使用的数据库主机 */
    public $db_host                 = '';

    /* 整合对象使用的数据库名 */
    public $db_name                 = '';

    /* 整合对象使用的数据库用户名 */
    public $db_user                 = '';

    /* 整合对象使用的数据库密码 */
    public $db_pass                 = '';

    /* 整合对象数据表前缀 */
    public $prefix                  = '';

    /* 数据库所使用编码 */
    public $charset                 = '';

    /* 整合对象使用的cookie的domain */
    public $cookie_domain           = '';

    /* 整合对象使用的cookie的path */
    public $cookie_path             = '/';

    /* 整合对象会员表名 */
    public $user_table              = '';

    /* 会员ID的字段名 */
    public $field_id                = '';

    /* 会员名称的字段名 */
    public $field_name              = '';

    /* 会员密码的字段名 */
    public $field_pass              = '';

    /* 会员邮箱的字段名 */
    public $field_email             = '';

    /* 会员性别 */
    public $field_gender            = '';

    /* 会员生日 */
    public $field_bday              = '';

    /* 注册日期的字段名 */
    public $field_reg_date          = '';

    /* 是否需要同步数据到商城 */
    public $need_sync               = true;

    public $error                   = 0;

    /*------------------------------------------------------ */
    //-- PRIVATE ATTRIBUTEs
    /*------------------------------------------------------ */

    protected $db;

    /*------------------------------------------------------ */
    //-- PUBLIC METHODs
    /*------------------------------------------------------ */
    
    /**
     * 会员数据整合插件类的构造函数
     *
     * @access      public
     * @param       string  $db_host    数据库主机
     * @param       string  $db_name    数据库名
     * @param       string  $db_user    数据库用户名
     * @param       string  $db_pass    数据库密码
     * @return      void
     */
    public function __construct($cfg)
    {
        RC_Loader::load_app_config('constant', 'user', false);
        
        $this->charset 			= isset($cfg['db_charset'])    ? $cfg['db_charset']       : 'UTF8';
        $this->prefix 			= isset($cfg['prefix'])        ? $cfg['prefix']           : '';
        $this->db_name 			= isset($cfg['db_name'])       ? $cfg['db_name']          : '';
        $this->cookie_domain 	= isset($cfg['cookie_domain']) ? $cfg['cookie_domain']    : '';
        $this->cookie_path 		= isset($cfg['cookie_path'])   ? $cfg['cookie_path']      : '/';
        $this->need_sync 		= true;
        $this->user_table       = 'users';

        $quiet = empty($cfg['quiet']) ? 0 : 1;

        /* 初始化数据库 */
        $this->db = RC_Model::model('user/'.$this->user_table . '_model');
        
    }

    /**
     *  用户登录函数
     *
     * @access  public
     * @param   string  $username
     * @param   string  $password
     *
     * @return void
     */
    public function login($username, $password, $remember = null)
    {
        if ($this->check_user($username, $password) > 0) {
            if ($this->need_sync) {
                $this->sync($username,$password);
            }
            $this->set_session($username);
            $this->set_cookie($username, $remember);

            return true;
        } else {
            return false;
        }
    }

    /**
     *
     *
     * @access  public
     * @param
     *
     * @return void
     */
    public function logout()
    {
        $this->set_cookie(); //清除cookie
        $this->set_session(); //清除session
    }

    /**
     *  添加一个新用户
     *
     * @access  public
     * @param
     *
     * @return int
     */
    public function add_user($username, $password, $email, $gender = -1, $bday = 0, $reg_date = 0, $md5password = '')
    {
    	/* 将用户添加到整合方 */
        if ($this->check_user($username) > 0) {
            $this->error = new ecjia_error('ERR_USERNAME_EXISTS', RC_Lang::get('user::users.username_exists'));
            return false;
        }
        
        /* 检查email是否重复 */
        $query = $this->db->field($this->field_id)->find(array($this->field_email => $email));
        if ($query[$this->field_id] > 0) {
            $this->error = new ecjia_error('ERR_EMAIL_EXISTS', RC_Lang::get('user::users.email_exists'));
            return false;
        }

        $post_username = $username;

        if ($md5password) {
            $post_password = $this->compile_password(array('md5password' => $md5password));
        } else {
            $post_password = $this->compile_password(array('password' => $password));
        }

        $fields = array($this->field_name, $this->field_email, $this->field_pass);
        $values = array($post_username, $email, $post_password);

        if ($gender > -1) {
            $fields[] = $this->field_gender;
            $values[] = $gender;
        }
        
        if ($bday) {
            $fields[] = $this->field_bday;
            $values[] = $bday;
        }
        
        if ($reg_date) {
            $fields[] = $this->field_reg_date;
            $values[] = $reg_date;
        }

        $data = array_combine($fields, $values);
        $this->db->insert($data);

        if ($this->need_sync) {
            $this->sync($username, $password);
        }

        return true;
    }

    /**
     *  编辑用户信息($password, $email, $gender, $bday)
     *
     * @access  public
     * @param
     *
     * @return void
     */
    public function edit_user($cfg)
    {
        if (empty($cfg['username'])) {
            return false;
        } else {
            $cfg['post_username'] = $cfg['username'];
        }

        $values = array();
        if (!empty($cfg['password']) && empty($cfg['md5password'])) {
            $cfg['md5password'] = md5($cfg['password']);
        }
        if ((!empty($cfg['md5password'])) && $this->field_pass != 'NULL') {
            $values[$this->field_pass] = $this->compile_password(array('md5password' => $cfg['md5password']));
        }

        if ((!empty($cfg['email'])) && $this->field_email != 'NULL') {
            /* 检查email是否重复 */
        	$query = $this->db->field($this->field_id)->find(array($this->field_email => $cfg['email'], $this->field_name => array('neq' => $cfg['post_username'])));
            if ($query[$this->field_id] > 0) {
                $this->error = ERR_EMAIL_EXISTS;
                return false;
            }
            // 检查是否为新E-mail
            $count = $this->db->where(array($this->field_email => $cfg['email']))->count();
            if ($count == 0) {
                // 新的E-mail
            	$this->db->where(array('user_name' => $cfg['post_username']))->update(array('is_validated' => 0));
            }
            $values[$this->field_email] = $cfg['email'];
        }

        if (isset($cfg['gender']) && $this->field_gender != 'NULL') {
            $values[$this->field_gender] = $cfg['gender'];
        }

        if ((!empty($cfg['bday'])) && $this->field_bday != 'NULL') {
            $values[$this->field_bday] = $cfg['bday'];
        }

        if ($values) {
        	$this->db->where(array($this->field_name => $cfg['post_username']))->update($values);

            if ($this->need_sync) {
                if (empty($cfg['md5password'])) {
                    $this->sync($cfg['username']);
                } else {
                    $this->sync($cfg['username'], '', $cfg['md5password']);
                }
            }
        }

        return true;
    }

    /**
     * 删除用户
     *
     * @access  public
     * @param
     *
     * @return void
     */
    public function remove_user($id)
    {
        $post_id = $id;
        
        $db_order_info      = RC_Model::model('orders/order_info_model');
        $db_order_goods     = RC_Model::model('orders/order_goods_model');
        $db_collect_goods   = RC_Model::model('goods/collect_goods_model');
        $db_user_address    = RC_Model::model('user/user_address_model');
        $db_user_bonus      = RC_Model::model('bonus/user_bonus_model');
        $db_user_account    = RC_Model::model('user/user_account_model');
        
        $db_account_log     = RC_Model::model('user/account_log_model');
        

        /* 如果需要同步或是ecjia插件执行这部分代码 */
        if ($this->need_sync || (isset($this->is_ecjia) && $this->is_ecjia)) {
            if (is_array($post_id)) {
            	$col = $this->db->in(array('user_id' => $post_id))->get_field('user_id', true);
            } else {
                $col = $this->db->field('user_id')->where(array('user_name' => $post_id))->find();
            }

            if ($col) {
            	
                //将删除用户的下级的parent_id 改为0
            	$this->db->in(array('parent_id' => $col))->update(array('parent_id' => 0));
            	//删除用户
            	$this->db->in(array('user_id' => $col))->delete();
                /* 删除用户订单 */
            	$col_order_id = $db_order_info->in(array('user_id' => $col))->get_field('order_id', true);
                if ($col_order_id) {
                	$db_order_info->in(array('order_id' => $col_order_id))->delete();
                	$db_order_goods->in(array('order_id' => $col_order_id))->delete();
                }

                //删除会员收藏商品
                $db_collect_goods->in(array('user_id' => $col))->delete();
                //删除用户留言
//                 $db_feedback->in(array('user_id' => $col))->delete();
                //删除用户地址
                $db_user_address->in(array('user_id' => $col))->delete();
                //删除用户红包
                $db_user_bonus->in(array('user_id' => $col))->delete();
                //删除用户帐号金额
                $db_user_account->in(array('user_id' => $col))->delete();
                //删除用户标记
//                 $db_tag->in(array('user_id' => $col))->delete();
                //删除用户日志
                $db_account_log->in(array('user_id' => $col))->delete();
                
                RC_Api::api('connect', 'connect_user_remove', array('user_id' => $col, 'is_admin' => 0));
            }
        }
        
        /* 如果是ecjia插件直接退出 */
        if (isset($this->ecjia) && $this->ecjia) {
            return;
        }

        if (is_array($post_id)) {
            $this->db->in(array($this->field_id => $post_id))->delete();
        } else {
        	$this->db->where(array($this->field_name => $post_id))->delete();
        }
    }

    /**
     *  获取指定用户的信息
     *
     * @access  public
     * @param
     *
     * @return void
     */
    public function get_profile_by_name($username)
    {
        $row = $this->db->field("$this->field_id AS `user_id`, $this->field_name AS `user_name`, $this->field_email AS `email`, $this->field_gender AS `sex`, $this->field_bday AS `birthday`, $this->field_reg_date AS `reg_time`, $this->field_pass AS `password`")->find(array($this->field_name => $username));
        return $row;
    }

    /**
     *  获取指定用户的信息
     *
     * @access  public
     * @param
     *
     * @return void
     */
    public function get_profile_by_id($id)
    {
    	$row = $this->db->field("$this->field_id AS `user_id`, $this->field_name AS `user_name`, $this->field_email AS `email`, $this->field_gender AS `sex`, $this->field_bday AS `birthday`, $this->field_reg_date AS `reg_time`, $this->field_pass AS `password`, `passwd_question`")->find(array($this->field_id => $id));
        return $row;
    }

    /**
     *  根据登录状态设置cookie
     *
     * @access  public
     * @param
     *
     * @return void
     */
    public function get_cookie()
    {
        $id = $this->check_cookie();
        if ($id) {
            if ($this->need_sync) {
                $this->sync($id);
            }
            $this->set_session($id);
            return true;
        } else {
            return false;
        }
    }

    /**
     *  检查指定用户是否存在及密码是否正确
     *
     * @access  public
     * @param   string  $username   用户名
     *
     * @return  int
     */
    public function check_user($username, $password = null)
    {
        $post_username = $username;

        /* 如果没有定义密码则只检查用户名 */
        if ($password === null) {
        	return $this->db->field($this->field_id)->find(array($this->field_name => $post_username));
        } else {
        	return $this->db->field($this->field_id)->find(array($this->field_name => $post_username, $this->field_pass => $this->compile_password(array('password' => $password))));
        }
    }

    /**
     *  检查指定邮箱是否存在
     *
     * @access  public
     * @param   string  $email   用户邮箱
     *
     * @return  boolean
     */
    public function check_email($email)
    {
        if (!empty($email)) {
            /* 检查email是否重复 */
            $result = $this->db->field($this->field_id)->find(array($this->field_email => $email));
	        if($result[$this->field_id] > 0) {
                $this->error = ERR_EMAIL_EXISTS;
                return true;
            }
            return false;
        }
    }


    /**
     *  检查cookie是正确，返回用户名
     *
     * @access  public
     * @param
     *
     * @return void
     */
    public function check_cookie()
    {
        return '';
    }

    /**
     *  设置cookie
     *
     * @access  public
     * @param
     *
     * @return void
     */
    public function set_cookie($username = '', $remember = null )
    {
    	if (empty($username)) {
            /* 摧毁cookie */
            $time = time() - 3600;
            setcookie("ECJIA[user_id]",  '', $time, $this->cookie_path);            
            setcookie("ECJIA[password]", '', $time, $this->cookie_path);

        } elseif ($remember) {
            /* 设置cookie */
            $time = time() + 3600 * 24 * 15;
            setcookie("ECJIA[username]", $username, $time, $this->cookie_path, $this->cookie_domain);
            
            $row = $this->db->field('user_id, password')->find(array('user_name' => $username));
            if ($row) {
                setcookie("ECJIA[user_id]", $row['user_id'], $time, $this->cookie_path, $this->cookie_domain);
                setcookie("ECJIA[password]", $row['password'], $time, $this->cookie_path, $this->cookie_domain);
            }
        }
    }

    /**
     *  设置指定用户SESSION
     *
     * @access  public
     * @param
     *
     * @return void
     */
    public function set_session ($username='')
    {
        if (empty($username)) {
            RC_Session::destroy();
        } else {
        	$row = $this->db->field('user_id, password, email')->find(array('user_name' => $username));
            if ($row) {
                $_SESSION['user_id']   = $row['user_id'];
                $_SESSION['user_name'] = $username;
                $_SESSION['email']     = $row['email'];
            }
        }
    }


    /**
     * 在给定的表名前加上数据库名以及前缀
     *
     * @access  private
     * @param   string      $str    表名
     *
     * @return void
     */
    public function table($str)
    {
        return '`' .$this->db_name. '`.`'.$this->prefix.$str.'`';
    }

    /**
     *  编译密码函数
     *
     * @access  public
     * @param   array   $cfg 包含参数为 $password, $md5password, $salt, $type
     *
     * @return void
     */
    public function compile_password ($cfg)
    {
        if (isset($cfg['password'])) {
            $cfg['md5password'] = md5($cfg['password']);
        }
       
        if (empty($cfg['type'])) {
            $cfg['type'] = PWD_MD5;
        }

        $password = '';
        switch ($cfg['type']) {
            case PWD_MD5 :
                if (!empty($cfg['ec_salt'])) {
                    $password = md5($cfg['md5password'] . $cfg['ec_salt']);
                } else {
                    $password = $cfg['md5password'];
                }
                break;
            case PWD_PRE_SALT :
                if (empty($cfg['salt'])) {
                    $cfg['salt'] = '';
                }
                
                $password = md5($cfg['salt'] . $cfg['md5password']);
                break;
                
           case PWD_SUF_SALT :
                if (empty($cfg['salt'])) {
                    $cfg['salt'] = '';
                }

                $password = md5($cfg['md5password'] . $cfg['salt']);
                break;
           default:
               break;
       }
       
       return $password;
    }

    /**
     *  会员同步
     *
     * @access  public
     * @param
     *
     * @return void
     */
    public function sync ($username, $password='', $md5password='')
    {
    	
        if ((!empty($password)) && empty($md5password)) {
            $md5password = md5($password);
        }

        $main_profile = $this->get_profile_by_name($username);

        if (empty($main_profile)) {
            return false;
        }

        $profile = $this->db->field('user_name, email, password, sex, birthday')->find(array('user_name' => $username));
        if (empty($profile)) {
            /* 向商城表插入一条新记录 */
            if (empty($md5password)) {
            	$data = array(
            			'user_name'  => $username,
            			'email'      => $main_profile['email'],
            			'sex'        => $main_profile['sex'],
            			'birthday'   => $main_profile['birthday'] ,
            			'reg_time'   => $main_profile['reg_time'],
            	);
            	$this->db->insert($data);
            } else {
            	$data = array(
            			'user_name'  => $username,
            			'email'      => $main_profile['email'],
            			'sex'        => $main_profile['sex'],
            			'birthday'   => $main_profile['birthday'] ,
            			'reg_time'   => $main_profile['reg_time'],
            			'password'   => $md5password
            	);
            	$this->db->insert($data);

            }
            return true;
        } else {
            $values = array();
            if ($main_profile['email'] != $profile['email']) {
                $values['email'] = $main_profile['email'];
            }
            
            if ($main_profile['sex'] != $profile['sex']) {
                $values['sex'] = $main_profile['sex'];
            }
            
            if ($main_profile['birthday'] != $profile['birthday']) {
                $values['birthday'] = $main_profile['birthday'];
            }
            
            if ((!empty($md5password)) && ($md5password != $profile['password'])) {
                $values['password'] = $md5password;
            }

            if (empty($values)) {
                return  true;
            } else {
                $this->db->where(array('user_name' => $username))->update($values);
                return true;
            }
        }
    }

    /**
     *  获取论坛有效积分及单位
     *
     * @access  public
     * @param
     *
     * @return void
     */
    public function get_points_name ()
    {
        return array();
    }

    /**
     *  获取用户积分
     *
     * @access  public
     * @param
     *
     * @return void
     */
    public function get_points($username)
    {
        $credits = $this->get_points_name();
        $fileds = array_keys($credits);
        if ($fileds) {
        	$row = $this->db->field($this->field_id, implode(', ',$fileds))->find(array($this->field_name => $username));
            return $row;
        } else {
            return false;
        }
    }

    /**
     *设置用户积分
     *
     * @access  public
     * @param
     *
     * @return void
     */
    public function set_points ($username, $credits)
    {
        $user_set = array_keys($credits);
        $points_set = array_keys($this->get_points_name());

        $set = array_intersect($user_set, $points_set);

        if ($set) {
            $tmp = array();
            foreach ($set as $credit) {
               $tmp[$credit] = $credit + $credits[$credit];
            }
            $this->db->where(array($this->field_name => $username))->update($tmp);
        }

        return true;
    }

    public function get_user_info($username)
    {
        return $this->get_profile_by_name($username);
    }


    /**
     * 检查有无重名用户，有则返回重名用户
     *
     * @access  public
     * @param
     *
     * @return void
     */
    public function test_conflict ($user_list)
    {
        if (empty($user_list)) {
            return array();
        }
        
        $user_list = $this->db->field($this->field_name)->in(array($this->field_name => $user_list))->select();
        return $user_list;
    }
}

// end