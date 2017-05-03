<?php
  
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 地区列表
 * @author royalwang
 *
 */
class region_module extends api_front implements api_interface
{

    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request)
    {
    	$parent_id	= $this->requestData('parent_id');
    	$type		= $this->requestData('type');
		$db = RC_Loader::load_app_model('region_model', 'shipping');
		
		if (empty($type)) {
			if ($parent_id >= 0) {
				$result = $db->field('region_id, region_name, parent_id, region_type')->where(array('parent_id' => $parent_id))->select();
			} else {
				$result = $db->field('region_id, region_name, parent_id, region_type')->select();
			}
			
		} else {
			$result = $db->field('region_id, region_name, parent_id, region_type')->where(array('region_type' => $type))->select();
		}

		$out = array();
		if (!empty($result)) {
			foreach ($result as $val) {
				$out[] = array(
						'id' => $val['region_id'],
						'name' => $val['region_name'],
						'parent_id' => $val['parent_id'],
						'level'		=> $val['region_type']
				);
			}	
		}
		
		$out = array(
				'more' => intval(!empty($out)),
				'regions' => $out
		);
		
		return $out;
	}
}


// end