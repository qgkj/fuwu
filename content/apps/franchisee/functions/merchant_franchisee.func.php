<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * @param array $data 插入更新数据
 * @param array $store_info 原有信息
 * @param number $insert_id
 */
function add_check_log($data, $store_info = array(), $insert_id = 0) {
    //审核日志
    //add
    if ($insert_id && empty($data['store_id'])) {
        $log = array(
            'store_id'          => $insert_id,
            'type'              => 1,
            'name'              => $data['responsible_person'],
            'original_data'     => '',
            'new_data'          => '',
            'info'              => '申请入驻信息第一次提交',
        );
    } else {
        //edit
        //$store_info
        //$data
         
        //审核日志字段
        $edit_fields = array(
            'merchants_name'            => '店铺名称',
            'company_name'              => '公司名称',
            'shop_keyword'              => '店铺关键字',
            'cat_id'                    => '店铺分类',
            'responsible_person'        => '负责人',
            'email'                     => '电子邮箱',
            'contact_mobile'            => '联系方式',
            'province'                  => '省',
            'city'                      => '市',
            'district'                  => '区',
            'address'                   => '详细地址',
            'identity_type'             => '证件类型',
            'identity_number'           => '证件号码',
            'business_licence'          => '营业执照注册号',
            'identity_pic_front'        => '证件正面',
            'identity_pic_back'         => '证件反面',
            'personhand_identity_pic'   => '手持证件照',
            'business_licence_pic'      => '营业执照电子版',
            'longitude'                 => '经度',
            'latitude'                  => '纬度',
        );
         
        foreach ($edit_fields as $field_key => $field_name) {
            if ($store_info[$field_key] != $data[$field_key]) {
                if ($field_key == 'cat_id') {
                    $store_info[$field_key] = RC_DB::table('store_category')->where('cat_id', $store_info[$field_key])->pluck('cat_name');
                    $data[$field_key]       = RC_DB::table('store_category')->where('cat_id', $data[$field_key])->pluck('cat_name');
                } else if ($field_key == 'identity_type') {
                    $store_info[$field_key] = $store_info[$field_key] == 1  ? '身份证' : ($store_info[$field_key] == 2 ? '护照' : '港澳身份证');
                    $data[$field_key]       = $data[$field_key] == 1        ? '身份证' : ($data[$field_key] == 2       ? '护照' : '港澳身份证');
                } else if ( in_array($field_key, array('province', 'city', 'district'))) {
                    $store_info[$field_key] = ecjia_region::instance()->region_name($store_info[$field_key]);
                    $data[$field_key]       = ecjia_region::instance()->region_name($data[$field_key]);
                } else if ( in_array($field_key, array('identity_pic_front', 'identity_pic_back', 'personhand_identity_pic', 'business_licence_pic'))) {
                    $store_info[$field_key] = $store_info[$field_key] ? '<图片已删除>'                               : '<em><空></em>';
                    $data[$field_key]       = $data[$field_key]       ? RC_Upload::upload_url($data[$field_key])  	: '<em><空></em>';
                }
                $log_original[$field_key] = array('name'=>$field_name, 'value'=> (is_null($store_info[$field_key]) || $store_info[$field_key] == '') ? '<em><空></em>' : $store_info[$field_key]);
                $log_new[$field_key]      = array('name'=>$field_name, 'value'=> (is_null($data[$field_key])       || $data[$field_key] == '')       ? '<em><空></em>' : $data[$field_key]);
            }
        }
         
        $log = array(
            'store_id' 		=> $store_info['id'],
            'type' 			=> 1,
            'name' 			=> $data['responsible_person'],
            'original_data' => serialize($log_original),
            'new_data' 		=> serialize($log_new),
            'info' 			=> '申请入驻信息修改',
        );
    }
     
    RC_Api::api('store', 'add_check_log', $log);
}

//end