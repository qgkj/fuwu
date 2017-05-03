<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获取店铺基本信息
 * @return  array
 */
function get_merchant_info($store_id){
    $data = array(
        'shop_kf_mobile'            => '', // 客服手机号码
        'shop_nav_background'		=> '', //店铺导航背景图
        'shop_logo'                 => '', // 默认店铺页头部LOGO
        'shop_banner_pic'           => '', // banner图
        'shop_trade_time'           => '', // 营业时间
        'shop_description'          => '', // 店铺描述
        'shop_notice'               => '', // 店铺公告
        'shop_review_goods',
    );

    $data = get_merchant_config($store_id, '', $data);
    if(!empty($data['shop_trade_time'])){
        $shop_time = unserialize($data['shop_trade_time']);
        unset($data['shop_trade_time']);
        $sart_time = explode(':', $shop_time['start']);
        $end_time  = explode(':', $shop_time['end']);
        $s_time    = ($sart_time[0]*60)+$sart_time[1];
        $e_time    = ($end_time[0]*60)+$end_time[1];
    }else{
        // 默认时间点 8:00-21:00
        $s_time = 480;
        $e_time = 1260;
    }


    $data['shop_trade_time']    = implode('--', $shop_time);
    $data['shop_nav_background']= !empty($data['shop_nav_background'])? RC_Upload::upload_url($data['shop_nav_background']) : '';
    $data['shop_logo']          = !empty($data['shop_logo'])? RC_Upload::upload_url($data['shop_logo']) : '';
    $data['shop_banner_pic']    = !empty($data['shop_banner_pic'])? RC_Upload::upload_url($data['shop_banner_pic']) : '';
    $data['shop_time_value']    = $s_time.",".$e_time;
    return $data;
}

/**
 * 获取店铺配置信息
 * @return  array
 */
function get_merchant_config($store_id, $code, $arr){
    if(empty($code)){
        if(is_array($arr)){
            $config = RC_DB::table('merchants_config')->where('store_id', $store_id)->select('code','value')->get();
            foreach ($config as $key => $value) {
                $arr[$value['code']] = $value['value'];
            }
            return $arr;
        }else{
            return ;
        }
    }else{
        $config = RC_DB::table('merchants_config')->where('store_id', $store_id)->where('code', '=', $code)->pluck('value');
        return $config;
    }
}

/*
 * 设置店铺配置信息
 */
function set_merchant_config($store_id, $code, $value, $arr){
    $merchants_config = RC_Model::model('merchant/merchants_config_model');
    if(empty($code)){
        if(is_array($arr)){
            foreach ($arr as $key => $val) {
                $count = RC_DB::table('merchants_config')->where('store_id', $store_id)->where('code', '=', $key)->count();
                if(empty($count)){
                    RC_DB::table('merchants_config')->insert(array('store_id' => $store_id, 'code' => $key, 'value' => $val));
                }else{
                    RC_DB::table('merchants_config')->where('store_id', $store_id)->where('code', '=', $key)->update(array('value' => $val));
                }
            }
            return true;
        }else{
            return new ecjia_error(101, '参数错误');
        }
    }else{
        $count = RC_DB::table('merchants_config')->where('store_id', $store_id)->where('code', '=', $code)->count();
        if(empty($count)){
            RC_DB::table('merchants_config')->insert(array('store_id' => $store_id, 'code' => $code, 'value' => $value));
        }else{
            RC_DB::table('merchants_config')->where('store_id', $store_id)->where('code', '=', $code)->update(array('value' => $value));
        }
        return true;
    }
}

/*
 * 上传图片
 *  @param string $path 上传路径
 *  @param string $code 接收图片参数
 *  @param string $old_images 旧图片
 */
function file_upload_info($path, $code, $old_images, $store_id){
    $code   = empty($code)? $path : $code;
    $upload = RC_Upload::uploader('image', array('save_path' => 'merchant/'.$store_id.'/data/'.$path, 'auto_sub_dirs' => true));
    $file   = $_FILES[$code];

    if (!empty($file)&&((isset($file['error']) && $file['error'] == 0) || (!isset($file['error']) && $file['tmp_name'] != 'none'))) {
        // 检测图片类型是否符合
        if (!$upload->check_upload_file($file)){
           return ecjia_admin::$controller->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }else{
            $image_info = $upload->upload($file);
            if (empty($image_info)) {
               return ecjia_admin::$controller->showmessage($upload->error(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            // 删除旧的图片
            if (!empty($old_images)) {
               $upload->remove($old_images);
            }
            $img_path = $upload->get_position($image_info);
        }

        return $img_path;
    }
}

/**
* 清除用户购物车
*/
function clear_cart_list($store_id){
	if(empty($store_id)) return false;
	// 清除所有用户购物车内商家的商品
	RC_DB::table('cart')->where('store_id', $store_id)->delete();
}

//end