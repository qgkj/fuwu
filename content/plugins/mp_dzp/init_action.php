<?php
  
RC_Loader::load_app_class('platform_interface', 'platform', false);
class mp_dzp_init_action implements platform_interface {
    
    public function action() {
    	$platform_config_db = RC_Loader::load_app_model('platform_config_model','platform');
    	$wechat_prize_db = RC_Loader::load_app_model('wechat_prize_model','wechat');
    	RC_Loader::load_app_class('platform_account', 'platform', false);
    	
    	$openid = trim($_GET['openid']);
    	$uuid = trim($_GET['uuid']);
    	$account = platform_account::make($uuid);
    	$wechat_id = $account->getAccountID();
    	
    	$rs = array();
    	// 未登录
    	if (empty($openid)) {
    		$rs['status'] = 2;
    		$rs['msg'] = '请先登录';
    		echo json_encode($rs);
    		exit();
    	}
    	
    	$ext_config  = $platform_config_db->where(array('account_id' => $wechat_id,'ext_code'=>'mp_dzp'))->get_field('ext_config');
    	$config = array();
    	$config = unserialize($ext_config);
    	foreach ($config as $k => $v) {
    		if ($v['name'] == 'starttime') {
    			$starttime = strtotime($v['value']);
    		}
    		if ($v['name'] == 'endtime') {
    			$endtime = strtotime($v['value']);
    		}
    		if ($v['name'] == 'prize_num') {
    			$prize_num = $v['value'];
    		}    		
    		if ($v['name'] == 'list') {
    			$list = explode("\n",$v['value']);
    			foreach ($list as $k => $v){
    				$prize[] = explode(",",$v);
    			}
    		}
    	}
    	
    	if (time() < $starttime) {
    		$rs['status'] = 2;
    		$rs['msg'] = '大转盘活动还未开始';
    		echo json_encode($rs);
    		exit();
    	}
    	if (time() > $endtime) {
    		$rs['status'] = 2;
    		$rs['msg'] = '大转盘活动已经结束';
    		echo json_encode($rs);
    		exit();
    	}
    	// 超过次数
    	if (!empty($openid)) {
    		$num = $wechat_prize_db->where('openid = "' . $openid . '"  and activity_type = "mp_dzp" and dateline between "' . $starttime . '" and "' . $endtime . '"')->count();
    		if ($num <= 0) {
    			$num = 1;
    		} else {
    			$num = $num + 1;
    		}
    	} else {
    		$num = 1;
    	}
    	if ($num > $prize_num) {
    		$rs['status'] = 2;
    		$rs['msg'] = '抱歉，抽奖次数已用光';
    		echo json_encode($rs);
    		exit();
    	}
    	if (!empty($prize)) {
    		$arr = array();
    		$prize_name = array();
    		$prob = 0;
    		
    		foreach ($prize as $key => $val) {
    			// 删除数量不足的奖品
    			$count = $wechat_prize_db->where(array('prize_name' => $val[1],'activity_type'=>'mp_dzp','wechat_id'=>$wechat_id))->count();
    			if ($count >= $val[2]) {
    				unset($prize[$key]);
    			} else {
    				$arr[$val[0]] = $val[3];
    				$prize_name[$val[0]] = $val[1];
    			}
    			//添加项的总概率
    			 $prob = $prob + $val[3];
    		}
    		
    		//未中奖的概率项
    		if($prob < 100){
    			$prob = 100 - $prob;
    			$arr['not'] = $prob;
    		}
    		//抽奖
    		$level = $this->get_rand($arr);
    		if($level == 'not'){
    			$data['prize_type'] = 0;
    			$rs['msg'] = '没有中奖';
    			$rs['status'] = 0;
    		}
    		else{
    			$data['prize_type'] = 1;
    			$rs['msg'] = $prize_name[$level];
    			$rs['status'] = 1;
    			$rs['level'] = $level;
    		}
    		
    		
    		$rs['num'] = $prize_num - $num > 0 ? $prize_num - $num : 0;
    		// 抽奖记录
    		$data['wechat_id'] = $wechat_id;
    		$data['openid'] = $openid;
    		$data['prize_name'] = $prize_name[$level];
    		$data['dateline'] = time();
    		$data['activity_type'] = 'mp_dzp';
    		$id = $wechat_prize_db->insert($data);
    		if ($level != 'not' && !empty($id)) {
    		    // 获奖链接
    		    $rs['link'] = RC_Uri::url('platform/plugin/show', array('handle' => 'mp_dzp/user', 'name' => 'mp_dzp', 'id' => $id,'openid' => $openid,'uuid' => $uuid));
    		}

    	}
    	echo json_encode($rs);
    	exit();
	}
	
	/**
	 * 中奖概率计算
	 *
	 * @param unknown $proArr
	 * @return Ambigous <string, unknown>
	 */
	private function get_rand($proArr) {
		$result = '';
		// 概率数组的总概率精度
		$proSum = array_sum($proArr);
		// 概率数组循环
		foreach ($proArr as $key => $proCur) {
			$randNum = mt_rand(1, $proSum);
			if ($randNum <= $proCur) {
				$result = $key;
				break;
			} else {
				$proSum -= $proCur;
			}
		}
		unset($proArr);
		return $result;
	}
}

// end