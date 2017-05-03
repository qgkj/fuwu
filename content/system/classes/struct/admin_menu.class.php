<?php
  
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * ECJIA 菜单类
 * @author royalwang
 *
 */
class admin_menu {
	
    private $base;
	private $action;
	private $name;
	private $sort;
	private $link;
	private $icon;
	private $target;
	
	private $submenus		= null;
	private $purview       = null;
	
	private $has_submenus	= false;
	
	public function __construct($action, $name, $link, $sort = 99, $target = '_self') {
		$this->action = $action;
		$this->name = $name;
		$this->link = $link;
		$this->sort = $sort;
		$this->target = $target;
	}
	
	
	public function __get($name) {
		return $this->$name;
	}
	
	
	/**
	 * 添加icon图片
	 * @param string $icon
	 */
	public function add_icon($icon) {
	    $this->icon = $icon;
	    return $this;
	}
	
	/**
	 * 添加base名称
	 * @param string $base
	 */
	public function add_base($base) {
	    $this->base = $base;
	    return $this;
	}
	
	/**
	 * 添加菜单或菜单数组进子菜单数组里
	 * @param $menu_object or $array $menu
	 */
	public function add_submenu($menu) {
		// 如果是菜单对象，直接添加进子菜单数组
		if (is_object($menu)) {
			$this->submenus[] = $menu;
		}
		// 如果是数组，直接合并进子菜单数组里
		elseif (is_array($menu)) {
			if (!is_array($this->submenus)) {
				$this->submenus = array();
			}
			$this->submenus = array_merge($this->submenus, $menu);
		}
		// 已经有子菜单了，立即更新状态
		$this->has_submenus = true;
		
		return $this;
	}
	
	
	public function remove_submenu($menu) {
	    if (is_object($menu)) {
	        $key = array_search($menu, $this->submenus, true);
	        if (!is_null($key)) {
	            unset($this->submenus[$key]);
	        }
	    }
	}
	
	/**
	 * 获取子菜单数组
	 */
	public function submenus() {
		if (is_array($this->submenus)) {
			usort($this->submenus, array('ecjia_utility', 'admin_menu_by_sort'));
		}
		return $this->submenus;
	}
	
	/**
	 * 添加使用该菜单的权限
	 */
	public function add_purview($priv) {
	    $this->purview = $priv;
	    
	    return $this;
	}
	
	/**
	 * 获取权限列表
	 */
	public function purview() {
	    return $this->purview;
	}
	
	/**
	 * 检测是否有权限设置
	 * @return boolean
	 */
	public function has_purview() {
	    if (empty($this->purview)) {
	        return false;
	    } else {
	        return true;
	    }
	}
	
	/**
	 * 检测是否有子菜单数据
	 */
    public function has_submenus() {
        if (empty($this->submenus)) {
            return false;
        } else {
            return true;
        }
    }
	
}

// end