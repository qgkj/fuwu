<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class sms_installer extends ecjia_installer {
    
    protected $dependent = array(
    	'ecjia.system'    => '1.0',
        'ecjia.promotion' => '1.0',
    );
    
    public function __construct() {
        $id = 'ecjia.bonus';
        parent::__construct($id);
    }
    
    
    public function install() {
        $table_name = 'sms_sendlist';
        if (!RC_Model::make()->table_exists($table_name)) {
            $schemes = array(
            	"`id` MEDIUMINT(8) NOT NULL AUTO_INCREMENT",
                "`mobile` VARCHAR(100) NOT NULL",
                "`template_id` MEDIUMINT(8) NOT NULL",
                "`sms_content` TEXT NOT NULL",
                "`error` TINYINT(1) NOT NULL DEFAULT '0'",
                "`pri` TINYINT(10) NOT NULL",
                "`last_send` INT(10) NOT NULL",
                "PRIMARY KEY (`id`)"
            );
            
            RC_Model::make()->create_table($table_name, $schemes);
        }
        
        if (!ecjia::config('sms_user_name', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', 'sms_user_name', '', array('type' => 'hidden'));
        }
        if (!ecjia::config('sms_password', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('hidden', 'sms_password', '', array('type' => 'hidden'));
        }
        
        if (!ecjia::config('sms_user_signin', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('sms', 'sms_user_signin', 0, array('type' => 'select', 'store_range' => '1,0'));
        }
        if (!ecjia::config('sms_order_shipped', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('sms', 'sms_order_shipped', 0, array('type' => 'select', 'store_range' => '1,0'));
        }
        if (!ecjia::config('sms_order_payed', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('sms', 'sms_order_payed', 0, array('type' => 'select', 'store_range' => '1,0'));
        }
        if (!ecjia::config('sms_order_placed', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('sms', 'sms_order_placed', 0, array('type' => 'select', 'store_range' => '1,0'));
        }
        if (!ecjia::config('sms_shop_mobile', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->insert_config('sms', 'sms_shop_mobile', 0, array('type' => 'select', 'store_range' => '1,0'));
        }
        /* 收货短信码*/
        if (!ecjia::config('sms_receipt_verification', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->insert_config('sms', 'sms_receipt_verification', 0, array('type' => 'select', 'store_range' => '1,0'));
        }
        $template_code = RC_Model::model('sms/mail_templates_model')->get_field('template_code', true);
        /* 收货短信码*/
        if (!in_array('sms_receipt_verification', $template_code)) {
        		$data = array(
        		'template_code' => 'sms_receipt_verification',	
        		'is_html' => 0,
        		'template_subject' => '订单收货验证码',
        		'template_content' => '尊敬的{$user_name} ，您在我们网站已成功下单。订单号：{$order_sn}，收货验证码为：{$code}。请保管好您的验证码，以便收货验证。',
        		'last_modify' => RC_Time::gmtime(),
        		'last_send' => 0,
        		'type' => 'sms'
        	);
        	RC_Model::model('sms/mail_templates_model')->insert($data);
        }
       	
        /*手机发送验证码*/
        if (!in_array('sms_get_validate', $template_code)) {
        	$data = array(
        		'template_code' => 'sms_get_validate',	
        		'is_html' => 0,
        		'template_subject' => '获取验证码',
        		'template_content' => '您的校验码是：{$code}，请在页面中输入以完成验证。如非本人操作，请忽略本短信。如有问题请拨打客服电话：{$service_phone}。',
        		'last_modify' => RC_Time::gmtime(),
        		'last_send' => 0,
        		'type' => 'sms'
        	);
        	RC_Model::model('sms/mail_templates_model')->insert($data);
        }
        /*新订单短信提醒*/
        if (!in_array('order_placed_sms', $template_code)) {
        	$data = array(
        			'template_code' => 'order_placed_sms',
        			'is_html' => 0,
        			'template_subject' => '新订单短信提醒（客户下订单时给商家发短信）',
        			'template_content' => '有客户下单啦！快去看看吧！订单编号：{$order.order_sn}，收货人：{$order.consignee}，联系电话{$order.mobile}，订单金额{$order.order_amount}。',
        			'last_modify' => RC_Time::gmtime(),
        			'last_send' => 0,
        			'type' => 'sms'
        	);
        	RC_Model::model('sms/mail_templates_model')->insert($data);
        }
        /*订单付款短信通知*/
        if (!in_array('order_payed_sms', $template_code)) {
        	$data = array(
        			'template_code' => 'order_payed_sms',
        			'is_html' => 0,
        			'template_subject' => '订单付款短信通知 (客户付款时给商家发短信)',
        			'template_content' => '订单编号：{$order.order_sn} 已付款。 收货人：{$order.consignee}，联系电话{$order.mobile}，订单金额{$order.order_amount}。',
        			'last_modify' => RC_Time::gmtime(),
        			'last_send' => 0,
        			'type' => 'sms'
        	);
        	RC_Model::model('sms/mail_templates_model')->insert($data);
        }
    
        /*发货短信通知*/
        if (!in_array('order_shipped_sms', $template_code)) {
        	$data = array(
        			'template_code' => 'order_shipped_sms',
        			'is_html' => 0,
        			'template_subject' => '发货短信通知 (商家发货时给客户发短信)',
        			'template_content' => '您的订单：{$order.order_sn} ，已于{$delivery_time} 通过{$order.shipping_name}进行发货。发货单号为：{$order.invoice_no}，请注意查收。',
        			'last_modify' => RC_Time::gmtime(),
        			'last_send' => 0,
        			'type' => 'sms'
        	);
        	RC_Model::model('sms/mail_templates_model')->insert($data);
        }
        
        /*修改邮箱邮件通知模板*/
        if (!in_array('email_verifying_authentication', $template_code)) {
        	$data = array(
        			'template_code' => 'email_verifying_authentication',
        			'is_html' => 1,
        			'template_subject' => '验证用户发送邮箱验证码',
        			'template_content' => '{$user_name}您好！<br/><br/>这封邮件是 {$shop_name} 发送的。您正在进行{$action}，需要进行验证，验证码为：{$code}，如有问题请拨打客服电话{$service_phone}。<br/><p><br/></p><br/><br/>{$shop_name}<br/>{$send_date}',
        			'last_modify' => RC_Time::gmtime(),
        			'last_send' => 0,
        			'type' => 'template'
        	);
        	RC_Model::model('sms/mail_templates_model')->insert($data);
        }
        
        return true;
    }
    
    
    public function uninstall() {
        $table_name = 'sms_sendlist';
        if (RC_Model::make()->table_exists($table_name)) {
           RC_Model::make()->drop_table($table_name);
        }
        
        if (ecjia::config('sms_user_name', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('sms_user_name');
        }
        if (ecjia::config('sms_password', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('sms_password');
        }
        
        if (ecjia::config('sms_user_signin', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('sms_user_signin');
        }
        if (ecjia::config('sms_order_shipped', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('sms_order_shipped');
        }
        if (ecjia::config('sms_order_payed', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('sms_order_payed');
        }
        if (ecjia::config('sms_order_placed', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('sms_order_placed');
        }
        if (ecjia::config('sms_shop_mobile', ecjia::CONFIG_CHECK)) {
            ecjia_config::instance()->delete_config('sms_shop_mobile');
        }
        /* 收货短信码*/
        if (ecjia::config('sms_receipt_verification', ecjia::CONFIG_CHECK)) {
        	ecjia_config::instance()->delete_config('sms_receipt_verification');
        }
        RC_Model::model('sms/mail_templates_model')->where(array('type' => 'sms'))->delete();
        
        return true;
    }
    
}

// end