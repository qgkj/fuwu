<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

class sms_user_rank_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'user_rank';
		parent::__construct();
	}
	
	/**
	 *
	 * 取得用户等级数组,按用户级别排序
	 * @param   bool      $is_special      是否只显示特殊会员组
	 * @return  array     rank_id=>rank_name
	 */
	public function get_rank_list($is_special = false) {
		$db_user_rank = RC_DB::table('user_rank');
		$db_user_rank->select('rank_id', 'rank_name', 'min_points')->orderby('min_points', 'asc');
		
	    $rank_list = array();
	    if ($is_special) {
	        $db_user_rank->where('special_rank', 1);
	    }
	    $data = $db_user_rank->get();
	    
	    if (!empty($data)) {
	        foreach ($data as $row) {
	            $rank_list[$row['rank_id']] = $row['rank_name'];
	        }
	    }
	    return $rank_list;
	}
}

// end