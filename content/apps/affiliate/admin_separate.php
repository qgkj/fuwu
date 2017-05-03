<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 分成管理
 * @author wutifang
 */
class admin_separate extends ecjia_admin {
	private $db_order_info;
	private $db_affiliate_log;
	private $db_order_infoview;
	
	public function __construct() {
		parent::__construct();
		
		RC_Loader::load_app_func('global');
		assign_adminlog_content();
		
		$this->db_order_info 		= RC_Loader::load_app_model('affiliate_order_info_model');
		$this->db_affiliate_log 	= RC_Loader::load_app_model('affiliate_log_model');
		$this->db_order_infoview 	= RC_Loader::load_app_model('affiliate_order_info_viewmodel');
		
		/* 加载所有全局 js/css */
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');
		RC_Script::enqueue_script('bootstrap-editable-script', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/js/bootstrap-editable.min.js'));
		RC_Style::enqueue_style('bootstrap-editable-css', RC_Uri::admin_url('statics/lib/x-editable/bootstrap-editable/css/bootstrap-editable.css'));
		RC_Script::enqueue_script('affiliate', RC_App::apps_url('statics/js/affiliate.js', __FILE__));
		
		$js_lang = array(
			'ok'		=> RC_Lang::get('affiliate::affiliate.ok'),
			'cancel'	=> RC_Lang::get('affiliate::affiliate.cancel'),
		);
		RC_Script::localize_script('affiliate', 'js_lang', $js_lang);
	}
	
	/**
	 * 分成管理列表页
	 */
	public function init() {
		$this->admin_priv('affiliate_ck_manage');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('affiliate::affiliate.sharing_management')));
		$this->assign('ur_here', RC_Lang::get('affiliate::affiliate.sharing_management'));
		
		$affiliate = unserialize(ecjia::config('affiliate'));
		empty($affiliate) && $affiliate = array();
		$separate_on = $affiliate['on'];
		$this->assign('on', $separate_on);
		
		$logdb = $this->get_affiliate_ck();
		$this->assign('logdb', $logdb);
		
		$this->assign('order_stats', RC_Lang::get('affiliate::affiliate_ck.order_stats'));
		$this->assign('sch_stats', RC_Lang::get('affiliate::affiliate_ck.sch_stats'));
		$this->assign('separate_by', RC_Lang::get('affiliate::affiliate_ck.separate_by'));
		$this->assign('search_action', RC_Uri::url('affiliate/admin_separate/init'));
		
