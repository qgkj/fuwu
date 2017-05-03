<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 分页处理类
 * @package     Core
 */
class ecjia_touch_page extends ecjia_page {

	/**
	 * 上一页
	 * @return string
	 */
	public function pre() {
		if ($this->current_page > 1 && $this->current_page <= $this->total_pages) {
			return "<a class='btn btn-pre external_link' href='" . $this->get_url($this->current_page - 1) . "'>{$this->desc['pre']}</a>";
		}
		return "<a class='btn btn-pre disabled'>{$this->desc['pre']}</a>";
	}

    /**
     * 当前页记录
     * @return string
     */
    public function now_page() {
        return "<div class='now-page'>{$this->current_page}/{$this->total_pages}</div>";
    }

	/**
	 * 下一页
	 * @return string
	 */
	public function next() {
		$next = $this->desc ['next'];
		if ($this->current_page < $this->total_pages) {
			return "<a class='btn btn-next external_link' href='" . $this->get_url($this->current_page + 1) . "'>{$next}</a>";
		}
		return "<a class='btn btn-next disabled'>{$next}</a>";
	}
	
	/**
	 * 显示页码
	 * @param string $style 风格
	 * @param int $page_row 页码显示行数
	 * @return string
	 */
	public function show($style = '', $page_row = null) {
		if (empty($style)) {
			$style = RC_Config::load_config('system', 'PAGE_STYLE');
		}
		
		//使用下拉加载，不使用分类页面
		return '';
		 
		//页码显示行数
		$this->page_row = is_null($page_row)? $this->page_row : $page_row - 1;

		return '<div class="ecjia-page ecjia-margin-b">' . $this->pre() . $this->now_page() . $this->next()  . '</div>';
	}
}

// end