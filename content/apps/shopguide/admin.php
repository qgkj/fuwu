<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 开启向导入口
 * @author royalwang
 */
class admin extends ecjia_admin {
	private $db_region;
	private $db_shipping;
	private $db_shipping_area;
	private $db_shipping_area_region;
	private $db_payment;

	private $db_category;
	private $db_brand;
	private $db_goods;
	
	public function __construct() {
		parent::__construct();
		
		RC_Loader::load_app_class('shipping_factory', 'shipping', false);
		RC_Loader::load_app_class('goods_image_data', 'goods', false);
		
		$this->db_region 				= RC_Loader::load_model('region_model');
		$this->db_shipping 				= RC_Loader::load_app_model('shipping_model', 'shipping');
		$this->db_shipping_area 		= RC_Loader::load_app_model('shipping_area_model', 'shipping');
		$this->db_shipping_area_region 	= RC_Loader::load_app_model('shipping_area_region_model', 'shipping');
		$this->db_payment 				= RC_Loader::load_app_model('payment_model', 'payment');
		
		$this->db_category 		= RC_Loader::load_app_model('category_model', 'goods');
		$this->db_brand 		= RC_Loader::load_app_model('brand_model', 'goods');
		$this->db_goods 		= RC_Loader::load_app_model('goods_model', 'goods');
		
		RC_Loader::load_app_func('global', 'goods');
        
		RC_Style::enqueue_style('jquery-stepy');
		RC_Script::enqueue_script('jquery-validate');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Script::enqueue_script('jquery-stepy');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Script::enqueue_script('ecjia-region');
		RC_Script::enqueue_script('jquery-dataTables-bootstrap');
		RC_Script::enqueue_script('jquery-dataTables-sorting');
		RC_Script::enqueue_script('bootstrap-placeholder', RC_Uri::admin_url('statics/lib/dropper-upload/bootstrap-placeholder.js'), array(), false, true);
		
		RC_Script::enqueue_script('shopguide', RC_App::apps_url('statics/js/shopguide.js', __FILE__), array(), false, false);
		$shopguide_lang = array(
			'next_step'				=> RC_Lang::get('shopguide::shopguide.next_step'),
			'shop_name_required'	=> RC_Lang::get('shopguide::shopguide.shop_name_required'),
			'area_name_required' 	=> RC_Lang::get('shopguide::shopguide.area_name_required'),
			'goods_cat_required'	=> RC_Lang::get('shopguide::shopguide.goods_cat_required'),
			'goods_name_required'	=> RC_Lang::get('shopguide::shopguide.goods_name_required'),
			'pls_select'			=> RC_Lang::get('shopguide::shopguide.pls_select'),
		);
		RC_Script::localize_script('shopguide', 'js_lang', $shopguide_lang );
	}
	
    public function init() {
    	$this->admin_priv('shopguide_setup');
    	
		if (isset($_GET['step']) && $_GET['step'] > 1) {
			ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('shopguide::shopguide.shopguide'), RC_Uri::url('shopguide/admin/init')));
		} else {
			ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('shopguide::shopguide.shopguide')));
		}
    	
    	$this->assign('countries', $this->db_region->get_regions());
		if (ecjia::config('shop_country') > 0) {
			$this->assign('provinces', $this->db_region->get_regions(1, ecjia::config('shop_country')));
			if (ecjia::config('shop_province')) {
				$this->assign('cities', $this->db_region->get_regions(2, ecjia::config('shop_province')));
			}
		}
		
		$data['shop_name'] 		= ecjia::config('shop_name');
		$data['shop_title'] 	= ecjia::config('shop_title');