		$this->display('affiliate_ck_list.dwt');
	}
	
	/**
	 * 分成
	 */
	public function admin_separate() {
		$this->admin_priv('affiliate_ck_update', ecjia::MSGTYPE_JSON);
	
		$affiliate = unserialize(ecjia::config('affiliate'));
		empty($affiliate) && $affiliate = array();
		$separate_by = $affiliate['config']['separate_by'];
		$oid = (int)$_GET['id'];
		$row = $this->db_order_infoview->order_info_find(array('o.order_id' => $oid), 'o.order_sn, o.is_separate, (o.goods_amount - o.discount) AS goods_amount, o.user_id');
		$order_sn = $row['order_sn'];
		
		if (empty($row['is_separate'])) {
			$affiliate['config']['level_point_all'] = (float)$affiliate['config']['level_point_all'];
			$affiliate['config']['level_money_all'] = (float)$affiliate['config']['level_money_all'];
			if ($affiliate['config']['level_point_all']) {
				$affiliate['config']['level_point_all'] /= 100;
			}
			if ($affiliate['config']['level_money_all']) {
				$affiliate['config']['level_money_all'] /= 100;
			}
			$money = round($affiliate['config']['level_money_all'] * $row['goods_amount'],2);
			$integral = RC_Api::api('orders', 'order_integral', array('order_id' => $oid, 'extension_code' => ''));
			
			$point = round($affiliate['config']['level_point_all'] * intval($integral['rank_points']), 0);
			if (empty($separate_by)) {
				//推荐注册分成
				$num = count($affiliate['item']);
				for ($i = 0; $i < $num; $i++) {
					$affiliate['item'][$i]['level_point'] = (float)$affiliate['item'][$i]['level_point'];
					$affiliate['item'][$i]['level_money'] = (float)$affiliate['item'][$i]['level_money'];
					if ($affiliate['item'][$i]['level_point']) {
						$affiliate['item'][$i]['level_point'] /= 100;
					}
					if ($affiliate['item'][$i]['level_money']) {
						$affiliate['item'][$i]['level_money'] /= 100;
					}
					$setmoney = round($money * $affiliate['item'][$i]['level_money'], 2);
					$setpoint = round($point * $affiliate['item'][$i]['level_point'], 0);
					
					$user_info = RC_Api::api('user', 'user_info', array('user_id' => $row['user_id']));
					$row = RC_Api::api('user', 'user_info', array('user_id' => $user_info['parent_id']));

					$up_uid = $row['user_id'];
					if (empty($up_uid) || empty($row['user_name'])) {
						break;
					} else {
						$info = sprintf(RC_Lang::get('affiliate::affiliate_ck.separate_info'), $order_sn, $setmoney, $setpoint);
						$arr = array(
							'user_id'		=> $up_uid,
							'user_money'	=> $setmoney,
							'frozen_money'	=> 0,
							'rank_points'	=> $setpoint,
							'pay_points'	=> 0,
							'change_desc'	=> $info
						);
						RC_Api::api('user', 'account_change_log', $arr);
						$this->db_affiliate_log->write_affiliate_log($oid, $up_uid, $row['user_name'], $setmoney, $setpoint, $separate_by);
					}
				}
			} else {
				//推荐订单分成
				$row = $this->db_order_infoview->join(array('users', 'affiliate_log'))->field('o.parent_id, u.user_name')->find(array('o.order_id' => $oid));
				$up_uid = $row['parent_id'];
				if (!empty($up_uid) && $up_uid > 0) {
					$info = sprintf(RC_Lang::get('affiliate::affiliate_ck.separate_info'), $order_sn, $money, $point);
					
					$arr = array(
						'user_id'		=> $up_uid,
						'user_money'	=> $money,
						'frozen_money'	=> 0,
						'rank_points'	=> $point,
						'pay_points'	=> 0,
						'change_desc'	=> $info
					);
					RC_Api::api('user', 'account_change_log', $arr);
					
					$this->db_affiliate_log->write_affiliate_log($oid, $up_uid, $row['user_name'], $money, $point, $separate_by);
				} else {
					return $this->showmessage(RC_Lang::get('affiliate::affiliate_ck.edit_fail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
				}
			}
			$data = array(
				'is_separate' => '1'
			);
			ecjia_admin::admin_log(RC_Lang::get('affiliate::affiliate_ck.order_sn_is').$order_sn, 'do', 'affiliate');
			$this->db_order_info->order_info_update(array('order_id' => $oid), $data);
		}
		return $this->showmessage(RC_Lang::get('affiliate::affiliate_ck.edit_ok'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 取消分成，不再能对该订单进行分成
	 */
	public function cancel() {
		$this->admin_priv('affiliate_ck_update', ecjia::MSGTYPE_JSON);
		
		$oid = (int)$_GET['id'];
		$info = $this->db_order_info->order_info_find(array('order_id' => $oid));
		
		if (empty($info['is_separate'])) {
			$data = array(
				'is_separate' => '2'
			);
			ecjia_admin::admin_log(RC_Lang::get('affiliate::affiliate_ck.order_sn_is').$info['order_sn'], 'cancel', 'affiliate');
			$this->db_order_info->order_info_update(array('order_id' => $oid), $data);
		}
		return $this->showmessage(RC_Lang::get('affiliate::affiliate_ck.cancel_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 撤销某次分成，将已分成的收回来
	 */
	public function rollback() {
		$this->admin_priv('affiliate_ck_update', ecjia::MSGTYPE_JSON);
		
		$logid = (int)$_GET['id'];
		$stat = $this->db_affiliate_log->affiliate_log_find(array('log_id' => $logid));
		if (!empty($stat)) {
			if ($stat['separate_type'] == 1) {
				//推荐订单分成
				$flag = -2;
			} else {
				//推荐注册分成
				$flag = -1;
			}
			$arr = array(
				'user_id'		=> $stat['user_id'],
				'user_money'	=> -$stat['money'],
				'frozen_money'	=> 0,
				'rank_points'	=> -$stat['point'],
				'pay_points'	=> 0,
				'change_desc'	=> RC_Lang::get('affiliate::affiliate_ck.loginfo.cancel')
			);
			RC_Api::api('user', 'account_change_log', $arr);
			$data = array(
				'separate_type' => $flag
			);
			$order_info = RC_Api::api('orders', 'order_info', array('order_id' => $stat['order_id'], 'order_sn' => ''));
			ecjia_admin::admin_log(RC_Lang::get('affiliate::affiliate_ck.order_sn_is').$order_info['order_sn'], 'rollback', 'affiliate');
			
			$this->db_affiliate_log->affiliate_log_update(array('log_id' => $logid), $data);
		}
		return $this->showmessage(RC_Lang::get('affiliate::affiliate_ck.rollback_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
	}
	
	/**
	 * 获取分成列表
	 *
	 * @return array
	 */
	private function get_affiliate_ck() {
		$db_order_infoview = RC_Loader::load_app_model('affiliate_order_info_viewmodel');
		$affiliate = unserialize(ecjia::config('affiliate'));
	
		empty($affiliate) && $affiliate = array();
		$separate_by = $affiliate['config']['separate_by'];
	
		$sqladd = '';
		if (isset($_GET['status'])) {
			$sqladd = ' AND o.is_separate = ' . (int)$_GET['status'];
			$filter['status'] = (int)$_GET['status'];
		}
	
		if (isset($_GET['order_sn'])) {
			$sqladd = ' AND o.order_sn LIKE \'%' . trim($_GET['order_sn']) . '%\'';
			$filter['order_sn'] = $_GET['order_sn'];
		}
	
		if (isset($_GET['auid'])) {
			$sqladd = ' AND a.user_id=' . $_GET['auid'];
		}
		
		$options['table'] = array('users', 'affiliate_log');
		if (!empty($affiliate['on'])) {
			if (empty($separate_by)) {
				$options['where'] = "o.user_id > 0 AND (u.parent_id > 0 AND o.is_separate = 0 OR o.is_separate > 0) $sqladd";
				$count = $db_order_infoview->order_info_count($options);
			} else {
				$options['where'] = "o.user_id > 0 AND (o.parent_id > 0 AND o.is_separate = 0 OR o.is_separate > 0) $sqladd";
				$count = $db_order_infoview->order_info_count($options);
			}
		} else {
			$options['where'] = "o.user_id > 0 AND o.is_separate > 0 $sqladd";
			$count = $db_order_infoview->order_info_count($options);
		}
		$page = new ecjia_page($count, 15, 5);
		$limit = $page->limit();
		$logdb = array();
	
		if (!empty($affiliate['on'])) {
			//开启
			if (empty($separate_by)) {
				//推荐注册分成
				$option = array(
					'table' => array('users', 'affiliate_log'),
					'field' => 'o.*, a.log_id, a.user_id as suid, a.user_name as auser, a.money, a.point, a.separate_type, u.parent_id as up',
					'where'	=> "o.user_id > 0 AND (u.parent_id > 0 AND o.is_separate = 0 OR o.is_separate > 0) $sqladd ",
					'order'	=> 'order_id desc',
					'limit'	=> $limit,
				);
			} else {
				//推荐订单分成
				$option = array(
					'table' => array('users', 'affiliate_log'),
					'field' => 'o.*, a.log_id, a.user_id as suid, a.user_name as auser, a.money, a.point, a.separate_type, u.parent_id as up',
					'where'	=> "o.user_id > 0 AND (o.parent_id > 0 AND o.is_separate = 0 OR o.is_separate > 0) $sqladd ",
					'order'	=> 'order_id desc',
					'limit'	=> $limit,
				);
			}
		} else {
			//关闭
			$option = array(
				'table' => array('users', 'affiliate_log'),
				'field' => 'o.*, a.log_id, a.user_id as suid, a.user_name as auser, a.money, a.point, a.separate_type, u.parent_id as up',
				'where'	=> "o.user_id > 0 AND o.is_separate > 0 $sqladd ",
				'order'	=> 'order_id desc',
				'limit'	=> $limit,
			);
		}
		$data = $db_order_infoview->order_info_select($option);

		if (!empty($data)) {
			foreach ($data as $rt) {
				if (empty($separate_by) && $rt['up'] > 0) {
					//按推荐注册分成
					$rt['separate_able'] = 1;
				} elseif (!empty($separate_by) && $rt['parent_id'] > 0) {
					//按推荐订单分成
					$rt['separate_able'] = 1;
				}
				if (!empty($rt['suid'])) {
					//在affiliate_log有记录
					$rt['info'] = sprintf(RC_Lang::get('affiliate::affiliate_ck.separate_info2'), $rt['suid'], $rt['auser'], $rt['money'], $rt['point']);
					if ($rt['separate_type'] == -1 || $rt['separate_type'] == -2) {
						//已被撤销
						$rt['is_separate'] = 3;
						$rt['info'] = "<s>" . $rt['info'] . "</s>";
					}
				}
				$logdb[] = $rt;
			}
		}
		return array('item' => $logdb, 'page' => $page->show(5), 'desc' => $page->page_desc(), 'current_page' => $page->current_page);
	}
}

//end