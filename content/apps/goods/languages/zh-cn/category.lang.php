<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 商品分类管理语言文件
 */
/* 商品分类字段信息 */
$LANG['cat_id'] = '编号';
$LANG['cat_name'] = '分类名称';
$LANG['isleaf'] = '不允许';
$LANG['noleaf'] = '允许';
$LANG['keywords'] = '关键字';
$LANG['cat_desc'] = '分类描述';
$LANG['parent_id'] = '上级分类';
$LANG['sort_order'] = '排序';
$LANG['measure_unit'] = '数量单位';
$LANG['delete_info'] = '删除选中';
$LANG['category_edit'] = '编辑商品分类';
$LANG['move_goods'] = '转移商品';
$LANG['cat_top'] = '顶级分类';
$LANG['show_in_nav'] = '是否显示在导航栏';
$LANG['cat_style'] = '分类的样式表文件';
$LANG['is_show'] = '是否显示';
$LANG['show_in_index'] = '设置为首页推荐';
$LANG['notice_show_in_index'] = '该设置可以在首页的最新、热门、推荐处显示该分类下的推荐商品';
$LANG['goods_number'] = '商品数量';
$LANG['grade'] = '价格区间个数';
$LANG['notice_grade'] = '该选项表示该分类下商品最低价与最高价之间的划分的等级个数，填0表示不做分级，最多不能超过10个。';
$LANG['short_grade'] = '价格分级';

$LANG['nav'] = '导航栏';
$LANG['index_new'] = '最新';
$LANG['index_best'] = '精品';
$LANG['index_hot'] = '热门';

$LANG['back_list'] = '返回分类列表';
$LANG['continue_add'] = '继续添加分类';

$LANG['notice_style'] = '您可以为每一个商品分类指定一个样式表文件。例如文件存放在 themes 目录下则输入：themes/style.css';

/* 操作提示信息 */
$LANG['catname_empty'] = '分类名称不能为空!';
$LANG['catname_exist'] = '已存在相同的分类名称!';
$LANG["parent_isleaf"] = '所选分类不能是末级分类!';
$LANG["cat_isleaf"] = '不是末级分类或者此分类下还存在有商品,您不能删除!';
$LANG["cat_noleaf"] = '底下还有其它子分类,不能修改为末级分类!';
$LANG["is_leaf_error"] = '所选择的上级分类不能是当前分类或者当前分类的下级分类!';
$LANG['grade_error'] = '价格分级数量只能是0-10之内的整数';

$LANG['catadd_succed'] = '新商品分类添加成功!';
$LANG['catedit_succed'] = '商品分类编辑成功!';
$LANG['catdrop_succed'] = '商品分类删除成功!';
$LANG['catremove_succed'] = '商品分类转移成功!';
$LANG['move_cat_success'] = '转移商品分类已成功完成!';

$LANG['cat_move_desc'] = '什么是转移商品分类?';
$LANG['select_source_cat'] = '选择要转移的分类';
$LANG['select_target_cat'] = '选择目标分类';
$LANG['source_cat'] = '从此分类';
$LANG['target_cat'] = '转移到';
$LANG['start_move_cat'] = '开始转移';
$LANG['cat_move_notic'] = '在添加商品或者在商品管理中,如果需要对商品的分类进行变更,那么你可以通过此功能,正确管理你的商品分类。';

$LANG['cat_move_empty'] = '你没有正确选择商品分类!';

$LANG['sel_goods_type'] = '请选择商品类型';
$LANG['sel_filter_attr'] = '请选择筛选属性';
$LANG['filter_attr'] = '筛选属性';
$LANG['filter_attr_notic'] = '筛选属性可在前分类页面筛选商品';
$LANG['filter_attr_not_repeated'] = '筛选属性不可重复';

/*JS 语言项*/
$LANG['js_languages']['catname_empty'] = '分类名称不能为空!';
$LANG['js_languages']['unit_empyt'] = '数量单位不能为空!';
$LANG['js_languages']['is_leafcat'] = '您选定的分类是一个末级分类。\r\n新分类的上级分类不能是一个末级分类';
$LANG['js_languages']['not_leafcat'] = '您选定的分类不是一个末级分类。\r\n商品的分类转移只能在末级分类之间才可以操作。';
$LANG['js_languages']['filter_attr_not_repeated'] = '筛选属性不可重复';
$LANG['js_languages']['filter_attr_not_selected'] = '请选择筛选属性';

// end