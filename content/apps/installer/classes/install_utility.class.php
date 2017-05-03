<?php
  
use Royalcms\Component\Database\Connection;
use Royalcms\Component\Database\QueryException;
use Royalcms\Component\Support\Facades\File as RC_File;

defined('IN_ECJIA') or exit('No permission resources.');
class install_utility 
{
    
    const DB_CHARSET = 'utf8mb4';
    
    /**
     * 获得服务器所在时区
     *
     * @access  public
     * @return  string     返回时区串，形如Asia/Shanghai
     */
    public static function getLocalTimezone() 
    {
        $local_timezone = date_default_timezone_get();
        return $local_timezone;
    }
    
    /**
     * 获得时区列表，如有重复值，只保留第一个
     *
     * @access  public
     * @return  array
     */
    public static function getTimezones($lang) 
    {
        $timezones = RC_Package::package('app::installer')->loadConfig('timezones_zh_CN');
        return array_unique($timezones);
    }
    
    /**
     * 获得数据库列表
     *
     * @access  public
     * @param   string      $host        主机
     * @param   string      $port        端口号
     * @param   string      $user        用户名
     * @param   string      $pass        密码
     * @return  mixed       成功返回数据库列表组成的数组，失败返回false
     */
    public static function getDataBases($host, $port, $user, $pass)
    {
        $conn = self::createDatabaseConnection($host, $port, $user, $pass);
        if (is_ecjia_error($conn)) {
        	return new ecjia_error('connect_failed', RC_Lang::get('installer::installer.connect_failed'));
        }
        $r = $conn->select("SHOW DATABASES");
        return collect($r)->lists('Database');
    }
    
    /**
     * 创建数据库连接
     *
     * @access  public
     * @param   string      $host        主机
     * @param   string      $port        端口号
     * @param   string      $user        用户名
     * @param   string      $pass        密码
     * @return  Royalcms\Component\Database\Connection       成功返回数据库连接对象，失败返回false
     */
    public static function createDatabaseConnection($host, $port, $user, $pass, $database = null)
    {
        try {
        
            $dsn = "mysql:host=$host;port=$port";
            if ($database) {
                $dsn .= ";dbname=$database";
            }
            $db = new \PDO($dsn, $user, $pass);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return new Connection($db);
        
        } catch (PDOException $e) {
            
            return new ecjia_error('connect_failed', RC_Lang::get('installer::installer.connect_failed'));
        }
    }
    
    /**
     * 创建指定名字的数据库
     *
     * @access  public
     * @param   string      $host        主机
     * @param   string      $port        端口号
     * @param   string      $user        用户名
     * @param   string      $pass        密码
     * @param   string      $database    数据库名
     * @return  boolean     成功返回true，失败返回false
     */
    public static function createDatabase($host, $port, $user, $pass, $database) 
    {
        try {
            
            $conn = self::createDatabaseConnection($host, $port, $user, $pass);
            if (is_ecjia_error($conn)) {
            	return new ecjia_error('connect_failed', RC_Lang::get('installer::installer.connect_failed'));
            }
            $result = $conn->unprepared("CREATE DATABASE `$database`");
            return true;
            
        } catch (QueryException $e) {
            return new ecjia_error('cannt_create_database', RC_Lang::get('installer::installer.cannt_create_database'));
        }      
        
    }
    
    public static function createInstallConnection() 
    {
        $db_host = env('DB_HOST');
        $db_user = env('DB_USERNAME');
        $db_pass = env('DB_PASSWORD');
        $db_name = env('DB_DATABASE');
        $db_port = env('DB_PORT', 3306);
        $prefix = env('DB_PREFIX');

        $conn = self::createDatabaseConnection($db_host, $db_port, $db_user, $db_pass, $db_name);
        if (is_ecjia_error($conn)) {
            return $conn;
        }
        
        $conn->setTablePrefix($prefix);

        return $conn;
    }

