<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 消息推送通知管理类
 * @author royalwang
 */
class push_notification {
	protected $appkey           = NULL; 
	protected $appMasterSecret  = NULL;
	protected $timestamp        = NULL;
	protected $validation_token = NULL;
	
	protected $debug            = true;
	
	protected $push_content     = NULL;
	protected $custom_fields    = array();
	protected $push_description = NULL;
	protected $device_tokens    = array();

	public function __construct($key, $secret) {
		$this->appkey = $key;
		$this->appMasterSecret = $secret;
		$this->timestamp = strval(time());
		
		if (!ecjia::config('app_push_development')) {
		    $this->debug = false;
		} else {
		    $this->debug = true;
		}
		
		RC_Loader::load_app_class('notification.android.AndroidBroadcast', 'push', false);
		RC_Loader::load_app_class('notification.android.AndroidFilecast', 'push', false);
		RC_Loader::load_app_class('notification.android.AndroidFilecast', 'push', false);
		RC_Loader::load_app_class('notification.android.AndroidUnicast', 'push', false);
		RC_Loader::load_app_class('notification.android.AndroidCustomizedcast', 'push', false);
		RC_Loader::load_app_class('notification.ios.IOSBroadcast', 'push', false);
		RC_Loader::load_app_class('notification.ios.IOSFilecast', 'push', false);
		RC_Loader::load_app_class('notification.ios.IOSGroupcast', 'push', false);
		RC_Loader::load_app_class('notification.ios.IOSUnicast', 'push', false);
		RC_Loader::load_app_class('notification.ios.IOSCustomizedcast', 'push', false);
	}
	
	/**
	 * 添加内容
	 * @param unknown $content
	 */
	public function addContent($description, $content) {
	    $this->push_description = $description;
	    $this->push_content = $content;
	    return $this;
	}
	
	/**
	 * 添加自定义字段
	 * @param array $field
	 */
	public function addField(array $field) {
	    $this->custom_fields = $field;
	    return $this;
	}
	
	public function addDeviceToken($device_token) {
	    if (is_string($device_token)) {
	        $this->device_tokens[] = $device_token;
	    } elseif (is_array($device_token)) {
	        $this->device_tokens = array_merge($this->device_tokens, $device_token);
	    }
	    
	    return $this;
	}

	/**
	 * 发送android广播消息
	 */
	public function sendAndroidBroadcast() {
		try {
		    if (!$this->push_content) {
		        throw new Exception(__('推送消息的内容不能为空'));
		    }
		    
			$brocast = new AndroidBroadcast();
			$brocast->setAppMasterSecret($this->appMasterSecret);
			$brocast->setPredefinedKeyValue("appkey",           $this->appkey);
			$brocast->setPredefinedKeyValue("timestamp",        $this->timestamp);
			$brocast->setPredefinedKeyValue("title",            ecjia::config('app_name'));
			$brocast->setPredefinedKeyValue("after_open",       "go_app");
			
			$brocast->setPredefinedKeyValue("description",      $this->push_description);
			$brocast->setPredefinedKeyValue("ticker",           $this->push_content);
			$brocast->setPredefinedKeyValue("text",             $this->push_content);
			// Set 'production_mode' to 'false' if it's a test device. 
			// For how to register a test device, please see the developer doc.
			if ($this->debug) {
			    $brocast->setPredefinedKeyValue("production_mode", "false");
			} else {
			    $brocast->setPredefinedKeyValue("production_mode", "true");
			}
			// [optional]Set extra fields
			if (is_array($this->custom_fields)) {
			    foreach ($this->custom_fields as $key => $value) {
			        $brocast->setExtraField($key, $value);
			    }
			}

			return $brocast->send();
		} catch (Exception $e) {
			return new ecjia_error('send_android_broadcast_error', $e->getMessage());
		}
	}

