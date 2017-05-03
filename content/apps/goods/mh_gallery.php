<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 *  ECJIA 商品相册管理
 */
class mh_gallery extends ecjia_merchant {

	public function __construct() {
        parent::__construct();
        
        RC_Script::enqueue_script('goods_list', RC_App::apps_url('statics/js/merchant_goods_list.js', __FILE__), array(), false, true);
        RC_Style::enqueue_style('goods', RC_App::apps_url('statics/styles/goods.css', __FILE__), array());
        
        RC_Script::enqueue_script('jquery-dropper', RC_Uri::admin_url() . '/statics/lib/dropper-upload/jquery.fs.dropper.js', array(), false, true);
        RC_Script::enqueue_script('jquery-imagesloaded');
        
        RC_Script::enqueue_script('jquery-colorbox');
        RC_Style::enqueue_style('jquery-colorbox');
        
        RC_Style::enqueue_style('goods-colorpicker-style', RC_Uri::admin_url() . '/statics/lib/colorpicker/css/colorpicker.css');
        RC_Script::enqueue_script('goods-colorpicker-script', RC_Uri::admin_url('/statics/lib/colorpicker/bootstrap-colorpicker.js'), array());
        
        RC_Style::enqueue_style('bootstrap-editable-css', RC_Uri::admin_url() . '/statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css');
        RC_Script::enqueue_script('jquery-ui');
        RC_Script::enqueue_script('smoke');
        RC_Style::enqueue_style('uniform-aristo');
        RC_Script::enqueue_script('jq_quicksearch', RC_Uri::admin_url() . '/statics/lib/multi-select/js/jquery.quicksearch.js', array('jquery'), false, true);
        
        RC_Script::enqueue_script('ecjia-region',RC_Uri::admin_url('statics/ecjia.js/ecjia.region.js'), array('jquery'), false, true);
        
        RC_Script::localize_script('goods_list', 'js_lang', RC_Lang::get('goods::goods.js_lang'));
        
        RC_Loader::load_app_class('goods', 'goods');
        RC_Loader::load_app_class('goods_image', 'goods', false);
        
        RC_Loader::load_app_func('admin_category');
        RC_Loader::load_app_func('global');
        
        RC_Loader::load_app_func('admin_user', 'user');
        $goods_list_jslang = array(
        	'user_rank_list'	=> get_rank_list(),
        	'marketPriceRate'	=> ecjia::config('market_price_rate'),
        	'integralPercent'	=> ecjia::config('integral_percent'),
        );
        RC_Script::localize_script('goods_list', 'admin_goodsList_lang', $goods_list_jslang );
        ecjia_merchant_screen::get_current_screen()->set_parentage('goods', 'goods/mh_gallery.php');
        ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('goods::goods.goods_manage'), RC_Uri::url('goods/merchant/init')));
	}
    
    /**
     * 商品相册
     */
    public function init() {
        $this->admin_priv('goods_update');
        
        ecjia_merchant_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('goods::goods.goods_list'), RC_Uri::url('goods/merchant/init')));
        $this->assign('ur_here', RC_Lang::get('goods::goods.edit_goods_photo'));

        ecjia_merchant_screen::get_current_screen()->add_help_tab(array(
	        'id'		=> 'overview',
	        'title'		=> RC_Lang::get('goods::goods.overview'),
	        'content'	=>
	        '<p>' . RC_Lang::get('goods::goods.goods_gallery_help') . '</p>'
        ));
        
        ecjia_merchant_screen::get_current_screen()->set_help_sidebar(
       	 	'<p><strong>' . RC_Lang::get('goods::goods.more_info') . '</strong></p>' .
        	'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:商品列表#.E5.95.86.E5.93.81.E7.9B.B8.E5.86.8C" target="_blank">'. RC_Lang::get('goods::goods.about_goods_gallery') .'</a>') . '</p>'
        );
        
        $goods_id = intval($_GET['goods_id']);
        $goods = RC_DB::table('goods')->where('goods_id', $goods_id)->where('store_id', $_SESSION['store_id'])->first();
        if (empty($goods)) {
        	return $this->showmessage(RC_Lang::get('goods::goods.no_goods'), ecjia::MSGTYPE_HTML | ecjia::MSGSTAT_ERROR, array('links' => array(array('text' => RC_Lang::get('goods::goods.return_last_page'), 'href' => 'javascript:history.go(-1)'))));
        }
        
        $extension_code = isset($_GET['extension_code']) ? '&extension_code='.$_GET['extension_code'] : '';
        
        $this->tags = get_merchant_goods_info_nav($goods_id, $extension_code);
        $this->tags['edit_goods_photo']['active'] = 1;
        /* 图片列表 */
        $img_list = RC_DB::table('goods_gallery')->where('goods_id', $goods_id)->get();
        
        $img_list_sort = $img_list_id = array();
        $no_picture = RC_Uri::admin_url('statics/images/nopic.png');

         /* 格式化相册图片路径 */
        if (!empty($img_list)) {
        	foreach ($img_list as $key => $gallery_img) {

        		$desc_index = intval(strrpos($gallery_img['img_original'], '?')) + 1;
        		!empty($desc_index) && $img_list[$key]['desc'] = substr($gallery_img['img_original'], $desc_index);
        		
        		$img_list[$key]['img_url'] 		= empty($gallery_img['img_url']) 		|| !file_exists(RC_Upload::upload_path($gallery_img['img_url'])) 		?  $no_picture : RC_Upload::upload_url() . '/' . $gallery_img['img_url'];
        		$img_list[$key]['thumb_url'] 	= empty($gallery_img['thumb_url']) 		|| !file_exists(RC_Upload::upload_path($gallery_img['thumb_url'])) 		?  $no_picture : RC_Upload::upload_url() . '/' . $gallery_img['thumb_url'];
        		$img_list[$key]['img_original'] = empty($gallery_img['img_original']) 	|| !file_exists(RC_Upload::upload_path($gallery_img['img_original'])) 	?  $no_picture : RC_Upload::upload_url() . '/' . $gallery_img['img_original'];
        	
        		$img_list_sort[$key] = $img_list[$key]['desc'];
        		$img_list_id[$key] = $gallery_img['img_id'];
        	}

        	//先使用sort排序，再使用id排序。
        	array_multisort($img_list_sort, $img_list_id, $img_list);
        }
		
        //设置选中状态,并分配标签导航
        $this->assign('tags', $this->tags);
        $this->assign('action_link', array('href' => RC_Uri::url('goods/merchant/init'), 'text' => RC_Lang::get('goods::goods.goods_list')));
        
        $this->assign('goods_id', $goods_id);
        $this->assign('img_list', $img_list);
        
        if (isset($_GET['step'])) {
        	$this->assign('step', 4);
        	$this->assign('url', RC_Uri::url('goods/merchant/edit_link_goods', "goods_id=$goods_id".$extension_code.'&step='.'add_link_goods'));
        	$this->assign('form_action', RC_Uri::url('goods/mh_gallery/insert', "goods_id=$goods_id".$extension_code.'&step='.$_GET['step']));
        	$ur_here = RC_Lang::get('goods::goods.add_goods_photo');
        } else {
        	$this->assign('form_action', RC_Uri::url('goods/mh_gallery/insert', "goods_id=$goods_id".$extension_code));
        	$ur_here = RC_Lang::get('goods::goods.edit_goods_photo');
        }
        ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here($ur_here));
        $this->assign('ur_here', $ur_here);
        
        $this->display('goods_photo.dwt');
    }
    
    /**
     * 上传商品相册图片的方法
     */
    public function insert() {
        $this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);
        
        $step = isset($_GET['step']) ? trim($_GET['step']) : '';
        
        RC_Loader::load_app_class('goods_image_data', 'goods', false);
        $goods_id = intval($_GET['goods_id']);

        if (empty($goods_id)) {
            return $this->showmessage(RC_Lang::get('goods::goods.parameter_missing'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $upload = RC_Upload::uploader('image', array('save_path' => './images', 'auto_sub_dirs' => true));
        $upload->add_saving_callback(function ($file, $filename) {
            return true;
        });
        
        if (!$upload->check_upload_file($_FILES['img_url'])) {
            return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }

        $image_info = $upload->upload($_FILES['img_url']);
        if (empty($image_info)) {
            return $this->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $goods_image = new goods_image_data($image_info['name'], $image_info['tmpname'], $image_info['ext'], $goods_id);
        $goods_image->update_gallery();
        
        /*释放商品相册缓存*/
        $cache_goods_gallery_key = 'goods_gallery_'.$goods_id;
        $cache_goods_gallery_id = sprintf('%X', crc32($cache_goods_gallery_key));
        $orm_goods_gallery_db = RC_Model::model('goods/orm_goods_gallery_model');
        $orm_goods_gallery_db->delete_cache_item($cache_goods_gallery_id);
        
        $arr['goods_id'] = $goods_id;
        if ($step) {
        	$arr['step'] = 'add_goods_gallery';
        }
        $url = RC_Uri::url('goods/mh_gallery/init', $arr);
        return $this->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $url));
    }

	/**
	* 删除图片
	*/
	public function drop_image() {
		$this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);
		
		$img_id = empty($_GET['img_id']) ? 0 : intval($_GET['img_id']);
		$goods_id = empty($_GET['goods_id']) ? 0 : intval($_GET['goods_id']);
		
		/* 删除图片文件 */
		$row = RC_DB::table('goods_gallery')->select('img_url', 'thumb_url', 'img_original')->where('img_id', $img_id)->first();
		strrpos($row['img_original'], '?') && $row['img_original'] = substr($row['img_original'], 0, strrpos($row['img_original'], '?'));

		RC_Loader::load_app_class('goods_imageutils', 'goods', false);
		if ($row['img_url']) {
			RC_Filesystem::disk()->delete(goods_imageutils::getAbsolutePath($row['img_url']));
		}
		if ($row['thumb_url']) {
			RC_Filesystem::disk()->delete(goods_imageutils::getAbsolutePath($row['thumb_url']));
		}
		if ($row['img_original']) {
			RC_Filesystem::disk()->delete(goods_imageutils::getAbsolutePath($row['img_original']));
		}

		/* 删除数据 */
		RC_DB::table('goods_gallery')->where('img_id', $img_id)->delete();
		
		/*释放商品相册缓存*/
		$cache_goods_gallery_key = 'goods_gallery_'.$goods_id;
		$cache_goods_gallery_id = sprintf('%X', crc32($cache_goods_gallery_key));
		$orm_goods_gallery_db = RC_Model::model('goods/orm_goods_gallery_model');
		$orm_goods_gallery_db->delete_cache_item($cache_goods_gallery_id);
		
		return $this->showmessage(RC_Lang::get('goods::goods.drop_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}

	/**
	* 修改相册图片描述
	*/
	public function update_image_desc() {
		$this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);
		
		$img_id = empty($_GET['img_id']) ? 0 : $_GET['img_id'];
		$val = $_GET['val'];
		RC_DB::table('goods_gallery')->where('img_id', $img_id)->update(array('img_desc' => $val));
		
		/*释放商品相册缓存*/
		$goods_id = RC_DB::table('goods_gallery')->where('img_id', $img_id)->pluck('goods_id');	
		$cache_goods_gallery_key = 'goods_gallery_'.$goods_id;
		$cache_goods_gallery_id = sprintf('%X', crc32($cache_goods_gallery_key));
		$orm_goods_gallery_db = RC_Model::model('goods/orm_goods_gallery_model');
		$orm_goods_gallery_db->delete_cache_item($cache_goods_gallery_id);
		
		return $this->showmessage(RC_Lang::get('goods::goods.edit_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}

	/**
	* 相册图片排序
	*/
	public function sort_image() {
		$this->admin_priv('goods_update', ecjia::MSGTYPE_JSON);
		
		$sort = $_GET['info'];
		$i = 1;
		
		foreach ($sort as $k => $v) {
			$v['img_original'] = strrpos($v['img_original'], '?') > 0 ? substr($v['img_original'], 0, strrpos($v['img_original'], '?')) . '?' . $i : $v['img_original']. '?' . $i;
			$v['img_original'] = str_replace(RC_Upload::upload_url() . '/', '', $v['img_original']);
			$i++;
			$data = array('img_original' => $v['img_original']);
			RC_DB::table('goods_gallery')->where('img_id', $v['img_id'])->update($data);
			
			/*释放商品相册缓存*/
			$goods_id = RC_DB::table('goods_gallery')->where('img_id', $v['img_id'])->pluck('goods_id');
			$cache_goods_gallery_key = 'goods_gallery_'.$goods_id;
			$cache_goods_gallery_id = sprintf('%X', crc32($cache_goods_gallery_key));
			$orm_goods_gallery_db = RC_Model::model('goods/orm_goods_gallery_model');
			$orm_goods_gallery_db->delete_cache_item($cache_goods_gallery_id);
		}
		return $this->showmessage(RC_Lang::get('goods::goods.save_sort_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
}

// end