<?php
  
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 分页处理类
 * @package     Core
 */
class ecjia_page extends Component_Page_Page {

    /**
     * 上一页
     * @return string
     */
    public function pre() {
        if ($this->current_page > 1 && $this->current_page <= $this->total_pages) {
            return "<li><a class='a1 data-pjax external_link' href='" . $this->get_url($this->current_page - 1) . "'>{$this->desc['pre']}</a></li>";
        }
        return "<li class='active'><a>{$this->desc['pre']}</a><li>";
    }
    
    /**
     * 下一页
     * @return string
     */
    public function next() {
        $next = $this->desc ['next'];
        if ($this->current_page < $this->total_pages) {	
            return "<li><a class='a1 data-pjax external_link' href='" . $this->get_url($this->current_page + 1) . "'>{$next}</a></li>";
        }
        return "<li class='active'><a>{$next}</a></li>";
    }

    /**
     * 文字页码列表
     * @return string
     */
    public function text_list() {
        $arr = $this->page_list();
        $str = "";
        if (empty($arr))
            return "<li class='active'><a>1</a></li>";
        foreach ($arr as $v) {
            $str .= empty($v ['url']) ? "<li class='active'><a>" . $v ['str'] . "</a></li>" : "<li><a class='a1 data-pjax external_link' href={$v['url']}>{$v['str']}</a></li>";
        }
        return $str;
    }

    /**
     * 图标页码列表
     * @return string
     */
    public function pic_list() {
        $str = '';
        $first = $this->current_page == 1 ?					"<li class='active'><a href='javascript:;'>&lt;&lt;</a></li>" : "<li><a class='data-pjax' href='" . $this->get_url(1) . "'>&lt;&lt;</a></li>";
        $end = $this->current_page >= $this->total_pages ?	"<li class='active'><a href='javascript:;'>&gt;&gt;</a></li>" : "<li><a class='data-pjax' href='" . $this->get_url($this->total_pages) . "' >&gt;&gt;</a></li>";
        $pre = $this->current_page <= 1 ?					"<li class='active'><a href='javascript:;'>&lt;</a></li>" : "<li><a class='data-pjax' href='" . $this->get_url($this->current_page - 1) . "' >&lt;</a></li>";
        $next = $this->current_page >= $this->total_pages ?	"<li class='active'><a href='javascript:;'>&gt;</a></li>" : "<li><a class='data-pjax' href='" . $this->get_url($this->current_page + 1) . "' >&gt;</a></li>";

        return $first . $pre . $next . $end;
    }

    /**
     * 选项列表
     * @return string
     */
    public function select() {
        $arr = $this->page_list();
        if (!$arr) {
            return '';
        }
        $str = "<select name='page' class='page_select' onchange='
		javascript:
		location.href=this.options[selectedIndex].value;' style='width:auto;'>";
        foreach ($arr as $v) {
            $str .= empty($v ['url']) ? "<option value='{$this->get_url($v['str'])}&pjax=true' selected='selected'>{$v['str']}</option>" : "<option value='{$v['url']}'>{$v['str']}</option>";
        }
        return $str . "</select>";
    }

    /**
     * 输入框
     * @return string
     */
    public function input() {
        $str = "
        		<div class='input-append'>
					<input id='pagekeydown' type='text' name='page' value='{$this->current_page}' class='pageinput' style='width:30px;' onkeydown = \"javascript:
						if(event.keyCode==13){
							location.href='{$this->get_url('B')}'+this.value+'{$this->get_url('A')}';
						}
					\"/>
					<button class='btn' onclick = \"javascript:
						var input = document.getElementById('pagekeydown');
						location.href='{$this->get_url('B')}'+input.value+'{$this->get_url('A')}';
					\">GO</button>
				</div>
";
        return $str;
    }

    /**
     * 前几页
     * @return string
     */
    public function pres() {
        $num = max(1, $this->current_page - $this->page_row);
        return $this->current_page > $this->page_row ? "<li><a class='data-pjax' href='" . $this->get_url($num) . "'>前{$this->page_row}页</a></li>" : "";
    }

