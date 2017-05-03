<?php
  
defined ( 'IN_ECJIA' ) or exit ( 'No permission resources.' );

/**
 * 文章及文章分类相关函数库
 */
function favourable_info($act_id) {
    $db = RC_Loader::load_app_model ( 'favourable_activity_model', 'favourable' );
	
    if (!empty($_SESSION['store_id'])){
        $row = $db->find ( array (
            'act_id'    => $act_id,
            'store_id'  => $_SESSION['store_id']
        ) );
    } else {
        $row = $db->find(array('act_id' => $act_id));
    }
	if (! empty ( $row )) {
		$row ['start_time']           = RC_Time::local_date ( ecjia::config ( 'time_format' ), $row ['start_time'] );
		$row ['end_time']             = RC_Time::local_date ( ecjia::config ( 'time_format' ), $row ['end_time'] );
		$row ['formated_min_amount']  = price_format ( $row ['min_amount'] );
		$row ['formated_max_amount']  = price_format ( $row ['max_amount'] );
		$row ['gift']                 = unserialize ( $row ['gift'] );
		if ($row ['act_type'] == FAT_GOODS) {
			$row ['act_type_ext'] = round ( $row ['act_type_ext'] );
		}
	}
	return $row;
}

/*
 * 管理员操作对象和动作
*/
function assign_adminlog_content(){
	ecjia_admin_log::instance()->add_object('discount', '优惠');
}

// end