	/**
	 * 发送android单播消息
	 */
	public function sendAndroidUnicast() {
		try {
			$unicast = new AndroidUnicast();
			$unicast->setAppMasterSecret($this->appMasterSecret);
			$unicast->setPredefinedKeyValue("appkey",           $this->appkey);
			$unicast->setPredefinedKeyValue("timestamp",        $this->timestamp);
			$unicast->setPredefinedKeyValue("title",            ecjia::config('app_name'));
			$unicast->setPredefinedKeyValue("after_open",       "go_app");

			$unicast->setPredefinedKeyValue("description",      $this->push_description);
			
			$unicast->setPredefinedKeyValue("ticker",           $this->push_content);
			$unicast->setPredefinedKeyValue("text",             $this->push_content);
			
			if ($this->device_tokens) {
			    // Set your device tokens here
			    $unicast->setPredefinedKeyValue("device_tokens",    implode(',', $this->device_tokens));
			}
			
			// Set 'production_mode' to 'false' if it's a test device. 
			// For how to register a test device, please see the developer doc.
		    if ($this->debug) {
			    $unicast->setPredefinedKeyValue("production_mode", "false");
			} else {
			    $unicast->setPredefinedKeyValue("production_mode", "true");
			}
			// Set extra fields
			if ($this->custom_fields) {
			    foreach ($this->custom_fields as $key => $value) {
			        $unicast->setExtraField($key, $value);
			    }
			}

			return $unicast->send();
		} catch (Exception $e) {
			return new ecjia_error('send_android_unicast_error', $e->getMessage());
		}
	}

	/**
	 * 发送android文件广播
	 */
	public function sendAndroidFilecast() {
		try {
			$filecast = new AndroidFilecast();
			$filecast->setAppMasterSecret($this->appMasterSecret);
			$filecast->setPredefinedKeyValue("appkey",           $this->appkey);
			$filecast->setPredefinedKeyValue("timestamp",        $this->timestamp);
			$filecast->setPredefinedKeyValue("ticker",           "Android filecast ticker");
			$filecast->setPredefinedKeyValue("title",            "Android filecast title");
			$filecast->setPredefinedKeyValue("text",             "Android filecast text");
			$filecast->setPredefinedKeyValue("after_open",       "go_app");  //go to app
			print("Uploading file contents, please wait...\r\n");
			// Upload your device tokens, and use '\n' to split them if there are multiple tokens
			$filecast->uploadContents("aa"."\n"."bb");
			print("Sending filecast notification, please wait...\r\n");
			$filecast->send();
			print("Sent SUCCESS\r\n");
		} catch (Exception $e) {
			return new ecjia_error('send_android_filecast_error', $e->getMessage());
		}
	}

	/**
	 * 发送android群组广播
	 */
	public function sendAndroidGroupcast() {
		try {
			/* 
		 	 *  Construct the filter condition:
		 	 *  "where": 
		 	 *	{
    	 	 *		"and": 
    	 	 *		[
      	 	 *			{"tag":"test"},
      	 	 *			{"tag":"Test"}
    	 	 *		]
		 	 *	}
		 	 */
			$filter = array(
				"where" => array(
		    		"and" =>  array(
	    				array(
     						"tag" => "test"
						),
	     				array(
     						"tag" => "Test"
	     				)
	     		 	)
		   		)
		  	);
					  
			$groupcast = new AndroidGroupcast();
			$groupcast->setAppMasterSecret($this->appMasterSecret);
			$groupcast->setPredefinedKeyValue("appkey",           $this->appkey);
			$groupcast->setPredefinedKeyValue("timestamp",        $this->timestamp);
			// Set the filter condition
			$groupcast->setPredefinedKeyValue("filter",           $filter);
			$groupcast->setPredefinedKeyValue("ticker",           "Android groupcast ticker");
			$groupcast->setPredefinedKeyValue("title",            "Android groupcast title");
			$groupcast->setPredefinedKeyValue("text",             "Android groupcast text");
			$groupcast->setPredefinedKeyValue("after_open",       "go_app");
			// Set 'production_mode' to 'false' if it's a test device. 
			// For how to register a test device, please see the developer doc.
			$groupcast->setPredefinedKeyValue("production_mode", "true");
			print("Sending groupcast notification, please wait...\r\n");
			$groupcast->send();
			print("Sent SUCCESS\r\n");
		} catch (Exception $e) {
			return new ecjia_error('send_android_groupcast_error', $e->getMessage());
		}
	}

