<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 分页处理类
 * @package     Core
 */
class ecjia_merchant_page extends ecjia_page {

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
    }
    
    /**
     * 生成页面格式
     * @param 分页的html代码 $code
     */
    public function page_code($code, $page_desc = null/* , $style */) {
    	if (is_null($page_desc)) {
    		$page_desc = $this->page_desc();
    	}
    	
    	return <<<EOF
	    	<div class="page">
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
     * 输入框
     * @return string
     */
    public function input() {
        $str = "
        <div class='input-append input-group'>
        <input id='pagekeydown' type='text' name='page' value='{$this->current_page}' class='pageinput form-control' onkeydown = \"javascript:
        if(event.keyCode==13){
        location.href='{$this->get_url('B')}'+this.value+'{$this->get_url('A')}';
        }
        \"/>
        <span class='input-group-btn'>
        <button class='btn btn-primary' onclick = \"javascript:
        var input = document.getElementById('pagekeydown');
        location.href='{$this->get_url('B')}'+input.value+'{$this->get_url('A')}';
        \">GO</button></span>
        </div>
        ";
        return $str;
    }
    
    /**
     * 显示页码
     * @param string $style 风格
     * @param int $page_row 页码显示行数
     * @return string
     */
    public function show($style = '', $page_row = null) {
    	if (empty($style)) {
    		$style = Config::get('system.page_style');
    	}
    	if($this->total_pages <= 1) {
    		return '';
    	}
    	
    	//页码显示行数
    	$this->page_row = is_null($page_row)? $this->page_row : $page_row - 1;
    	
    	switch ($style) {
    		case 1 :
    			return $this->page_code("{$this->input()}<ul class='pagination'>{$this->first()}{$this->pre()}{$this->pres()}{$this->text_list()}{$this->nexts()}{$this->next()}{$this->end()}</ul>
    			<ul class='pagination'>{$this->now_page()}{$this->pic_list()}</ul>{$this->select()}",'');
    		case 2 :
    			return $this->page_code("{$this->input()}<ul class='pagination'>" . $this->first() . $this->pre() . $this->text_list() . $this->next() . $this->end() . '</ul>');
    		case 3 :
    			return $this->page_code("<ul class='pagination'>" . $this->first() . $this->pre() . $this->text_list() . $this->next() . $this->end() . '</ul>');
    		case 4 :
    			return $this->page_code("<ul class='pagination'>" . $this->pic_list() . "</ul>" . $this->select() . '</ul>');
// 			case 6 : //白底灰色背景
// 			    return $this->page_code("<ul class='pagination'>" . $this->first() . $this->pre() . $this->text_list() . $this->next() . $this->end() . '</ul>', null, $style);
    		default:
    			return $this->page_code("<ul class='pagination'>" . $this->first() . $this->pre() . $this->text_list() . $this->next() . $this->end() . '</ul>');
    	}
    }
}

// end