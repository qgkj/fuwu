<?php
  
/**
 * ECJIA 管理中心公用函数库
 */
defined('IN_ECJIA') or exit('No permission resources.');

class ecjia_utility {
    
    /**
     * 获得系统是否启用了 gzip
     *
     * @access public
     *
     * @return boolean
     */
    
    public static function gzip_enabled($enabled_gzip)
    {
        return ecjia::config('enable_gzip') && $enabled_gzip;
    }
    
    /**
     * 判断是否为搜索引擎蜘蛛
     *
     * @access public
     * @return string
     */
    public static function is_spider($record = true)
    {
        static $spider = null;
    
        if ($spider !== null) {
            return $spider;
        }
    
        if (empty($_SERVER['HTTP_USER_AGENT'])) {
            $spider = '';
            return false;
        }
    
        $searchengine_bot = array(
            'googlebot',
            'mediapartners-google',
            'baiduspider+',
            'msnbot',
            'yodaobot',
            'yahoo! slurp;',
            'yahoo! slurp china;',
            'iaskspider',
            'sogou web spider',
            'sogou push spider'
        );
    
        $searchengine_name = array(
            'GOOGLE',
            'GOOGLE ADSENSE',
            'BAIDU',
            'MSN',
            'YODAO',
            'YAHOO',
            'Yahoo China',
            'IASK',
            'SOGOU',
            'SOGOU'
        );
    
        $spider = strtolower($_SERVER['HTTP_USER_AGENT']);
    
        foreach ($searchengine_bot as $key => $value) {
            if (strpos($spider, $value) !== false) {
                $spider = $searchengine_name[$key];
                if ($record === true) {
                    RC_Api::api('stats', 'spider_record', array('searchengine' => $spider));
                }
                return $spider;
            }
        }
    
        $spider = '';
    
        return false;
    }
    
    /**
     * 获得浏览器名称和版本
     *
     * @access public
     * @return string
     */
    public static function get_user_browser()
    {
        if (empty($_SERVER['HTTP_USER_AGENT'])) {
            return '';
        }
    
        $agent = $_SERVER['HTTP_USER_AGENT'];
        $browser = '';
        $browser_ver = '';
    
        if (preg_match('/MSIE\s([^\s|;]+)/i', $agent, $regs)) {
            $browser = 'Internet Explorer';
            $browser_ver = $regs[1];
        } elseif (preg_match('/FireFox\/([^\s]+)/i', $agent, $regs)) {
            $browser = 'FireFox';
            $browser_ver = $regs[1];
        } elseif (preg_match('/Maxthon/i', $agent, $regs)) {
            $browser = '(Internet Explorer ' . $browser_ver . ') Maxthon';
            $browser_ver = '';
        } elseif (preg_match('/Opera[\s|\/]([^\s]+)/i', $agent, $regs)) {
            $browser = 'Opera';
            $browser_ver = $regs[1];
        } elseif (preg_match('/OmniWeb\/(v*)([^\s|;]+)/i', $agent, $regs)) {
            $browser = 'OmniWeb';
            $browser_ver = $regs[2];
        } elseif (preg_match('/Netscape([\d]*)\/([^\s]+)/i', $agent, $regs)) {
            $browser = 'Netscape';
            $browser_ver = $regs[2];
        } elseif (preg_match('/safari\/([^\s]+)/i', $agent, $regs)) {
            $browser = 'Safari';
            $browser_ver = $regs[1];
        } elseif (preg_match('/NetCaptor\s([^\s|;]+)/i', $agent, $regs)) {
            $browser = '(Internet Explorer ' . $browser_ver . ') NetCaptor';
            $browser_ver = $regs[1];
        } elseif (preg_match('/Lynx\/([^\s]+)/i', $agent, $regs)) {
            $browser = 'Lynx';
            $browser_ver = $regs[1];
        }
    
        if (! empty($browser)) {
            return addslashes($browser . ' ' . $browser_ver);
        } else {
            return 'Unknow browser';
        }
    }
    
