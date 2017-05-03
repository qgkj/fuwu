<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 商品类型管理语言文件
 */
/* 列表 */
$LANG['by_goods_type'] = '按商品类型显示：';
$LANG['all_goods_type'] = '所有商品类型';

$LANG['attr_id'] = '编号';
$LANG['cat_id'] = '商品类型';
$LANG['attr_name'] = '属性名称';
$LANG['attr_input_type'] = '属性值的录入方式';
$LANG['attr_values'] = '可选值列表';
$LANG['attr_type'] = '购买商品时是否需要选择该属性的值';

$LANG['value_attr_input_type'][ATTR_TEXT] = '手工录入';
$LANG['value_attr_input_type'][ATTR_OPTIONAL] = '从列表中选择';
$LANG['value_attr_input_type'][ATTR_TEXTAREA] = '多行文本框';

$LANG['drop_confirm'] = '您确实要删除该属性吗？';

$LANG['batchdrop'] = '批量删除';
/* 添加/编辑 */
$LANG['label_attr_name'] = '属性名称：';
$LANG['label_cat_id'] = '所属商品类型：';
$LANG['label_attr_index'] = '能否进行检索：';
$LANG['label_is_linked'] = '相同属性商品是否关联：';
$LANG['no_index'] = '不需要检索';
$LANG['keywords_index'] = '关键字检索';
$LANG['range_index'] = '范围检索';
$LANG['note_attr_index'] = '不需要该属性成为检索商品条件的情况请选择不需要检索，需要该属性进行关键字检索商品时选择关键字检索，<br/>如果该属性检索时希望是指定某个范围时，选择范围检索。';
$LANG['label_attr_input_type'] = '该属性值的录入方式：';
$LANG['text'] = '手工录入';
$LANG['select'] = '从下面的列表中选择（一行代表一个可选值）';
$LANG['text_area'] = '多行文本框';
$LANG['label_attr_values'] = '可选值列表：';
$LANG['label_attr_group'] = '属性分组：';
$LANG['label_attr_type'] = '属性是否可选：';
$LANG['note_attr_type'] = '选择"单选/复选属性"时，可以对商品该属性设置多个值，同时还能对不同属性值指定不同的价格加价，用户购买商品时需要选定具体的属性值。<br/>选择"唯一属性"时，商品的该属性值只能设置一个值，用户只能查看该值。';
$LANG['attr_type_values'][0] = '唯一属性';
$LANG['attr_type_values'][1] = '单选属性';
$LANG['attr_type_values'][2] = '复选属性';


$LANG['add_next'] = '添加下一个属性';
$LANG['back_list'] = '返回属性列表';

$LANG['add_ok'] = '添加属性 [%s] 成功。';
$LANG['edit_ok'] = '编辑属性 [%s] 成功。';

/* 提示信息 */
$LANG['name_exist'] = '该属性名称已存在，请您换一个名称。';
$LANG['drop_confirm'] = '您确实要删除该属性吗？';
$LANG['notice_drop_confirm'] = '已经有%s个商品使用该属性，您确实要删除该属性吗？';
$LANG['name_not_null'] = '属性名称不能为空。';

$LANG['no_select_arrt'] = '您没有选择需要删除的属性名';
$LANG['drop_ok'] = '成功删除了 %d 条商品属性';

$LANG['js_languages']['name_not_null'] = '请您输入属性名称。';
$LANG['js_languages']['values_not_null'] = '请您输入该属性的可选值。';
$LANG['js_languages']['cat_id_not_null'] = '请您选择该属性所属的商品类型。';

// end