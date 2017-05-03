<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 更新商店关键字
 * @author huangyuyuan@ecmoban.com
 */
class stats_update_store_keywords_api extends Component_Event_Api {
	/*
	 * store_id 
	 * keywords
	 *   */
	public function call(&$options) {
	    
	    //查询是否存在，存在更新次数，不存在增加
	    
	    if (empty($options['store_id']) || empty($options['keywords'])) {
	        return false;
	    }
	    $date = RC_Time::local_date('Y-m-d');
	    
	    $db_store_keywords = RC_DB::table('store_keywords')
                    	    ->where('store_id', $options['store_id'])
                    	    ->where('keyword', $options['keywords'])
                    	    ->where('date', $date);
	    
	    $info = $db_store_keywords->first();
	    
	    $rs = false;
	    if ($info) {
	        //update
	        $rs = $db_store_keywords->increment('count');
	    } else {
	        //insert
	        $data = array(
	            'date'     => $date,
	            'store_id' => $options['store_id'],
	            'keyword'  => $options['keywords'],
	            'count'    => 1,
	        );
	        $rs = RC_DB::table('store_keywords')->insert($data);
	    }
	    
        return $rs;
	}
}

// end