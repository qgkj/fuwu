<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/* 会员整合相关常数 */
define('ERR_USERNAME_EXISTS',       1); // 用户名已经存在
define('ERR_EMAIL_EXISTS',          2); // Email已经存在
define('ERR_INVALID_USERID',        3); // 无效的user_id
define('ERR_INVALID_USERNAME',      4); // 无效的用户名
define('ERR_INVALID_PASSWORD',      5); // 密码错误
define('ERR_INVALID_EMAIL',         6); // email错误
define('ERR_USERNAME_NOT_ALLOW',    7); // 用户名不允许注册
define('ERR_EMAIL_NOT_ALLOW',       8); // EMAIL不允许注册

// end