<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 管理中心在线升级语言文件
 */

return array(
	'filecheck_verifying'	=> '正在进行文件校验，请稍候......',
	'filecheck_tips_step1'	=> '文件校验是针对 ECJia 官方发布的文件为基础进行核对，点击下面按钮开始进行校验。',
	'filecheck_start'		=> '开 始',
	'fileperms_confirm'		=> '确认开始',
	'fileperms_verify'		=> '开始校验',
	'filecheck_completed'	=> '校验结果',
	'filecheck_return'		=> '返回重新校验',
	'filecheck_status'		=> '状态',
	'result_modify'			=> '<span class="stop_color"><i class="fontello-icon-attention-circled"></i>被修改</span>',
	'result_delete'			=> '<span class="error_color"><i class="fontello-icon-minus-circled"></i>被删除</span>',
	'result_unknown'		=> '<span class="ok_color"><i class="fontello-icon-help-circled"></i>未知</span>',
	'filecheck_modify'		=> '被修改',
	'filecheck_delete'		=> '被删除',
	'filecheck_unknown'		=> '未知',
	'filecheck_check_ok'	=> '正确',
	'jump_info'				=> '如果您的浏览器没有自动跳转，请点击这里',
	'tips'					=> '技巧提示: ',
	'filecheck_tips'		=> '<li>“<em class="edited">被修改</em>”、“<em class="del">被删除</em>” 中的列出的文件，请即刻通过 FTP 或其他工具检查其文件的正确性，以确保ECJia网店功能的正常使用。</li>
	    						<li>“<em class="unknown">未知</em>” 中的列出的文件，请检查网店是否被人非法放入了其他文件。</li>
	   							<li style="">“<em class="unknown">一周内被修改</em>” 中列出的文件，请确认最近是否修改过。</li>',
    'filename'				=> '文件名',
    'filesize'				=> '文件大小',
    'filemtime'				=> '最后修改时间',
    'filecheck_nofound_md5file'	=> '不存在校验文件，无法进行此操作',
);

// end