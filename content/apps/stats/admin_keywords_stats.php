<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 关键字统计
 * @author wutifang
*/
class admin_keywords_stats extends ecjia_admin {
	public function __construct() {
		parent::__construct();
		RC_Loader::load_app_func('global', 'stats');

		/*加载所有全局 js/css */
		RC_Script::enqueue_script('bootstrap-placeholder');
		RC_Script::enqueue_script('jquery-validate');
		RC_Script::enqueue_script('jquery-form');
		RC_Script::enqueue_script('smoke');
		RC_Script::enqueue_script('jquery-chosen');
		RC_Style::enqueue_style('chosen');
		RC_Script::enqueue_script('jquery-uniform');
		RC_Style::enqueue_style('uniform-aristo');

		//时间控件
		RC_Script::enqueue_script('bootstrap-datepicker', RC_Uri::admin_url('statics/lib/datepicker/bootstrap-datepicker.min.js'));
		RC_Style::enqueue_style('datepicker', RC_Uri::admin_url('statics/lib/datepicker/datepicker.css'));
		
		/*自定义JS*/
		RC_Style::enqueue_style('stats-css', RC_App::apps_url('statics/css/stats.css', __FILE__), array());
		RC_Script::enqueue_script('keywords', RC_App::apps_url('statics/js/keywords.js', __FILE__));
		RC_Script::localize_script('keywords', 'js_lang', RC_Lang::get('stats::statistic.js_lang'));
	}

	public function init() {
		$this->admin_priv('keywords_stats');

		ecjia_screen::get_current_screen()->add_nav_here(new admin_nav_here(RC_Lang::get('stats::statistic.search_keywords')));
		ecjia_screen::get_current_screen()->add_help_tab(array(
			'id'		=> 'overview',
			'title'		=> RC_Lang::get('stats::statistic.overview'),
			'content'	=> '<p>' . RC_Lang::get('stats::statistic.keywords_stats_help') . '</p>'
		));
		ecjia_screen::get_current_screen()->set_help_sidebar(
			'<p><strong>' . RC_Lang::get('stats::statistic.more_info') . '</strong></p>' .
			'<p>' . __('<a href="https://ecjia.com/wiki/帮助:ECJia智能后台:搜索引擎" target="_blank">'. RC_Lang::get('stats::statistic.about_keywords_help') .'</a>') . '</p>'
		);

		$this->assign('ur_here', RC_Lang::get('stats::statistic.search_keywords'));
		$this->assign('action_link', array('text' => RC_Lang::get('stats::statistic.down_search_stats'), 'href' => RC_Uri::url('stats/admin_keywords_stats/download')));

		$start_date = !empty($_GET['start_date']) ? $_GET['start_date'] : RC_Time::local_date(ecjia::config('date_format'), strtotime('-7 days')-8*3600);
		$end_date   = !empty($_GET['end_date']) ? $_GET['end_date'] : RC_Time::local_date(ecjia::config('date_format'));
		$this->assign('start_date', $start_date);
		$this->assign('end_date', $end_date);

		$this->assign('search_action', RC_Uri::url('stats/admin_keywords_stats/init'));

		$keywords_data = $this->get_keywords_list();
		$this->assign('keywords_data', $keywords_data);

		$this->display('keywords_stats.dwt');
	}


	public function download() {
		$this->admin_priv('keywords_stats', ecjia::MSGTYPE_JSON);
		
		$filename = mb_convert_encoding(RC_Lang::get('stats::statistic.tab_keywords').'_'.$_GET['start_date'].'至'.$_GET['end_date'], "GBK", "UTF-8");

		$keywords_list = $this->get_keywords_list(false);

		header("Content-type: application/vnd.ms-excel; charset=utf-8");
		header("Content-Disposition: attachment; filename=$filename.xls");

		$data = RC_Lang::get('stats::statistic.keywords')."\t".RC_Lang::get('stats::statistic.hits')."\t".RC_Lang::get('stats::statistic.date')."\t\n";

		if (!empty($keywords_list['item'])) {
			foreach ($keywords_list['item'] as $v) {
				$data .= $v['keyword'] . "\t";
				$data .= $v['count'] . "\t";
				$data .= $v['date'] . "\t\n";
			}
		}
		echo mb_convert_encoding($data."\t", "GBK", "UTF-8");
		exit;
	}

	/**
	 * 获取数据
	 */
	private function get_keywords_list($is_page = true) {
		$db_keywords = RC_DB::table('keywords');

		$start_date = empty($_GET['start_date']) 	? RC_Time::local_date(ecjia::config('date_format'), RC_Time::local_strtotime('-7 days')) : $_GET['start_date'];
		$end_date 	= empty($_GET['end_date']) 		? RC_Time::local_date(ecjia::config('date_format'), RC_Time::local_strtotime('today')) 	: $_GET['end_date'];
		$db_keywords->where('date', '>=', $start_date)->where('date', '<=', $end_date);

		$count = $db_keywords->count();
		$page = new ecjia_page($count, 20, 5);
		$db_keywords->select('keyword', 'count', 'searchengine', 'date')->orderby('count', 'desc');

		if ($is_page) {
			$db_keywords->take($page->page_size)->skip($page->start_id-1);
		}
		$data = $db_keywords->get();

		return array('item' => $data, 'page' => $page->show(2), 'desc' => $page->page_desc());
	}
}

// end