    /**
     * 创建管理员帐号
     *
     * @access  public
     * @param   string      $admin_name
     * @param   string      $admin_password
     * @param   string      $admin_password2
     * @param   string      $admin_email
     * @return  boolean     成功返回true，失败返回false
     */
    public static function createAdminPassport($admin_name, $admin_password, $admin_password2, $admin_email) 
    {
        if ($admin_name === '') {
            return new ecjia_error('username_error', RC_Lang::get('installer::installer.username_error'));
        }
        
        if ($admin_password === '') {
            return new ecjia_error('password_empty_error', RC_Lang::get('installer::installer.password_empty_error'));
        }
        
        if (!(strlen($admin_password) >= 8 && preg_match("/\d+/",$admin_password) && preg_match("/[a-zA-Z]+/",$admin_password))) {
            return new ecjia_error('js_languages_password_invaild', RC_Lang::get('installer::installer.js_languages.password_invaild'));
        }

        $nav_list = join(',', RC_Lang::get('installer::installer.admin_user'));

        try {
            $conn = self::createInstallConnection();
            if (is_ecjia_error($conn))
            {
                return $conn;
            }
            
            $data = array(
            	'user_name'     => $admin_name,
                'email'         => $admin_email,
                'password'      => md5($admin_password),
                'add_time'      => RC_Time::gmtime(),
                'action_list'   => 'all',
                'nav_list'      => $nav_list
            );
            
            return RC_DB::table('admin_user')->insert($data);
            
        } catch (QueryException $e) {
            return new ecjia_error('create_passport_failed', RC_Lang::get('installer::installer.create_passport_failed').'【'.$e->getMessage().'】');
        }
    }
    
    /**
     * 修改.env文件
     * @param array $data
     * @return string|unknown|ecjia_error
     */
    public static function modifyEnv(array $data) 
    {
        try {
            $envPath = base_path() . DIRECTORY_SEPARATOR . '.env';

            $contentArray = collect(file($envPath, FILE_IGNORE_NEW_LINES));
        
            $contentArray->transform(function ($item) use ($data){
                foreach ($data as $key => $value) {
                    if (str_contains($item, $key)) {
                        return $key . '=' . $value;
                    }
                }
        
                return $item;
            });
        
            $content = implode($contentArray->toArray(), "\n");

            return RC_File::put($envPath, $content);
            
        } catch (Exception $e) {
            return new ecjia_error('write_config_file_failed', RC_Lang::get('installer::installer.write_config_file_failed'));
        }
        
    }
    
    /**
     * 创建.env文件
     */
    public static function createEnv()
    {
        $envExamplePath = DATA_PATH . 'env.example';
        $envPath = base_path() . DIRECTORY_SEPARATOR . '.env';
        
        if (RC_File::exists($envExamplePath)) {
            RC_File::copy($envExamplePath, $envPath);
        }
    }
    
    /**
     * 安装数据
     *
     * @access  public
     * @param   array         $sql_files        SQL文件路径组成的数组
     * @return  boolean       成功返回true，失败返回false
     */
    public static function installData($sql_files) 
    {
        RC_Package::package('app::installer')->loadClass('sql_query', false);
        
        $prefix = env('DB_PREFIX');
        
        $conn = self::createInstallConnection();
        if (is_ecjia_error($conn)) {
        	return $conn;
        }
        $sql_query = new sql_query($conn, self::DB_CHARSET, 'ecjia_', $prefix);
        
        $result = $sql_query->runAll($sql_files);
        if ($result === false) {
            return $sql_query->getError();
        }
        return true;
    }
    
    /**
     * 更新 ECJIA 安装日期
     * @return ecjia_error
     */
    public static function updateInstallDate()
    {
        try {
            return RC_DB::table('shop_config')->where('code', 'install_date')->update(array('value'=>RC_Time::gmtime()));
        } catch (QueryException $e) {
            return new ecjia_error($e->getCode(), $e->getMessage());
        }
    }
    
    /**
     * 更新 ECJIA 版本
     * @return ecjia_error
     */
    public static function updateEcjiaVersion()
    {
        try {
            return RC_DB::table('shop_config')->where('code', 'ecjia_version')->update(array('value'=>VERSION));
        } catch (QueryException $e) {
            return new ecjia_error($e->getCode(), $e->getMessage());
        }
    }
    