// 		$data['shop_country'] 	= ecjia::config('shop_country');
// 		$data['shop_province'] 	= ecjia::config('shop_province');
// 		$data['shop_city'] 		= ecjia::config('shop_city');
// 		$data['shop_address'] 	= ecjia::config('shop_address');
		$this->assign('data', $data);
		
		$shipping_list = RC_Api::api('shipping', 'shipping_list');
		$this->assign('shipping_list', $shipping_list);
		
		$pay_list = RC_Api::api('payment', 'pay_list');
		$this->assign('pay_list', $pay_list);
		
		$this->assign('ur_here', RC_Lang::get('shopguide::shopguide.shopguide'));
		$this->display('shop_guide.dwt');
    }
    
    public function step_post() {
    	$this->admin_priv('shopguide_setup', ecjia::MSGTYPE_JSON);
    	
    	$step = !empty($_GET['step']) ? intval($_GET['step']) : 1;
    	if ($step == 1) {
    		$shop_name 		= empty($_POST['shop_name']) 		? '' : $_POST['shop_name'] ;
    		$shop_title 	= empty($_POST['shop_title']) 		? '' : $_POST['shop_title'] ;
    		$shop_country 	= empty($_POST['shop_country']) 	? '' : intval($_POST['shop_country']);
    		$shop_province 	= empty($_POST['shop_province']) 	? '' : intval($_POST['shop_province']);
    		$shop_city 		= empty($_POST['shop_city']) 		? '' : intval($_POST['shop_city']);
    		$shop_address 	= empty($_POST['shop_address']) 	? '' : $_POST['shop_address'] ;
    		$shipping 		= empty($_POST['shipping']) 		? '' : $_POST['shipping'];
    		$payment 		= empty($_POST['payment']) 			? '' : $_POST['payment'];

    		$shipping_area_name = !empty($_POST['shipping_area_name']) ? trim($_POST['shipping_area_name']) : '';
    		
    		if (!empty($shop_name)) {
    			ecjia_config::instance()->write_config('shop_name', $shop_name);
    		} else {
    			return $this->showmessage(RC_Lang::get('shopguide::shopguide.shop_name_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}
    		 
    		if (!empty($shop_title)) {
    			ecjia_config::instance()->write_config('shop_title', $shop_title);
    		}
    		 
    		if (!empty($shop_address)) {
    			ecjia_config::instance()->write_config('shop_address', $shop_address);
    		}
    		 
    		if (!empty($shop_country)) {
    			ecjia_config::instance()->write_config('shop_country', $shop_country);
    		}
    		 
    		if (!empty($shop_province)) {
    			ecjia_config::instance()->write_config('shop_province', $shop_province);
    		}
    		 
    		if (!empty($shop_city)) {
    			ecjia_config::instance()->write_config('shop_city', $shop_city);
    		}

    		//添加配送区域
    		if ($shipping) {
    			if (empty($shipping_area_name)) {
    				return $this->showmessage(RC_Lang::get('shopguide::shopguide.area_name_required'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    			} 
    			
	    		/* 检查同类型的配送方式下有没有重名的配送区域 */
	    		$area_count = $this->db_shipping_area->is_only(array('shipping_id' => $shipping, 'shipping_area_name' => $shipping_area_name));
	    		if ($area_count > 0) {
	    			return $this->showmessage(RC_Lang::get('shopguide::shopguide.area_name_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
	    		} else {
	    			$shipping_data = $this->db_shipping->shipping_find(array('shipping_id' => $shipping), array('shipping_code', 'support_cod', 'shipping_name'));
	    			
	    			$config = array();
	    			$shipping_handle = new shipping_factory($shipping_data['shipping_code']);
	    			$config = $shipping_handle->form_format($config, true);
	    			if (!empty($config)) {
	    				foreach ($config AS $key => $val) {
	    					$config[$key]['name']   = $val['name'];
	    					$config[$key]['value']  = $_POST[$val['name']];
	    				}
	    			}
	    			 
	    			$count = count($config);
	    			$config[$count]['name']     = 'free_money';
	    			$config[$count]['value']    = empty($_POST['free_money']) ? '0' : trim($_POST['free_money']);
	    			$count++;
	    			$config[$count]['name']     = 'fee_compute_mode';
	    			$config[$count]['value']    = empty($_POST['fee_compute_mode']) ? '' : trim($_POST['fee_compute_mode']);
	    			 
	    			/* 如果支持货到付款，则允许设置货到付款支付费用 */
	    			if ($shipping_data['support_cod']) {
	    				$count++;
	    				$config[$count]['name']     = 'pay_fee';
	    				$config[$count]['value']    =  make_semiangle(empty($_POST['pay_fee']) ? '0' : trim($_POST['pay_fee']));
	    			}
	    			
	    			$data = array(
	    				'shipping_area_name'	=> $shipping_area_name,
	    				'shipping_id'           => $shipping,
	    				'configure'             => serialize($config)
	    			);
	    			$area_id = $this->db_shipping_area->shipping_area_manage($data);

	    			if (isset($_POST['shipping_district'])) {
	    				$region_id = intval($_POST['shipping_district']);
	    			} elseif ($_POST['shipping_city']) {
	    				$region_id = intval($_POST['shipping_city']);
	    			} elseif ($_POST['shipping_province']) {
	    				$region_id = intval($_POST['shipping_province']);
	    			} elseif ($_POST['shipping_country']) {
	    				$region_id = intval($_POST['shipping_country']);
	    			}
	    			
	    			/* 添加选定的城市和地区 */
					$arr = array(
						'shipping_area_id' 	=> $area_id,
					    'region_id' 		=> $region_id
					);
					$this->db_shipping_area_region->shipping_area_region_insert($arr);
	    		}
    		}
    		
    		//支付方式
    		if ($payment) {
    			/* 取得配置信息 */
    			$pay_config = array();
    			if (isset($_POST['cfg_value']) && is_array($_POST['cfg_value'])) {
    				for ($i = 0; $i < count($_POST['cfg_value']); $i++) {
    					$pay_config[] = array(
    						'name'  => trim($_POST['cfg_name'][$i]),
    						'type'  => trim($_POST['cfg_type'][$i]),
    						'value' => trim($_POST['cfg_value'][$i])
    					);
    				}
    			}
    			$pay_config  = serialize($pay_config);
    			$array       = array('pay_config' => $pay_config);	
    			$this->db_payment->where(array('pay_code' => $payment))->update($array);
    		}
    		
    		ecjia_config::instance()->clear_cache();
    		return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => RC_Uri::url('shopguide/admin/init', array('step' => 2))));
    		
    	} elseif ($step == 2) {
    		$cat_name 		= empty($_POST['cat_name']) 		? '' 	: trim($_POST['cat_name']);
    		$goods_name 	= empty($_POST['goods_name']) 		? '' 	: trim($_POST['goods_name']);
    		
    		$goods_number 	= empty($_POST['goods_num'])        ? 0 	: intval($_POST['goods_num']);
    		$goods_brand 	= empty($_POST['goods_brand']) 		? '' 	: trim($_POST['goods_brand']);
    		$goods_price 	= empty($_POST['goods_price'])|| !is_numeric($_POST['goods_price']) ? 0 : $_POST['goods_price'];
    		
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

    		$brand_id = 0;
    		if (!empty($goods_brand)) {
    			$brand_count = $this->db_brand->where(array('brand_name' => $goods_brand))->count();
    			
    			if ($brand_count > 0) {
    				return $this->showmessage(RC_Lang::get('shopguide::shopguide.brand_name_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    			}
    			$brand_id = $this->db_brand->brand_manage(array('brand_name' => $goods_brand, 'is_show' => 1));
    		}
    		
    		$count = $this->db_category->where(array('cat_name' => $cat_name))->count();
    		if ($count > 0) {
    			return $this->showmessage(RC_Lang::get('shopguide::shopguide.cat_name_exist'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}
    			
    		$cat_id = $this->db_category->category_manage(array('cat_name' => $cat_name, 'parent_id' => 0, 'is_show' => 1));
    			
    		$max_id = $this->db_goods->goods_find('', 'MAX(goods_id) + 1|max');
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
    		$data = array(
    			'goods_name'            => $goods_name,
    			'goods_sn'              => $goods_sn,
    			'goods_number'			=> $goods_number,
    			'cat_id'                => $cat_id,
    			'brand_id'              => $brand_id,
    			'shop_price'            => $goods_price,
    			'is_best'               => $is_best,
    			'is_new'                => $is_new,
    			'is_hot'                => $is_hot,
    			'add_time'              => RC_Time::gmtime(),
    			'last_update'           => RC_Time::gmtime(),
    			'goods_brief'			=> $goods_desc
    		);
    		
    		$goods_id = $this->db_goods->insert($data);
    		
    		if (isset($goods_sn_bool) && $goods_sn_bool) {
    			$goods_sn = generate_goods_sn($goods_id);
    			$data     = array('goods_sn' => $goods_sn);
    			$this->db_goods->goods_update(array('goods_id' => $goods_id), $data);
    		}
    		
    		/* 记录日志 */
    		ecjia_admin::admin_log($goods_name, 'add', 'goods');
    		
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
    		return $this->showmessage(RC_Lang::get('shopguide::shopguide.complete'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('shopguide/admin/init', array('step' => 3))));
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