	/**
	 * 发送android消息自定义接受范围
	 */
	public function sendAndroidCustomizedcast() {
		try {
			$customizedcast = new AndroidCustomizedcast();
			$customizedcast->setAppMasterSecret($this->appMasterSecret);
			$customizedcast->setPredefinedKeyValue("appkey",           $this->appkey);
			$customizedcast->setPredefinedKeyValue("timestamp",        $this->timestamp);
			// Set your alias here, and use comma to split them if there are multiple alias.
			// And if you have many alias, you can also upload a file containing these alias, then 
			// use file_id to send customized notification.
			$customizedcast->setPredefinedKeyValue("alias",            "xx");
			// Set your alias_type here
			$customizedcast->setPredefinedKeyValue("alias_type",       "xx");
			$customizedcast->setPredefinedKeyValue("ticker",           "Android customizedcast ticker");
			$customizedcast->setPredefinedKeyValue("title",            "Android customizedcast title");
			$customizedcast->setPredefinedKeyValue("text",             "Android customizedcast text");
			$customizedcast->setPredefinedKeyValue("after_open",       "go_app");
			print("Sending customizedcast notification, please wait...\r\n");
			$customizedcast->send();
			print("Sent SUCCESS\r\n");
		} catch (Exception $e) {
			return new ecjia_error('send_android_customizedcast_error', $e->getMessage());
		}
	}

	/**
	 * 发送iOS广播消息
	 */
	public function sendIOSBroadcast() {
		try {
			$brocast = new IOSBroadcast();
			$brocast->setAppMasterSecret($this->appMasterSecret);
			$brocast->setPredefinedKeyValue("appkey",           $this->appkey);
			$brocast->setPredefinedKeyValue("timestamp",        $this->timestamp);

			$brocast->setPredefinedKeyValue("description",      $this->push_description);
			$brocast->setPredefinedKeyValue("alert",            $this->push_content);
			$brocast->setPredefinedKeyValue("badge", 1);
			$brocast->setPredefinedKeyValue("sound", "chime");
			// Set 'production_mode' to 'true' if your app is under production mode
			if ($this->debug) {
			    $brocast->setPredefinedKeyValue("production_mode", "false");
			} else {
			    $brocast->setPredefinedKeyValue("production_mode", "true");
			}
			// Set customized fields
			if (is_array($this->custom_fields)) {
			    foreach ($this->custom_fields as $key => $value) {
			        $brocast->setCustomizedField($key, $value);
			    }
			}
			return $brocast->send();
		} catch (Exception $e) {
			return new ecjia_error('send_ios_broadcast_error', $e->getMessage());
		}
	}

	/**
	 * 发送iOS单播消息
	 */
	public function sendIOSUnicast() {
		try {
			$unicast = new IOSUnicast();
			$unicast->setAppMasterSecret($this->appMasterSecret);
			$unicast->setPredefinedKeyValue("appkey",           $this->appkey);
			$unicast->setPredefinedKeyValue("timestamp",        $this->timestamp);
			// Set your device tokens here
			if ($this->device_tokens) {
			    // Set your device tokens here
			    $unicast->setPredefinedKeyValue("device_tokens", implode(',', $this->device_tokens));
			}

			$unicast->setPredefinedKeyValue("description",      $this->push_description);
			$unicast->setPredefinedKeyValue("alert",            $this->push_content);
			$unicast->setPredefinedKeyValue("badge", 1);
			$unicast->setPredefinedKeyValue("sound", "chime");
			// Set 'production_mode' to 'true' if your app is under production mode
		    if ($this->debug) {
			    $unicast->setPredefinedKeyValue("production_mode", "false");
			} else {
			    $unicast->setPredefinedKeyValue("production_mode", "true");
			}
			// Set customized fields
		    if (is_array($this->custom_fields)) {
			    foreach ($this->custom_fields as $key => $value) {
			        $unicast->setCustomizedField($key, $value);
			    }
			}
			return $unicast->send();
		} catch (Exception $e) {
			return new ecjia_error('send_ios_unicast_error', $e->getMessage());
		}
	}

