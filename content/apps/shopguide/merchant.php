<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 商家开启向导
 * @author wutifang
 */
class merchant extends ecjia_merchant {
	private $db_region;
	
	public function __construct() {
		parent::__construct();
		
		$this->db_region = RC_Loader::load_model('region_model');
		
		RC_Script::enqueue_script('jquery-validate');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-stepy');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('ecjia-region');
		
        RC_Loader::load_app_func('global', 'goods');
		RC_Loader::load_app_func('merchant_shopguide');
		
		RC_Script::enqueue_script('ecjia-mh-bootstrap-fileupload-js');
		RC_Style::enqueue_style('ecjia-mh-bootstrap-fileupload-css');
		
		// 时间区间
		RC_Style::enqueue_style('range', RC_App::apps_url('statics/css/range.css', __FILE__), array());
		RC_Script::enqueue_script('jquery-range', RC_App::apps_url('statics/mh-js/jquery.range.js', __FILE__), array(), false, true);
		RC_Script::enqueue_script('shopguide', RC_App::apps_url('statics/mh-js/shopguide.js', __FILE__), array(), false, false);
		RC_Script::enqueue_script('migrate', RC_App::apps_url('statics/mh-js/migrate.js', __FILE__) , array() , false, true);
		
		RC_Loader::load_app_class('goods', 'goods', false);
		RC_Loader::load_app_class('goods_image', 'goods', false);
		RC_Loader::load_app_class('goods_image_data', 'goods', false);
		RC_Loader::load_app_class('goods_imageutils', 'goods', false);
	}
	
