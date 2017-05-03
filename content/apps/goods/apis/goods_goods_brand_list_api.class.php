<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 商品品牌列表
 * @author will.chen
 */
class goods_goods_brand_list_api extends Component_Event_Api {
    /**
     * @param  $options['keyword'] 关键字
     *
     * @return array
     */
	public function call(&$options) {
	   	$row = $this->brandlist($options);
	    return $row;
	}

	/**
	 * 获取品牌列表
	 *
	 * @access  public
	 * @return  array
	 */
	private function brandlist($filter) {
		if (!isset($_SESSION['store_id'])) {
			$db = RC_Model::model('goods/brand_model');
			/* 分页大小 */
			$where = array();
			/* 记录总数以及页数 */
			if (isset($filter['keywords']) && !empty($filter['keywords'])) {
				$where['brand_name'] = array('like' => "%".$filter['keywords']."%");
			}

			$count = $db->where($where)->count();
			//实例化分页
			$page = new ecjia_page($count, $filter['size'], 5, '', $filter['page']);
			$result = $db->where($where)->order('sort_order asc')->limit($page->limit())->select();

			$arr = array();
			if(!empty($result)) {
				foreach ($result as $key => $rows) {
					if (empty($rows['brand_logo'])) {
						$rows['brand_logo'] = '';
					} else {
						if ((strpos($rows['brand_logo'], 'http://') === false) && (strpos($rows['brand_logo'], 'https://') === false)) {
							$logo_url = RC_Upload::upload_url($rows['brand_logo']);
							$logo_url = file_exists(RC_Upload::upload_path($rows['brand_logo'])) ? $logo_url : RC_Uri::admin_url('statics/images/nopic.png');
							$rows['brand_logo_html'] = "<img src='" . $logo_url . "' style='width:100px;height:100px;' />";
						} else {
							$rows['brand_logo_html'] = "<img src='" . $rows['brand_logo'] . "' style='width:100px;height:100px;' />";
						}
					}
					$site_url   = empty($rows['site_url']) ? 'N/A' : '<a href="'.$rows['site_url'].'" target="_brank">'.$rows['site_url'].'</a>';
					$rows['site_url']   = $site_url;
					$arr[] = $rows;
				}
			}
		} else {
            $db = RC_Model::model('goods/brand_model');
			/* 分页大小 */
            $brand = RC_DB::table('goods')->where('store_id', $_SESSION['store_id'])->selectRaw('distinct brand_id')->get();
            $brand = array_column($brand,'brand_id');

            if(!empty($brand)){
                $in = array('brand_id' => $brand);
            }
			/* 记录总数以及页数 */
			if (isset($filter['keywords']) && !empty($filter['keywords'])) {
				$where['brand_name'] = array('like' => "%".$filter['keywords']."%");
			}

			$count = $db->where($where)->in($in)->count();
			//实例化分页
			$page = new ecjia_page($count, $filter['size'], 5, '', $filter['page']);
			$result = $db->where($where)->in($in)->order('sort_order asc')->limit($page->limit())->select();

			$arr = array();
			if(!empty($result)) {
				foreach ($result as $key => $rows) {
					$logo_url = '';
					if (empty($rows['brand_Logo'])) {
						$rows['brand_logo'] = '';

					} else {
						if ((strpos($rows['brand_Logo'], 'http://') === false) && (strpos($rows['brandLogo'], 'https://') === false)) {
							$logo_url = RC_Upload::upload_url($rows['brandLogo']);
							$logo_url = file_exists(RC_Upload::upload_path($rows['brandLogo'])) ? $logo_url : RC_Uri::admin_url('statics/images/nopic.png');
						}
					}
					$rows['brand_id'] = $rows['brand_id'];
					$rows['brand_name'] = $rows['brand_name'];
					$rows['brand_logo'] = $logo_url;
					$rows['is_show'] = $rows['is_show'];

					$site_url   = empty($rows['site_url']) ? 'N/A' : '<a href="'.$rows['site_url'].'" target="_brank">'.$rows['site_url'].'</a>';
					$rows['site_url']   = $site_url;
					$arr[] = $rows;
				}
			}
		}
		return array('brand' => $arr, 'page' => $page);
	}
}

// end