    /**
     * 站点数据
     */
    public static function get_site_info()
    {
        $shop_country = ecjia_region::instance()->region_name(ecjia::config('shop_country'));
        $shop_province = ecjia_region::instance()->region_name(ecjia::config('shop_province'));
        $shop_city = ecjia_region::instance()->region_name(ecjia::config('shop_city'));
    	$orders_stats = RC_Api::api('orders', 'orders_stats');
        $goods_stats = RC_Api::api('goods', 'goods_stats');
    	$user_stats = RC_Api::api('user', 'user_stats');
        
        $data = array(
            'shop_url'      => RC_Uri::site_url(),
            'shop_name'     => ecjia::config('shop_name'),
            'shop_title'    => ecjia::config('shop_title'),
            'shop_desc'     => ecjia::config('shop_desc'),
            'shop_keywords' => ecjia::config('shop_keywords'),
            'shop_type'     => RC_Config::get('site.shop_type'),
            'country'       => $shop_country,
            'province'      => $shop_province,
            'city'          => $shop_city,
            'address'       => ecjia::config('shop_address'),
            'qq'            => ecjia::config('qq'),
            'ww'            => ecjia::config('ww'),
            'wechat'        => ecjia::config('ym'),
            'weibo'         => ecjia::config('msn'),
            'email'         => ecjia::config('service_email'),
            'phone'         => ecjia::config('service_phone'),
            'icp'           => ecjia::config('icp_number'),
            'ip'            => RC_Ip::server_ip(),
            'version'       => VERSION,
            'release'       => RELEASE,
            'language'      => ecjia::config('lang'),
            'php_ver'       => PHP_VERSION,
            'mysql_ver'     => RC_Model::make()->database_version(),
            'charset'       => strtoupper(RC_CHARSET),
            'orders_count'  => $orders_stats['total'], //订单的数量
            'orders_amount' => $orders_stats['amount'], //应付款金额的总和
            'goods_count'   => $goods_stats['total'], //未删除、能够被单独销售并且是实物的商品数量的总和
            'user_count'    => $user_stats['total'], //用户的数量
            'template'      => ecjia::config('template'), //是否使用默认模板
            'style'         => ecjia::config('stylename'), //样式名字
            'patch'         => '', //补丁的版本
        );
        return $data;
    }
    
    public static function build_notice_data() {
        
        $data = array(
            'shop_url'      => RC_Uri::site_url(), //网址
            'shop_type'     => RC_Config::get('site.shop_type'),
            'version'       => VERSION, //版本号
            'release'       => RELEASE, //发布日期
            'language'      => ecjia::config('lang'), //语言种类
            'php_ver'       => PHP_VERSION, // php服务器版本
            'mysql_ver'     => RC_Model::make()->database_version(), // mysql服务器版本,log：说明你开启了binlog
            'template'      => ecjia::config('template'), //是否使用默认模板
            'style'         => ecjia::config('stylename'), //样式名字
            'charset'       => strtoupper(RC_CHARSET), //字符编码
            'patch'         => '', //补丁的版本
        );
        
        return $data;
    }
    
    
    public static function site_admin_notice() {
        // 21600
        $data = ecjia_cloud::instance()->api('product/update/notice')->data(self::build_notice_data())->cacheTime(21600)->run();

        return $data;
    }
    
    public static function site_admin_news() {
        // 21600
        $data = ecjia_cloud::instance()->api('product/update/news')->data(self::build_notice_data())->cacheTime(21600)->run();
    
        return $data;
    }
    
    /**
     * 后台菜单排序
     * @param admin_menu $a
     * @param admin_menu $b
     * @return number
     */
    public static function admin_menu_by_sort(admin_menu $a, admin_menu $b) {
        if ($a->sort == $b->sort) {
            return 0;
        } else {
            return ($a->sort > $b->sort) ? 1 : -1;
        }
    }
    
    /**
     * 生成随机的数字串
     * @return string
     */
    public static function random_filename() {
        $str = '';
        for($i = 0; $i < 9; $i++) {
            $str .= mt_rand(0, 9);
        }
    
        return RC_Time::gmtime() . $str;
    }
    
    /**
     * 信息提示模板
     * @param string $msg
     * @param string $url
     */
    public static function message_template($msg, $url) {
        $site_url = RC_Uri::site_url();
        $message = <<<EOF
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>ROYALCMS - 操作提示</title>
	<style type="text/css">
		* {
			margin: 0px;
			padding: 0px;
		}
		html {
			background: none repeat scroll 0 0 #f1f1f1;
		}
		body {
			background: none repeat scroll 0 0 #fff;
			box-shadow: 0 1px 3px rgba(0, 0, 0, 0.13);
			color: #444;
			font-family: "Open Sans",sans-serif;
			margin: 2em auto;
			max-width: 700px;
			padding: 1em 2em;
		}
		#error-page {
			margin-top: 50px;
		}
		#error-page .error-message {
			font-size: 14px;
			line-height: 1.5;
			margin: 25px 0 20px;
		}
		#error-page h2{
			color: #666;
		}
		#error-page a,
		#error-page a:after {
			color: #08c;
			margin-right: 10px;
			text-decoration: none;
		}
		#error-page a:hover{
			text-decoration: underline;
		}
	</style>
</head>
<body id="error-page">
	<div class="error-message">
		<h2>操作提示</h2>
		<div>
			<p>{$msg}</p>
			<a href="javascript:{$url}">返回</a>
			<a href="{$site_url}">返回首页</a>
		</div>
	</div>
</body>
</html>
EOF;
        
        return $message;    
    }
}

// end