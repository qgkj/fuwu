<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获取商品详情信息
 * @author will.chen
 */
class goods_goods_info_api extends Component_Event_Api {
    /**
     * @param  $options['keyword'] 关键字
     *         $options['cat_id'] 分类id
     *         $options['brand_id'] 品牌id
     * @return array
     */
	public function call(&$options) {	
	    if (!is_array($options)
	        && !isset($options['id'])) {
	        return new ecjia_error('invalid_parameter', '参数无效');
	    }
	   	$row = $this->get_goods_info($options['id']);
	    return $row;
	}
	
	/**
	 * 获得商品的详细信息
	 *
	 * @access public
	 * @param integer $goods_id        	
	 * @return void
	 */
	private function get_goods_info($goods_id) {
		$db_goods = RC_Model::model('goods/goods_viewmodel');
		RC_Loader::load_app_func('global', 'goods');
		$time = RC_Time::gmtime();
		$db_goods->view = array (
			'category' => array(
				'type'	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias'	=> 'c',
				'field'	=> "g.*, c.measure_unit, b.brand_id, b.brand_name AS goods_brand, m.type_money AS bonus_money,IFNULL(AVG(r.comment_rank), 0) AS comment_rank,IFNULL(mp.user_price, g.shop_price * '".$_SESSION['discount']."') AS rank_price",
				'on'	=> 'g.cat_id = c.cat_id' 
			),
			'brand' => array(
				'type'	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias'	=> 'b',
				'on'	=> 'g.brand_id = b.brand_id ' 
			),
			'comment' => array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'r',
				'on' 	=> 'r.id_value = g.goods_id AND comment_type = 0 AND r.parent_id = 0 AND r.status = 1' 
			),
			'bonus_type' => array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'm',
				'on' 	=> 'g.bonus_type_id = m.type_id AND m.send_start_date <= "' . $time . '" AND m.send_end_date >= "' . $time . '"' 
			),
			'member_price' => array(
				'type'	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias'	=> 'mp',
				'on'  	=> 'mp.goods_id = g.goods_id AND mp.user_rank = "' . $_SESSION['user_rank'] . '"' 
			) 
		);
		$row = $db_goods->group('g.goods_id')->find(array('g.goods_id' => $goods_id, 'g.is_delete' => 0));
		
		if ($row !== false) {
			/* 用户评论级别取整 */
			$row['comment_rank'] = ceil( $row['comment_rank'] ) == 0 ? 5 : ceil ( $row['comment_rank'] );
			/* 获得商品的销售价格 */
			$row['unformatted_market_price'] = $row['market_price'];
			$row['market_price'] = $row['market_price'] > 0 ? price_format ($row['market_price']) : 0;
			$row['shop_price_formated'] = price_format ($row['shop_price'] );
			
			/* 修正促销价格 */
			if ($row ['promote_price'] > 0) {
				$promote_price = bargain_price ( $row['promote_price'], $row['promote_start_date'], $row['promote_end_date'] );
			} else {
				$promote_price = 0;
			}
			
			/* 处理商品水印图片 */
			$watermark_img = '';
			if ($promote_price != 0) {
				$watermark_img = "watermark_promote";
			} elseif ($row['is_new'] != 0) {
				$watermark_img = "watermark_new";
			} elseif ($row['is_best'] != 0) {
				$watermark_img = "watermark_best";
			} elseif ($row['is_hot'] != 0) {
				$watermark_img = 'watermark_hot';
			}
			
			if ($watermark_img != '') {
				$row['watermark_img'] = $watermark_img;
			}
			
			$row['promote_price_org'] = $promote_price;
			$row['promote_price'] = price_format ( $promote_price );
			
			/* 修正重量显示 */
			$row['goods_weight'] = (intval ( $row['goods_weight'] ) > 0) ? $row['goods_weight'] . RC_Lang::get('system::system.kilogram') : ($row['goods_weight'] * 1000) . RC_Lang::get('system::system.gram');
			
			/* 修正上架时间显示 */
			$row['add_time'] = RC_Time::local_date(ecjia::config('date_format'), $row['add_time'] );
			
			/* 促销时间倒计时 */
			$time = RC_Time::gmtime ();
			if ($time >= $row ['promote_start_date'] && $time <= $row ['promote_end_date']) {
				$row['gmt_end_time'] = $row['promote_end_date'];
			} else {
				$row['gmt_end_time'] = 0;
				$row['promote_start_date'] = $row['promote_end_date'] = 0;
			}
			
			/* 是否显示商品库存数量 */
			$row['goods_number'] = (ecjia::config('use_storage') == 1) ? $row['goods_number'] : '';
			
			/* 修正积分：转换为可使用多少积分（原来是可以使用多少钱的积分） */
			$row['integral'] = ecjia::config('integral_scale') ? round ( $row['integral'] * 100 / ecjia::config('integral_scale')) : 0;
			
			/* 修正优惠券 */
			$row['bonus_money'] = ($row ['bonus_money'] == 0) ? 0 : price_format ( $row['bonus_money'], false );
			
			/* 修正商品图片 */
			$row['goods_img']	= empty($row ['goods_img']) ? RC_Uri::admin_url('statics/images/nopic.png') : RC_Upload::upload_url($row['goods_img']);
			$row['goods_thumb'] = empty($row ['goods_thumb']) ? RC_Uri::admin_url('statics/images/nopic.png') : RC_Upload::upload_url($row['goods_thumb']);
			$row['original_img'] = empty($row ['original_img']) ? RC_Uri::admin_url('statics/images/nopic.png') : RC_Upload::upload_url($row['original_img']);
			
			/* 获取商品属性和规格*/
			$row['properties']	= $this->get_goods_properties($row['goods_id']);
			$row['rank_prices'] = $this->get_user_rank_prices($row['goods_id'], $row['shop_price']);
			$row['pictures']	= $this->get_goods_gallery($row['goods_id']);
			
			return $row;
		} else {
			return false;
		}
	}
	
	/**
	 * 获得商品的属性和规格
	 *
	 * @access public
	 * @param integer $goods_id        	
	 * @return array
	 */
	private function get_goods_properties($goods_id) {
		$db_good_type = RC_Model::model ('goods/goods_type_viewmodel');
		$db_good_attr = RC_Model::model ('goods/goods_attr_viewmodel');
		/* 对属性进行重新排序和分组 */
	
		$db_good_type->view = array (
			'goods' => array (
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'g',
				'field' => 'attr_group',
				'on' 	=> 'gt.cat_id = g.goods_type' 
			) 
		);
		
		$grp = $db_good_type->find(array('g.goods_id' => $goods_id));
		$grp = $grp ['attr_group'];
		if (! empty ( $grp )) {
			$groups = explode ( "\n", strtr ( $grp, "\r", '' ) );
		}
		
		/* 获得商品的规格 */
		$db_good_attr->view = array (
			'attribute' => array (
				'type'     => Component_Model_View::TYPE_LEFT_JOIN,
				'alias'    => 'a',
				'field'    => 'a.attr_id, a.attr_name, a.attr_group, a.is_linked, a.attr_type, ga.goods_attr_id, ga.attr_value, ga.attr_price',
				'on'       => 'a.attr_id = ga.attr_id' 
			) 
		);
		
		$res = $db_good_attr->where(array('ga.goods_id' => $goods_id))->order(array('a.sort_order' => 'asc','ga.attr_price' => 'asc','ga.goods_attr_id' => 'asc'))->select();
		$arr ['pro'] = array (); // 属性
		$arr ['spe'] = array (); // 规格
		$arr ['lnk'] = array (); // 关联的属性
		
		if (! empty ( $res )) {
			foreach ( $res as $row ) {
				$row ['attr_value'] = str_replace ( "\n", '<br />', $row ['attr_value'] );
				
				if ($row ['attr_type'] == 0) {
					$group = (isset ( $groups [$row ['attr_group']] )) ? $groups [$row ['attr_group']] : RC_Lang::get('goods::goods.goods_attr');
					
					$arr ['pro'] [$group] [$row ['attr_id']] ['name'] = $row ['attr_name'];
					$arr ['pro'] [$group] [$row ['attr_id']] ['value'] = $row ['attr_value'];
				} else {
					$arr ['spe'] [$row ['attr_id']] ['attr_type'] = $row ['attr_type'];
					$arr ['spe'] [$row ['attr_id']] ['name'] = $row ['attr_name'];
					$arr ['spe'] [$row ['attr_id']] ['values'] [] = array (
						'label' => $row ['attr_value'],
						'price' => !empty($row ['attr_price']) ? $row ['attr_price'] : 0,
						'format_price' => price_format ( abs ( $row ['attr_price'] ), false ),
						'id' => $row ['goods_attr_id'] 
						);
				}
				
				if ($row ['is_linked'] == 1) {
					/* 如果该属性需要关联，先保存下来 */
					$arr ['lnk'] [$row ['attr_id']] ['name'] = $row ['attr_name'];
					$arr ['lnk'] [$row ['attr_id']] ['value'] = $row ['attr_value'];
				}
			}
		}
		return $arr;
	}
	
	/**
	 * 获得指定商品的各会员等级对应的价格
	 *
	 * @access public
	 * @param integer $goods_id            
	 * @return array
	 */
	private function get_user_rank_prices($goods_id, $shop_price) {
	    $dbview = RC_Model::model('user/user_rank_member_price_viewmodel');
	    $dbview->view =array(
    		'member_price' 	=> array(
 				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
    			'alias' => 'mp',
    			'on' 	=> "mp.goods_id = '$goods_id' and mp.user_rank = r.rank_id "
    		),
	    );
	    
	    $res = $dbview->join(array('member_price'))->field("rank_id, IFNULL(mp.user_price, r.discount * $shop_price / 100) AS price, r.rank_name, r.discount")->where("r.show_price = 1 OR r.rank_id = '$_SESSION[user_rank]'")->select();
	    $arr = array();
	    foreach ($res as $row) {
	        $arr[$row['rank_id']] = array(
	        	'id'		=> $row['rank_id'],
	            'rank_name' => htmlspecialchars($row['rank_name']),
	            'price'		=> price_format($row['price']),
	        	'unformatted_price' => number_format( $row['price'], 2, '.', '')
	        );
	    }
	    return $arr;
	}
	
	/**
	 * 获得指定商品的相册
	 *
	 * @access  public
	 * @param   integer     $goods_id
	 * @return  array
	 */
	private function get_goods_gallery($goods_id) {
	    $db_goods_gallery = RC_Model::model('goods/goods_gallery_model');
	    $row = $db_goods_gallery->field('img_id, img_url, thumb_url, img_desc, img_original')->where(array('goods_id' => $goods_id))->limit(ecjia::config('goods_gallery_number'))->select();
	    $img = array();
	    /* 格式化相册图片路径 */
	    if (!empty($row)) {
		    foreach ($row as $key => $gallery_img) {
		    	$img[$key]['img_original']	= empty($gallery_img['img_original']) ? RC_Uri::admin_url('statics/images/nopic.png') : RC_Upload::upload_url($gallery_img['img_original']);
		    	$img[$key]['img_url']		= empty($gallery_img['img_url']) ? RC_Uri::admin_url('statics/images/nopic.png') : RC_Upload::upload_url($gallery_img['img_url']);
		    	$img[$key]['thumb_url']		= empty($gallery_img['thumb_url']) ? RC_Uri::admin_url('statics/images/nopic.png') : RC_Upload::upload_url($gallery_img['thumb_url']);
		    }
	    }
	    return $img;
	}
}

// end