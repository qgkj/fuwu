<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 用户查询
 * @author will.chen
 */
class search_module extends api_admin implements api_interface {
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {
    		
		$this->authadminSession();
		if ($_SESSION['admin_id'] <= 0 ) {
		    return new ecjia_error(100, 'Invalid session');
		}
		
		$result = $this->admin_priv('users_manage');
		
		if (is_ecjia_error($result)) {
			return $result;
		}
		
		$keywords = $this->requestData('keywords');
		if (empty($keywords)) {
			return new ecjia_error(101, '参数错误');
		}
		
		$db_user = RC_Model::model('user/user_viewmodel');
		$region = RC_Model::model('shipping/region_model');
		$db_user->view = array(
				'user_rank' => array(
						'type'		=> Component_Model_View::TYPE_LEFT_JOIN,
						'alias'		=> 'r',
						'field'		=> '',
						'on'		=> 'u.user_rank = r.rank_id'
				),
				'user_address' => array(
						'type'		=> Component_Model_View::TYPE_LEFT_JOIN,
						'alias'		=> 'ua',
						'field'		=> '',
						'on'		=> 'u.address_id=ua.address_id'
				)
		);
		
		$where = array(
				'user_name' => array('like' => '%'. $keywords . '%'), 
				'OR', 
				'mobile_phone' => array('like' => '%'. $keywords . '%')
		);

		$arr = $db_user->join(array('user_rank','user_address'))
						->field('u.user_id, user_name, u.address_id, user_rank, u.email, mobile_phone, r.rank_name, u.user_money, pay_points, country, province, city, district, address')
						->where($where)
						->select();
		$user_search = array();
		if (!empty($arr)) {
			foreach ($arr as $k => $v){
				$uid = sprintf("%09d", $v['user_id']);//格式化uid字串， d 表示把uid格式为9位数的整数，位数不够的填0
				
				$dir1 = substr($uid, 0, 3);//把uid分段
				$dir2 = substr($uid, 3, 2);
				$dir3 = substr($uid, 5, 2);
				
				$filename    = md5($v['user_name']);
				$avatar_path = RC_Upload::upload_path().'/data/avatar/'.$dir1.'/'.$dir2.'/'.$dir3.'/'.substr($uid, -2)."_".$filename.'.jpg';
				
				if(!file_exists($avatar_path)) {
					$avatar_img = '';
				} else {
					$avatar_img = RC_Upload::upload_url().'/data/avatar/'.$dir1.'/'.$dir2.'/'.$dir3.'/'.substr($uid, -2)."_".$filename.'.jpg';
				}
				
				$address = $v['address_id'] > 0 ? $region->where(array('region_id' => $v['city']))->get_field('region_name')
				.$region->where(array('region_id' => $v['district']))->get_field('region_name').$v['address'] : '';
				$user_search[] = array(
						'id'			=>	$v['user_id'],
						'name'			=>	$v['user_name'],
						'rank_name'		=>	$v['rank_name'],
						'email'			=>	$v['email'],
						'mobile_phone'	=>	$v['mobile_phone'],
						'formatted_user_money' =>	price_format($v['user_money'],false),
						'user_points'	=>	$v['pay_points'],
						'user_money'	=>	$v['user_money'],
						'address'		=>	$address,
						'avatar_img'	=>	$avatar_img,
				);
			}
		}
		
		return $user_search;
	}
}

// end