	/**
	 * 发送iOS文件广播
	 */
	public function sendIOSFilecast() {
		try {
			$filecast = new IOSFilecast();
			$filecast->setAppMasterSecret($this->appMasterSecret);
			$filecast->setPredefinedKeyValue("appkey",           $this->appkey);
			$filecast->setPredefinedKeyValue("timestamp",        $this->timestamp);

			$filecast->setPredefinedKeyValue("alert", "IOS 文件播测试");
			$filecast->setPredefinedKeyValue("badge", 0);
			$filecast->setPredefinedKeyValue("sound", "chime");
			// Set 'production_mode' to 'true' if your app is under production mode
			$filecast->setPredefinedKeyValue("production_mode", "false");
			print("Uploading file contents, please wait...\r\n");
			// Upload your device tokens, and use '\n' to split them if there are multiple tokens
			$filecast->uploadContents("aa"."\n"."bb");
			print("Sending filecast notification, please wait...\r\n");
			$filecast->send();
			print("Sent SUCCESS\r\n");
		} catch (Exception $e) {
			return new ecjia_error('send_ios_filecast_error', $e->getMessage());
		}
	}

	/**
	 * 发送iOS群组广播
	 */
	public function sendIOSGroupcast() {
		try {
			/* 
		 	 *  Construct the filter condition:
		 	 *  "where": 
		 	 *	{
    	 	 *		"and": 
    	 	 *		[
      	 	 *			{"tag":"iostest"}
    	 	 *		]
		 	 *	}
		 	 */
			$filter = 	array(
				"where" => array(
		    		"and" => array(
	    				array(
     						"tag" => "iostest"
						)
		     		)
		   		)
		  	);
					  
			$groupcast = new IOSGroupcast();
			$groupcast->setAppMasterSecret($this->appMasterSecret);
			$groupcast->setPredefinedKeyValue("appkey",           $this->appkey);
			$groupcast->setPredefinedKeyValue("timestamp",        $this->timestamp);
			// Set the filter condition
			$groupcast->setPredefinedKeyValue("filter",           $filter);
			$groupcast->setPredefinedKeyValue("alert", "IOS 组播测试");
			$groupcast->setPredefinedKeyValue("badge", 0);
			$groupcast->setPredefinedKeyValue("sound", "chime");
			// Set 'production_mode' to 'true' if your app is under production mode
			$groupcast->setPredefinedKeyValue("production_mode", "false");
			print("Sending groupcast notification, please wait...\r\n");
			$groupcast->send();
			print("Sent SUCCESS\r\n");
		} catch (Exception $e) {
			return new ecjia_error('send_ios_groupcast_error', $e->getMessage());
		}
	}

	/**
	 * 发送iOS消息自定义接受范围
	 */
	public function sendIOSCustomizedcast() {
		try {
			$customizedcast = new IOSCustomizedcast();
			$customizedcast->setAppMasterSecret($this->appMasterSecret);
			$customizedcast->setPredefinedKeyValue("appkey",           $this->appkey);
			$customizedcast->setPredefinedKeyValue("timestamp",        $this->timestamp);

			// Set your alias here, and use comma to split them if there are multiple alias.
			// And if you have many alias, you can also upload a file containing these alias, then 
			// use file_id to send customized notification.
			$customizedcast->setPredefinedKeyValue("alias", "xx");
			// Set your alias_type here
			$customizedcast->setPredefinedKeyValue("alias_type", "xx");
			$customizedcast->setPredefinedKeyValue("alert", "IOS 个性化测试");
			$customizedcast->setPredefinedKeyValue("badge", 0);
			$customizedcast->setPredefinedKeyValue("sound", "chime");
			// Set 'production_mode' to 'true' if your app is under production mode
			$customizedcast->setPredefinedKeyValue("production_mode", "false");
			print("Sending customizedcast notification, please wait...\r\n");
			$customizedcast->send();
			print("Sent SUCCESS\r\n");
		} catch (Exception $e) {
			return new ecjia_error('send_ios_customizedcast_error', $e->getMessage());
		}
	}
}

// end