    /**
     * 写入 hash_code，做为网站唯一性密钥
     * @return ecjia_error
     */
    public static function updateHashCode()
    {
        $dbhash = md5(SITE_ROOT . env('DB_HOST') . env('DB_USERNAME') . env('DB_PASSWORD') . env('DB_DATABASE'));
        $hash_code = md5(md5(time()) . md5($dbhash) . md5(time()));
        
        $data = array(
        	'shop_url' => RC_Uri::home_url(),
            'hash_code' => $hash_code,
            'ip' => RC_Ip::server_ip(),
            'shop_type' => RC_Config::get('site.shop_type'),
            'version' => RC_Config::get('release.version'),
            'release' => RC_Config::get('release.build'),
            'language' => RC_Config::get('system.locale'),
            'charset' => 'utf-8',
            'php_ver' => PHP_VERSION,
            'mysql_ver' => self::getMysqlVersionByConnection(RC_DB::connection()),
            'ecjia_version' => VERSION,
            'ecjia_release' => RELEASE,
            'royalcms_version' => \Royalcms\Component\Foundation\Royalcms::VERSION,
            'royalcms_release' => \Royalcms\Component\Foundation\Royalcms::RELEASE,
        );
        ecjia_cloud::instance()->api('product/analysis/install')->data($data)->run();
        
        try {
            return RC_DB::table('shop_config')->where('code', 'hash_code')->update(array('value'=>$hash_code));
        } catch (QueryException $e) {
            return new ecjia_error($e->getCode(), $e->getMessage());
        }
    }
    
    /**
     * 更新PC内嵌的H5地址
     */
    public static function updateDemoApiUrl()
    {
        try {
            $url = RC_Uri::home_url() . '/sites/m/';
            
            return RC_DB::table('shop_config')->where('code', 'mobile_touch_url')->update(array('value'=>$url));
        } catch (QueryException $e) {
            return new ecjia_error($e->getCode(), $e->getMessage());
        }
    }
    
    /**
     * 创建存储目录
     */
    public static function createStorageDirectory()
    {
        $dirs = RC_Package::package('app::installer')->loadConfig('checking_dirs');
        collect($dirs)->map(function ($dir) {
            if (!RC_File::isDirectory($dir)) {
                RC_File::makeDirectory($dir);
            }
        });
    }
    
    
    /**
     * 写入安装锁定文件
     */
    public static function saveInstallLock()
    {        
        $path = storage_path() . '/data/install.lock';
        return RC_File::put($path, 'ECJIA INSTALLED');
    }
    
    /**
     * 检测mysql数据引擎
     */
    public static function checkMysqlSupport($host, $port, $user, $pass)
    {
    	$conn = self::createDatabaseConnection($host, $port, $user, $pass);
    	if (is_ecjia_error($conn)) {
    		return new ecjia_error('connect_failed', RC_Lang::get('installer::installer.connect_failed'));
    	}
    	$r = $conn->select("SHOW variables like 'have_%';");
    	return collect($r);
    }
    
    /**
     * 获取mysql版本
     */
    public static function getMysqlVersion($host, $port, $user, $pass)
    {
    	$conn = self::createDatabaseConnection($host, $port, $user, $pass);
    	if (is_ecjia_error($conn)) {
    		return new ecjia_error('connect_failed', RC_Lang::get('installer::installer.connect_failed'));
    	}
    	$r = $conn->select("select version() as version;");
    	$version = collect(collect($r)->lists('version'))->first();
    	$ver = strstr($version, '-', true);
    	if ( $ver ) {
    	    return $ver;
    	} else {
    	    return $version;
    	}
    }
    
    public static function getMysqlVersionByConnection(Connection $connection)
    {
        $r = $connection->select("select version() as version;");
        $version = collect(collect($r)->lists('version'))->first();
        $ver = strstr($version, '-', true);
        if ( $ver ) {
            return $ver;
        } else {
            return $version;
        }
    }
}

//end