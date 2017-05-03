<?php

defined('IN_ECJIA') or exit('No permission resources.');

class system_hooks {
		
	static public function admin_dashboard_header_links() {
		echo <<<EOF
		<a data-toggle="modal" data-backdrop="static" href="index.php-uid=1&page=dashboard.html#myMail" class="label ttip_b" title="New messages">25 <i class="splashy-mail_light"></i></a>
		<a data-toggle="modal" data-backdrop="static" href="index.php-uid=1&page=dashboard.html#myTasks" class="label ttip_b" title="New tasks">10 <i class="splashy-calendar_week"></i></a>
EOF;
	}
	
	static public function admin_dashboard_header_codes() {
		echo <<<EOF
	<div class="modal hide fade" id="myMail">
		<div class="modal-header">
			<button class="close" data-dismiss="modal">×</button>
			<h3>New messages</h3>
		</div>
		<div class="modal-body">
			<div class="alert alert-info">In this table jquery plugin turns a table row into a clickable link.</div>
			<table class="table table-condensed table-striped" data-provides="rowlink">
				<thead>
					<tr>
						<th>Sender</th>
						<th>Subject</th>
						<th>Date</th>
						<th>Size</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Declan Pamphlett</td>
						<td><a href="javascript:void(0)">Lorem ipsum dolor sit amet</a></td>
						<td>23/05/2012</td>
						<td>25KB</td>
					</tr>
					<tr>
						<td>Erin Church</td>
						<td><a href="javascript:void(0)">Lorem ipsum dolor sit amet</a></td>
						<td>24/05/2012</td>
						<td>15KB</td>
					</tr>
					<tr>
						<td>Koby Auld</td>
						<td><a href="javascript:void(0)">Lorem ipsum dolor sit amet</a></td>
						<td>25/05/2012</td>
						<td>28KB</td>
					</tr>
					<tr>
						<td>Anthony Pound</td>
						<td><a href="javascript:void(0)">Lorem ipsum dolor sit amet</a></td>
						<td>25/05/2012</td>
						<td>33KB</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="modal-footer">
			<a href="javascript:void(0)" class="btn">Go to mailbox</a>
		</div>
	</div>
	<div class="modal hide fade" id="myTasks">
		<div class="modal-header">
			<button class="close" data-dismiss="modal">×</button>
			<h3>New Tasks</h3>
		</div>
		<div class="modal-body">
			<div class="alert alert-info">In this table jquery plugin turns a table row into a clickable link.</div>
			<table class="table table-condensed table-striped" data-provides="rowlink">
				<thead>
					<tr>
						<th>id</th>
						<th>Summary</th>
						<th>Updated</th>
						<th>Priority</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>P-23</td>
						<td><a href="javascript:void(0)">Admin should not break if URL&hellip;</a></td>
						<td>23/05/2012</td>
						<td class="tac"><span class="label label-important">High</span></td>
						<td>Open</td>
					</tr>
					<tr>
						<td>P-18</td>
						<td><a href="javascript:void(0)">Displaying submenus in custom&hellip;</a></td>
						<td>22/05/2012</td>
						<td class="tac"><span class="label label-warning">Medium</span></td>
						<td>Reopen</td>
					</tr>
					<tr>
						<td>P-25</td>
						<td><a href="javascript:void(0)">Featured image on post types&hellip;</a></td>
						<td>22/05/2012</td>
						<td class="tac"><span class="label label-success">Low</span></td>
						<td>Updated</td>
					</tr>
					<tr>
						<td>P-10</td>
						<td><a href="javascript:void(0)">Multiple feed fixes and&hellip;</a></td>
						<td>17/05/2012</td>
						<td class="tac"><span class="label label-warning">Medium</span></td>
						<td>Open</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="modal-footer">
			<a href="javascript:void(0)" class="btn">Go to task manager</a>
		</div>
	</div>	
EOF;
	}
	
	
	public static function admin_dashboard_left_1() {
		$title = __('管理员留言');

		$chat_list = RC_Cache::app_cache_get('admin_dashboard_admin_message', 'system');
		if (! $chat_list) {
		    $chat_list = ecjia_admin_message::get_admin_chat(array('page_size' => 5));
		    RC_Cache::app_cache_set('admin_dashboard_admin_message', $chat_list, 'system', 15);
		}
		ecjia_admin::$controller->assign('title'			, $title);
		ecjia_admin::$controller->assign('msg_lists'		, $chat_list['item']);
		ecjia_admin::$controller->display('library/widget_admin_dashboard_messagelist.lbi');
	}
	
	
	public static function admin_dashboard_right_1() {
		if (!ecjia_admin::$controller->admin_priv('logs_manage', ecjia::MSGTYPE_HTML, false)) {
			return false;
		}
		
	    $title = __('操作日志');
	    $data = RC_Cache::app_cache_get('admin_dashboard_admin_log', 'system');
	    if (!$data) {
	        $data = RC_DB::table('admin_log')->select('admin_log.*', 'admin_user.user_name')->leftJoin('admin_user', 'admin_log.user_id', '=', 'admin_user.user_id')->orderBy('log_id', 'desc')->take(5)->get();
	        RC_Cache::app_cache_set('admin_dashboard_admin_log', $data, 'system', 30);
	    }

	    ecjia_admin::$controller->assign('title'	  , $title);
	    ecjia_admin::$controller->assign('log_lists'  , $data);
	    ecjia_admin::$controller->display('library/widget_admin_dashboard_loglist.lbi');
	}
	
