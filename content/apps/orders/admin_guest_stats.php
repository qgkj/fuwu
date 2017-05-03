<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 客户统计
 */
class admin_guest_stats extends ecjia_admin {
	public function __construct() {
		parent::__construct();
		RC_Loader::load_app_func('global','orders');
		
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
	}
	/**
	 * 客户统计列表
	 */
	public function init() {
		$this->admin_priv('guest_stats');
		
		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('orders::statistic.guest_stats')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('orders::statistic.overview'),
			'content'	=> '<p>' . RC_Lang::get('orders::statistic.guest_stats_help') . '</p>'
		));
		
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('orders::statistic.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:客户统计" target="_blank">'. RC_Lang::get('orders::statistic.about_guest_stats') .'</a>') . '</p>'
		);
		
		$this->assign('ur_here', RC_Lang::get('orders::statistic.guest_stats'));
		$this->assign('action_link', array('text' => RC_Lang::get('orders::statistic.down_guest_stats'), 'href'=> RC_Uri::url('orders/admin_guest_stats/download')));
		
		/* 取得会员总数 */
		$res = RC_DB::table('users')->count();
		$user_num = $res;
		
 		/* 计算订单各种费用之和的语句 */
		$total_fee = " SUM(" . order_amount_field() . ") AS turnover ";
		
		/* 有过订单的会员数 */
		$have_order_usernum = RC_DB::table('order_info')->whereRaw(RC_DB::raw('user_id > 0' . order_query_sql('finished') .' AND is_delete = 0'))->count(RC_DB::raw('DISTINCT user_id'));
		
		/* 会员订单总数和订单总购物额 */
		$user_all_order = array();
		$user_all_order = RC_DB::table('order_info')->select(RC_DB::raw('COUNT(*) AS order_num , '.$total_fee.''))->whereRaw(RC_DB::raw('user_id > 0 ' . order_query_sql('finished') .' AND is_delete = 0'))->first();
		
		$user_all_order['turnover'] = floatval($user_all_order['turnover']);
		
		/* 赋值到模板 */
		$this->assign('user_num',            $user_num);                    // 会员总数
		$this->assign('have_order_usernum',  $have_order_usernum);          // 有过订单的会员数
		$this->assign('user_order_turnover', $user_all_order['order_num']); // 会员总订单数
		$this->assign('user_all_turnover',   price_format($user_all_order['turnover']));  //会员购物总额
		/* 每会员订单数 */
		$this->assign('ave_user_ordernum', $user_num > 0 ? sprintf("%0.2f", $user_all_order['order_num'] / $user_num) : 0);
		
		/* 每会员购物额 */
		$this->assign('ave_user_turnover', $user_num > 0 ? price_format($user_all_order['turnover'] / $user_num) : 0);
		/* 注册会员购买率 */
		$this->assign('user_ratio', sprintf("%0.2f", ($user_num > 0 ? $have_order_usernum / $user_num : 0) * 100));
		
		$this->assign_lang();
		$this->display('guest_stats.dwt');
	}
	
	/**
	 * 客户统计报表下载
	 */
	public function download() {
		/* 权限判断 */ 
		$this->admin_priv('guest_stats', ecjia::MSGTYPE_JSON);
		
		/* 取得会员总数 */
		$res = RC_DB::table('users')->count();
		$user_num = $res;
		
		/* 计算订单各种费用之和的语句 */
		$total_fee = " SUM(" . order_amount_field() . ") AS turnover ";
		
		/* 有过订单的会员数 */
		$have_order_usernum = RC_DB::table('order_info')->whereRaw(RC_DB::raw('user_id > 0' . order_query_sql('finished') .' AND is_delete = 0'))->count(RC_DB::raw('DISTINCT user_id'));

		/* 会员订单总数和订单总购物额 */
		$user_all_order = array();
		$user_all_order = RC_DB::table('order_info')->select(RC_DB::raw('COUNT(*) AS order_num , '.$total_fee.''))->whereRaw(RC_DB::raw('user_id > 0 ' . order_query_sql('finished') .' AND is_delete = 0'))->first();
		
		$user_all_order['turnover'] = floatval($user_all_order['turnover']);
		
		$filename = mb_convert_encoding(RC_Lang::get('orders::statistic.guest_statement').'-'.RC_Time::local_date('Y-m-d'),"GBK","UTF-8");
		header("Content-type: application/vnd.ms-excel;charset=utf-8");
		header("Content-Disposition:attachment;filename=$filename.xls");
		
		/* 生成会员购买率 */
		$data  = RC_Lang::get('orders::statistic.percent_buy_member'). "\t\n";
		$data .= RC_Lang::get('orders::statistic.member_count'). "\t" . RC_Lang::get('orders::statistic.order_member_count') . "\t" . RC_Lang::get('orders::statistic.member_order_count') . "\t" . RC_Lang::get('orders::statistic.percent_buy_member') . "\n";
	
		$data .= $user_num . "\t" . $have_order_usernum . "\t" . $user_all_order['order_num'] . "\t" . sprintf("%0.2f", ($user_num > 0 ? ($have_order_usernum / $user_num) : 0) * 100).'%' . "\n\n";
	
		/* 每会员平均订单数及购物额 */
		$data .= RC_Lang::get('orders::statistic.order_turnover_peruser') . "\t\n";
		$data .= RC_Lang::get('orders::statistic.member_sum') . "\t" . RC_Lang::get('orders::statistic.average_member_order') . "\t" . RC_Lang::get('orders::statistic.member_order_sum') . "\n";
		
		$ave_user_ordernum = $user_num > 0 ? sprintf("%0.2f", $user_all_order['order_num'] / $user_num) : 0;
		$ave_user_turnover = $user_num > 0 ? price_format($user_all_order['turnover'] / $user_num) : 0;
		
		$data .= price_format($user_all_order['turnover']) . "\t" . $ave_user_ordernum . "\t" . $ave_user_turnover . "\n\n";
		echo mb_convert_encoding($data. "\t", "GBK", "UTF-8");
		exit;
	}
}

// end