    /**
     * 后几页
     * @return string
     */
    public function nexts() {
        $num = min($this->total_pages, $this->current_page + $this->page_row);
        return $this->current_page + $this->page_row < $this->total_pages ? "<li><a class='data-pjax' href='" . $this->get_url($num) . "'>后{$this->page_row}页</a></li>" : "";
    }

    /**
     * 首页
     * @return string
     */
    public function first() {
        $first = $this->desc ['first'];
        return $this->current_page - $this->page_row > 1 ? "<li><a class='first a1 data-pjax external_link' href='" . $this->get_url(1) . "'>{$first}</a></li>" : "";
    }

    /**
     * 末页
     * @return string
     */
    public function end() {
        $end = $this->desc ['end'];
        return $this->current_page < $this->total_pages - $this->page_row ? "<li><a class='end a1 data-pjax external_link' href='" . $this->get_url($this->total_pages) . "'>{$end}</a></li>" : "";
    }

    /**
     * 当前页记录
     * @return string
     */
    public function now_page() {
        return "<li><span class='now_page'>第{$this->start_id}-{$this->end_id}{$this->desc['unit']}</span></li>";
    }

    /**
     * count统计
     * @return string
     */
    public function count() {
        return "<span class='count'>[共{$this->total_pages}页] [{$this->total_records}条记录]</span>";
    }

    /**
     * 分页文字描述
     */
    public function page_desc() {
    	$lang = array(
    		'total_records' => __('总计 '),
    		'total_pages' 	=> __('条记录，分为'),
    		'page_current' 	=> __('页当前第'),
    		'page_size' 	=> __('页，每页'),
    		'page'			=> __(' 页'),
    	);
    	
    	return <<< EOF
  		{$lang['total_records']} <span id="totalRecords">{$this->total_records}</span>
 		{$lang['total_pages']} <span id="totalPages">{$this->total_pages}{$lang['page']}</span>
EOF;
// 		{$lang['page_current']} <span id="pageCurrent">{$this->current_page}</span>
// 		{$lang['page_size']} <span id="pageCurrent">{$this->page_size}</span> {$this->desc['unit']}
    }
    
    protected function unset_url_val(& $vars) {
    	unset($vars['pjax']);
    	unset($vars['_pjax']);
    	unset($vars['_']);
    	parent::unset_url_val($vars);
    }
    
    /**
     * 生成页面格式
     * @param 分页的html代码 $code
     */
    public function page_code($code, $page_desc = null) {
    	if (is_null($page_desc)) {
    		$page_desc = $this->page_desc();
    	}
    	
    	return <<<EOF
	    	<div class="page pagination">
				<div class="pull-left">
					$page_desc
				</div>
				<div class="pull-right">
	    			$code
				</div>
			</div>
EOF;
    }
    
    /**
     * 显示页码
     * @param string $style 风格
     * @param int $page_row 页码显示行数
     * @return string
     */
    public function show($style = '', $page_row = null) {
    	if (empty($style)) {
    		$style = RC_Config::get('system.page_style');
    	}
    	if($this->total_pages <= 1) {
    		return '';
    	}
    	
    	//页码显示行数
    	$this->page_row = is_null($page_row)? $this->page_row : $page_row - 1;

    	switch ($style) {
    		case 1 :
    			return $this->page_code("{$this->input()}<ul>{$this->first()}{$this->pre()}{$this->pres()}{$this->text_list()}{$this->nexts()}{$this->next()}{$this->end()}</ul>
    			<ul>{$this->now_page()}{$this->pic_list()}</ul>{$this->select()}",'');
    		case 2 :
    			return $this->page_code("{$this->input()}<ul>" . $this->first() . $this->pre() . $this->text_list() . $this->next() . $this->end() . '</ul>');
    		case 3 :
    			return $this->page_code("<ul>" . $this->first() . $this->pre() . $this->text_list() . $this->next() . $this->end() . '</ul>');
    		case 4 :
    			return $this->page_code("<ul>" . $this->pic_list() . "</ul>" . $this->select() . '</ul>');
    		default:
    			return $this->page_code('<ul>' . $this->first() . $this->pre() . $this->text_list() . $this->next() . $this->end() . '</ul>');
    	}
    }

}

// end