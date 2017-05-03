<?php
  
/**
 * ecjia 排序类
 * @author royalwang
 *
 */
class ecjia_sort
{
    /**
     * 地区排序
     * @param array $a
     * @param array $b
     * @return number
     */
    public static function array_sort($a, $b)
    {
        $cmp = strcmp($a['region'], $b['region']);
        if ($cmp == 0) {
            return ($a['sort_order'] < $b['sort_order']) ? - 1 : 1;
        } else {
            return ($cmp > 0) ? - 1 : 1;
        }
    }
    
    
    /**
     * 导航菜单排序
     * @param array $a
     * @param array $b
     * @return number
     */
    public static function sort_nav($a, $b)
    {
    	return  $a['vieworder'] > $b['vieworder'] ? 1 : -1;
    }
}

// end