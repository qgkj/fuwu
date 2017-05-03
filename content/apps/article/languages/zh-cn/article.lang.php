<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 文章管理语言项
 */

/**
 * ECJIA 文章列表字段信息 
 */
$LANG['title'] ='文章标题';
$LANG['cat'] ='文章分类';
$LANG['reserve'] = '保留';
$LANG['article_type'] ='文章重要性';
$LANG['author'] ='文章作者';
$LANG['email'] ='作者email';
$LANG['keywords'] ='关键字：';
$LANG['lable_description'] ='网页描述：';
$LANG['content'] ='文章内容：';
$LANG['is_open'] ='是否显示';
$LANG['article_id'] ='编号';
$LANG['add_time'] ='添加日期';
$LANG['upload_file'] ='上传文件：';
$LANG['file_url'] ='或输入文件地址';
$LANG['invalid_file'] = '上传文件格式不正确';
$LANG['article_name_exist'] = '有相同的文章名称存在!';
$LANG['select_plz'] = '请选择...';
$LANG['external_links'] = '外部链接：';

$LANG['top'] ='置顶';
$LANG['common'] ='普通';
$LANG['isopen'] ='显示';
$LANG['isclose'] ='不显示';
$LANG['no_article'] = '您现在还没有任何文章';
$LANG['no_select_article'] = '您没有选择任何文章';
$LANG['no_select_act'] = '请选择文章分类！';

$LANG['display'] = '显示文章内容';
$LANG['download'] = '下载文件';
$LANG['both'] = '既显示文章内容又下载文件';

$LANG['batch'] = '批量操作' ;
$LANG['button_remove'] ='批量删除';
$LANG['button_hide'] ='批量隐藏';
$LANG['button_show'] ='批量显示';
$LANG['move_to'] = '转移到分类';

$LANG['article_edit'] = '编辑文章内容';
$LANG['preview_article'] = '文章预览';
$LANG['article_editbtn'] = '编辑文章';
$LANG['view'] = '预览';
$LANG['tab_general'] = '通用信息';
$LANG['tab_content'] = '文章内容';
$LANG['tab_goods'] = '关联商品';

$LANG['link_goods'] = '跟该文章关联的商品';
$LANG['keyword'] = '关键字';

/* 提示信息 */
$LANG['title_exist'] ='文章 %s 已经存在';
$LANG['back_article_list'] ='返回文章列表';
$LANG['continue_article_add'] ='继续添加新文章';
$LANG['articleadd_succeed'] ='文章已经添加成功';
$LANG['articleedit_succeed'] ='文章 %s 成功编辑';
$LANG['articleedit_fail'] ='文章编辑失败';
$LANG['no_title'] ='没有输入文章标题';
$LANG['drop_confirm'] = '您确认要删除这篇文章吗？';
$LANG['batch_handle_ok'] = '批量操作成功';
$LANG['batch_handle_ok_del'] = '批量删除操作成功';
$LANG['batch_handle_ok_hide'] = '批量隐藏操作成功';
$LANG['batch_handle_ok_show'] = '批量显示操作成功';
$LANG['batch_handle_ok_move'] = '批量转移操作成功';

/*JS 语言项*/
$LANG['js_languages']['no_title'] = '没有文章标题';
$LANG['js_languages']['no_cat'] = '没有选择文章分类';
$LANG['js_languages']['not_allow_add'] = '系统保留分类，不允许在该分类添加文章';
$LANG['js_languages']['drop_confirm'] = '您确定要删除文章吗？';

$LANG['all_cat'] = '全部分类';
$LANG['search_article'] = '搜索文章';


/**
 * ECJIA 文章分类字段信息
 */

$LANG['cat_name'] = '文章分类名称';
$LANG['type'] = '分类类型';
$LANG['type_name'][COMMON_CAT] = '普通分类';
$LANG['type_name'][SYSTEM_CAT] = '系统分类';
$LANG['type_name'][INFO_CAT]   = '网店信息';
$LANG['type_name'][UPHELP_CAT] = '帮助分类';
$LANG['type_name'][HELP_CAT]   = '网店帮助';

$LANG['cat_keywords'] = '关键字：';
$LANG['cat_desc'] = '描述';
$LANG['parent_cat'] = '上级分类：';
$LANG['cat_top'] = '顶级分类';
$LANG['not_allow_add'] = '你所选分类不允许添加子分类';
$LANG['not_allow_remove'] = '系统保留分类，不允许删除';
$LANG['is_fullcat'] = '该分类下还有子分类，请先删除其子分类';
$LANG['show_in_nav'] = '是否显示在导航栏';

$LANG['isopen'] = '显示';
$LANG['isclose'] = '不显示';
$LANG['add_article'] = '添加文章';

$LANG['articlecat_edit'] = '编辑文章分类';


/* 提示信息 */
$LANG['catname_exist'] = '分类名 %s 已经存在';
$LANG['parent_id_err'] = '分类名 %s 的父分类不能设置成本身或本身的子分类';
$LANG['back_cat_list'] = '返回分类列表';
$LANG['continue_add'] = '继续添加新分类';
$LANG['catadd_succed'] = '已成功添加';
$LANG['catedit_succed'] = '分类 %s 编辑成功';
$LANG['edit_title_success'] = '文章标题 %s 编辑成功';
$LANG['no_catname'] = '请填入分类名';
$LANG['edit_fail'] = '编辑失败';
$LANG['enter_int'] = '请输入一个整数';
$LANG['not_emptycat'] = '分类下还有文章，不允许删除非空分类';

/*帮助信息*/
$LANG['notice_keywords'] ='关键字为选填项，其目的在于方便外部搜索引擎搜索';
$LANG['notice_isopen'] ='该文章分类是否显示在前台的主导航栏中。';

/*JS 语言项*/
$LANG['js_languages']['no_catname'] = '没有输入分类的名称';
$LANG['js_languages']['sys_hold'] = '系统保留分类，不允许添加子分类';
$LANG['js_languages']['remove_confirm'] = '您确定要删除选定的分类吗？';




/**
 * ECJIA 文章自动发布字段信息
 */
$LANG['id'] = '编号';

$LANG['starttime'] = '发布时间';
$LANG['endtime'] = '取消时间';
$LANG['article_name'] = '文章名称：';
$LANG['articleatolist_name'] = '文章名称';
$LANG['ok'] = '确定';
$LANG['edit_ok'] = '操作成功';
$LANG['edit_error'] = '操作失败';
$LANG['delete'] = '撤销';
$LANG['deleteck'] = '确定删除此文章的自动发布/取消发布处理么?此操作不会影响文章本身';
$LANG['enable_notice'] = '您需要到工具->计划任务中开启该功能后才能使用。';
$LANG['button_start'] = '批量发布';
$LANG['button_end'] = '批量取消发布';

$LANG['no_select_goods'] = '没有选定文章';

$LANG['batch_start_succeed'] = '批量发布成功';
$LANG['batch_end_succeed'] = '批量取消成功';

$LANG['back_list'] = '返回文章自动发布';
$LANG['select_time'] = '请选定时间';

// end