	// public static function admin_dashboard_right_2() {
	//     $title = __('产品新闻');
	    
	//     $product_news = ecjia_utility::site_admin_news();
 //        if (! empty($product_news)) {
 //            ecjia_admin::$controller->assign('title'	  , $title);
 //            ecjia_admin::$controller->assign('product_news'  , $product_news);
 //            ecjia_admin::$controller->display('library/widget_admin_dashboard_product_news.lbi');
 //        }	    
	// }
	
	/**
	 * 添加后台左侧边栏信息
	 */
	public static function admin_sidebar_info() {
		$cache_key = 'admin_remind_sidebar';
		$remind = RC_Cache::userdata_cache_get($cache_key, $_SESSION['admin_id'], true);

		if (empty($remind)) {
			$remind = array();
			
			/*注册用户*/
			$validate_app_user = ecjia_app::validate_application('user');
			if (!is_ecjia_error($validate_app_user)) {
				$remind_user = RC_Api::api('user', 'remind_user');
				
				$new_user_count = (!empty($remind_user['new_user_count']) && is_numeric($remind_user['new_user_count'])) ? $remind_user['new_user_count'] : 0;
				
				$remind[] = array(
						'label' => __('新注册用户'),
						'total' => $new_user_count,
						'style' => 'danger',
				);
			}
			
			/*留言*/
			$validate_app_feedback = ecjia_app::validate_application('feedback');
			if (!is_ecjia_error($validate_app_feedback)) {
				$remind_message = RC_Api::api('feedback', 'remind_feedback');
				
				$message_count = (!empty($remind_message['message_count']) && is_numeric($remind_message['message_count'])) ? $remind_message['message_count'] : 0;
				
				$remind[] = array(
						'label' => __('新手机咨询'),
						'total' => $message_count,
						'style' => 'warning',
				);
			}
			
			/*订单*/
			$validate_app_order = ecjia_app::validate_application('orders');
			if (!is_ecjia_error($validate_app_order)) {
				$remind_order = RC_Api::api('orders', 'remind_order');
				
				$new_orders = (!empty($remind_order['new_orders']) && is_numeric($remind_order['new_orders'])) ? $remind_order['new_orders'] : 0;
				
				$remind[] = array(
						'label' => __('新订单'),
						'total' =>  $new_orders,
						'style' => 'success',
				);
			}
			
			RC_Cache::userdata_cache_set($cache_key, $remind, $_SESSION['admin_id'], true, 5);
		}
		
		if (! empty($remind)) {
			ecjia_admin::$controller->assign('remind'  , $remind);
			ecjia_admin::$controller->display('library/widget_admin_dashboard_remind_sidebar.lbi');
		}

	}
	
	
}


RC_Hook::add_action('admin_sidebar_info', array('system_hooks', 'admin_sidebar_info'));
RC_Hook::add_action( 'admin_dashboard_left', array('system_hooks', 'admin_dashboard_left_1') );
RC_Hook::add_action( 'admin_dashboard_right', array('system_hooks', 'admin_dashboard_right_1') );
RC_Hook::add_action( 'admin_dashboard_right', array('system_hooks', 'admin_dashboard_right_2') );

// RC_Hook::add_action( 'admin_dashboard_header_links', array('system_hooks', 'admin_dashboard_header_links') );

// RC_Hook::add_action( 'admin_dashboard_header_codes', array('system_hooks', 'admin_dashboard_header_codes') );


// end