    public function init() {
    	$this->admin_priv('shopguide_setup');
    	
    	$this->assign('ur_here', RC_Lang::get('shopguide::shopguide.shopguide'));
    	
		if (isset($_GET['step']) && $_GET['step'] > 1) {
			ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('shopguide::shopguide.shopguide'), RC_Uri::url('shopguide/merchant/init')));
		} else {
			ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('shopguide::shopguide.shopguide')));
		}
		
		$merchant_info['merchants_name'] = RC_DB::table('store_franchisee')->where('store_id', $_SESSION['store_id'])->pluck('merchants_name');
		$s_time = 480;
		$e_time = 1260;
		$merchant_info['shop_time_value'] = $s_time.",".$e_time;
		
		$this->assign('data', $merchant_info);
		$this->display('shop_guide.dwt');
    }
    
    public function step_post() {
    	$this->admin_priv('shopguide_setup', ecjia::MSGTYPE_JSON);

    	$step = !empty($_GET['step']) ? intval($_GET['step']) : 1;
    	
    	if ($step == 1) {
    		$store_id               = $_SESSION['store_id'];
    		$shop_description       = ($_POST['shop_description'] == get_merchant_config('shop_description'))   ? '' : htmlspecialchars($_POST['shop_description']);
    		$shop_trade_time        = empty($_POST['shop_trade_time'])                                          ? '' : htmlspecialchars($_POST['shop_trade_time']);
    		$shop_notice            = ($_POST['shop_notice'] == get_merchant_config('shop_notice'))             ? '' : htmlspecialchars($_POST['shop_notice']);
    		
    		$merchant_config = array();
    		
    		// 店铺导航背景图
    		if (!empty($_FILES['shop_nav_background']) && empty($_FILES['error']) && !empty($_FILES['shop_nav_background']['name'])) {
    			$merchants_config['shop_nav_background'] = file_upload_info('shop_nav_background', '', $shop_nav_background);
    		}
    		// 默认店铺页头部LOGO
    		if (!empty($_FILES['shop_logo']) && empty($_FILES['error']) && !empty($_FILES['shop_logo']['name'])) {
    			$merchants_config['shop_logo'] = file_upload_info('shop_logo', '', $shop_logo);
    		}
    		
    		// APPbanner图
    		if (!empty($_FILES['shop_banner_pic']) && empty($_FILES['error']) && !empty($_FILES['shop_banner_pic']['name'])) {
    			$merchants_config['shop_banner_pic'] = file_upload_info('shop_banner', 'shop_banner_pic', $shop_banner_pic);
    		}
    		// 如果没有上传店铺LOGO 提示上传店铺LOGO
    		$shop_logo = get_merchant_config('shop_logo');
    		if (empty($shop_logo) && empty($merchants_config['shop_logo'])) {
    			return $this->showmessage('请上传店铺LOGO', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}
    		
    		if (!empty($shop_description)) {
    			$merchants_config['shop_description'] = $shop_description;// 店铺描述
    		}
    		$time = array();

    		if (!empty($shop_trade_time)) {
    			$shop_time       = explode(',',$shop_trade_time);
	            $s_h             = ($shop_time[0] / 60);
	            $s_i             = ($shop_time[0] % 60);
	            $e_h             = ($shop_time[1] / 60);
	            $e_i             = ($shop_time[1] % 60);
	            $start_h         = empty($s_h)? '00' : intval($s_h);
	            $start_i         = empty($s_i)? '00' : intval($s_i);
	            $end_h           = empty($e_h)? '00' : intval($e_h);
	            $end_i           = empty($e_i)? '00' : intval($e_i);
	            $start_time      = $start_h.":".$start_i;
	            $end_time        = $end_h.":".$end_i;
	            $time['start']   = $start_time;
	            $time['end']     = $end_time;
	            $shop_trade_time = serialize($time);
    			if ($shop_trade_time != get_merchant_config('shop_trade_time')) {
    				$merchants_config['shop_trade_time'] = $shop_trade_time;// 营业时间
    			}
    		}
    		if (!empty($shop_notice)) {
    			$merchants_config['shop_notice'] = $shop_notice;// 店铺公告
    		}
    		if (!empty($merchants_config)) {
    			$merchant = set_merchant_config('', '', $merchants_config);
    		}
    		
    		ecjia_merchant::admin_log('修改店铺基本信息', 'edit', 'merchant');
    		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => RC_Uri::url('shopguide/merchant/init', array('step' => 2))));
    		
    	} elseif ($step == 2) {
    		$cat_name 		= empty($_POST['cat_name']) 		? '' 	: trim($_POST['cat_name']);
    		$goods_name 	= empty($_POST['goods_name']) 		? '' 	: trim($_POST['goods_name']);
    		$goods_type 	= empty($_POST['goods_type'])		? ''	: trim($_POST['goods_type']);

    		$goods_number 	= empty($_POST['goods_num']) 		? 0 	: intval($_POST['goods_num']);
    		$goods_price 	= empty($_POST['goods_price']) || !is_numeric($_POST['goods_price']) ? 0 : $_POST['goods_price'];
    		
    		$is_best 		= empty($_POST['is_best']) 			? 0 	: 1;
    		$is_new 		= empty($_POST['is_new']) 			? 0 	: 1;
    		$is_hot 		= empty($_POST['is_hot']) 			? 0 	: 1;
    		$goods_desc 	= empty($_POST['goods_desc']) 		? '' 	: $_POST['goods_desc'];

    		if (empty($cat_name)) {
    			return $this->showmessage(RC_Lang::get('shopguide::shopguide.goods_cat_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}
    		
    		if (empty($goods_name)) {
    			return $this->showmessage(RC_Lang::get('shopguide::shopguide.goods_name_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}

    		$count = RC_DB::table('merchants_category')->where('cat_name', $cat_name)->where('store_id', $_SESSION['store_id'])->count();
    		if ($count > 0) {
    			return $this->showmessage(RC_Lang::get('shopguide::shopguide.cat_name_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}
    		$merchant_cat_id = RC_DB::table('merchants_category')->insertGetId(array('cat_name' => $cat_name, 'is_show' => 1, 'store_id' => $_SESSION['store_id']));

    		$goods_type_id = 0;
    		if (!empty($goods_type)) {
    			$count = RC_DB::table('goods_type')->where('cat_name', $goods_type)->where('store_id', $_SESSION['store_id'])->count();
    			if ($count > 0) {
    				return $this->showmessage('该商品类型已存在', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    			}
    			$goods_type_id = RC_DB::table('goods_type')->insertGetId(array('cat_name' => $goods_type, 'enabled' => 1, 'store_id' => $_SESSION['store_id']));
    		}
    		
    		//生成商品货号
    		$max_id = RC_DB::table('goods')->selectRaw('(MAX(goods_id) + 1) as max')->first();
    		if (empty($max_id['max'])) {
    			$goods_sn_bool = true;
    			$goods_sn = '';
    		} else {
    			$goods_sn = generate_goods_sn($max_id['max']);
    		}
    		
    		/* 处理商品图片 */
    		$goods_img    = ''; 	// 初始化商品图片
    		$goods_thumb  = ''; 	// 初始化商品缩略图
    		$img_original = ''; // 初始化原始图片
    		
    		$upload = RC_Upload::uploader('image', array('save_path' => 'images', 'auto_sub_dirs' => true));
    		$upload->add_saving_callback(function ($file, $filename) {
    			return true;
    		});
    		
    		/* 是否处理商品图 */
    		$proc_goods_img = true;
    		if (isset($_FILES['goods_img'])) {
    			if (!$upload->check_upload_file($_FILES['goods_img'])) {
    				$proc_goods_img = false;
    			}
    		}
    			
    		if ($proc_goods_img) {
    			if (isset($_FILES['goods_img'])) {
    				$image_info = $upload->upload($_FILES['goods_img']);
    				if (empty($image_info)) {
    					return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    				}
    			}
    		}
    			
    		if ($proc_thumb_img) {
    			if (isset($_FILES['thumb_img'])) {
    				$thumb_info = $upload->upload($_FILES['thumb_img']);
    				if (empty($thumb_info)) {
    					return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    				}
    			}
    		}
    			
    		$data = array(
    			'goods_name'            => $goods_name,
    			'goods_sn'              => $goods_sn,
    			'merchant_cat_id'		=> $merchant_cat_id,	//店铺分类id
    			'goods_type'			=> $goods_type_id,
    			'shop_price'            => $goods_price,
    			'goods_brief'           => $goods_desc,
    			'goods_number'          => $goods_number,
    			'store_best'            => $is_best,
    			'store_new'             => $is_new,
    			'store_hot'             => $is_hot,
    			'add_time'              => RC_Time::gmtime(),
    			'review_status'         => 5,
    			'store_id'				=> $_SESSION['store_id']
    		);
    		$goods_id = RC_DB::table('goods')->insertGetId($data);
    			
    		/* 更新上传后的商品图片 */
    		if ($proc_goods_img) {
    			if (isset($image_info)) {
    				$goods_image = new goods_image_data($image_info['name'], $image_info['tmpname'], $image_info['ext'], $goods_id);
    				if ($proc_thumb_img) {
    					$goods_image->set_auto_thumb(false);
    				}
    			
    				$result = $goods_image->update_goods();
    				if (is_ecjia_error($result)) {
    					return $this->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    				}
    			}
    		}

    		/* 记录日志 */
    		ecjia_merchant::admin_log($goods_name, 'add', 'goods');
    		$links = array(array('text' => '仪表盘', 'href' => RC_Uri::url('merchant/dashboard/init')));
    		return $this->showmessage(RC_Lang::get('shopguide::shopguide.complete'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('links' => $links, 'pjaxurl' => RC_Uri::url('shopguide/merchant/init', array('step' => 3))));
    	}
    }
    
    //获取支付方式信息
    public function get_pay() {
    	$code = !empty($_POST['code']) ? trim($_POST['code']) : '';
    	$pay  = RC_Api::api('payment', 'pay_info', array('code' => $code));
    	
    	return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $pay));
    }
}

// end