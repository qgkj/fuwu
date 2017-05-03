<?php
  
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * ECJia 地区管理类
 * @author royalwang
 *
 */
class ecjia_area {

    /**
     * 获取地区列表的函数。
     * @param   int     $region_id  上级地区id
     * @return  array
     */
    function area_list($region_id)
    {
        $db = RC_Loader::load_model('region_model');
        $area_arr = array();
    
        //     $sql = 'SELECT * FROM ' . $GLOBALS['ecs']->table('region').
        //            " WHERE parent_id = '$region_id' ORDER BY region_id";
        //     $res = $GLOBALS['db']->query($sql);
    
        $data = $db->where($region_id)->order('region_id')->select();
        //     while ($row = $GLOBALS['db']->fetchRow($res))
        if (!empty($data)) {
            foreach ($data as $row) {
                $row['type']  = ($row['region_type'] == 0) ? $GLOBALS['_LANG']['country']  : '';
                $row['type'] .= ($row['region_type'] == 1) ? $GLOBALS['_LANG']['province'] : '';
                $row['type'] .= ($row['region_type'] == 2) ? $GLOBALS['_LANG']['city']     : '';
                $row['type'] .= ($row['region_type'] == 3) ? $GLOBALS['_LANG']['cantonal'] : '';
                $id = $row['region_id'];
                $row['href'] .= RC_Uri::url('@area_manage/drop_area',"id=$id");
                $area_arr[] = $row;
            }
        }
    
        return $area_arr;
    }
    
}

// end