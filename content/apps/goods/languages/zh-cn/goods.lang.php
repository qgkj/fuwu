<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 管理中心起始页语言文件
 */
$LANG['edit_goods'] = '编辑商品信息';
$LANG['copy_goods'] = '复制商品信息';
$LANG['continue_add_goods'] = '继续添加新商品';
$LANG['back_goods_list'] = '返回商品列表';
$LANG['add_goods_ok'] = '添加商品成功。';
$LANG['edit_goods_ok'] = '编辑商品成功。';
$LANG['trash_goods_ok'] = '把商品放入回收站成功。';
$LANG['restore_goods_ok'] = '还原商品成功。';
$LANG['drop_goods_ok'] = '删除商品成功。';
$LANG['batch_handle_ok'] = '批量操作成功。';
$LANG['drop_goods_confirm'] = '您确实要删除该商品吗？';
$LANG['batch_drop_confirm'] = '彻底删除商品将删除与该商品有关的所有信息。\n您确实要删除选中的商品吗？';
$LANG['trash_goods_confirm'] = '您确实要把该商品放入回收站吗？';
$LANG['trash_product_confirm'] = '您确实要把该货品删除吗？';
$LANG['batch_trash_confirm'] = '您确实要把选中的商品放入回收站吗？';
$LANG['restore_goods_confirm'] = '您确实要把该商品还原吗？';
$LANG['batch_restore_confirm'] = '您确实要把选中的商品还原吗？';
$LANG['batch_on_sale_confirm'] = '您确实要把选中的商品上架吗？';
$LANG['batch_not_on_sale_confirm'] = '您确实要把选中的商品下架吗？';
$LANG['batch_best_confirm'] = '您确实要把选中的商品设为精品吗？';
$LANG['batch_not_best_confirm'] = '您确实要把选中的商品取消精品吗？';
$LANG['batch_new_confirm'] = '您确实要把选中的商品设为新品吗？';
$LANG['batch_not_new_confirm'] = '您确实要把选中的商品取消新品吗？';
$LANG['batch_hot_confirm'] = '您确实要把选中的商品设为热销吗？';
$LANG['batch_not_hot_confirm'] = '您确实要把选中的商品取消热销吗？';
$LANG['cannot_found_goods'] = '找不到指定的商品。';
$LANG['sel_goods_type'] = '请选择商品类型';
$LANG['sel_goods_suppliers'] = '请选择供货商';
/*------------------------------------------------------ */
//-- 图片处理相关提示信息
/*------------------------------------------------------ */
$LANG['no_gd'] = '您的服务器不支持 GD 或者没有安装处理该图片类型的扩展库。';
$LANG['img_not_exists'] = '没有找到原始图片，创建缩略图失败。';
$LANG['img_invalid'] = '创建缩略图失败，因为您上传了一个无效的图片文件。';
$LANG['create_dir_failed'] = 'images 文件夹不可写，创建缩略图失败。';
$LANG['safe_mode_warning'] = '您的服务器运行在安全模式下，而且 %s 目录不存在。您可能需要先行创建该目录才能上传图片。';
$LANG['not_writable_warning'] = '目录 %s 不可写，您需要把该目录设为可写才能上传图片。';

/*------------------------------------------------------ */
//-- 商品列表
/*------------------------------------------------------ */
$LANG['goods_cat'] = '所有分类';
$LANG['goods_brand'] = '所有品牌';
$LANG['intro_type'] = '全部';
$LANG['keyword'] = '关键字';
$LANG['is_best'] = '精品';
$LANG['is_new'] = '新品';
$LANG['is_hot'] = '热销';
$LANG['is_promote'] = '特价';
$LANG['all_type'] = '全部推荐';
$LANG['sort_order'] = '推荐排序';

$LANG['goods_name'] = '商品名称';
$LANG['goods_sn'] = '货号';
$LANG['shop_price'] = '价格';
$LANG['is_on_sale'] = '上架';
$LANG['goods_number'] = '库存';

$LANG['copy'] = '复制';
$LANG['item_list'] = '货品列表';

$LANG['integral'] = '积分额度';
$LANG['on_sale'] = '上架';
$LANG['not_on_sale'] = '下架';
$LANG['best'] = '精品';
$LANG['not_best'] = '取消精品';
$LANG['new'] = '新品';
$LANG['not_new'] = '取消新品';
$LANG['hot'] = '热销';
$LANG['not_hot'] = '取消热销';
$LANG['move_to'] = '转移到分类';

// ajax
$LANG['goods_name_null'] = '请输入商品名称';
$LANG['goods_sn_null'] = '请输入货号';
$LANG['shop_price_not_number'] = '价格不是数字';
$LANG['shop_price_invalid'] = '您输入了一个非法的市场价格。';
$LANG['goods_sn_exists'] = '您输入的货号已存在，请换一个';

/*------------------------------------------------------ */
//-- 添加/编辑商品信息
/*------------------------------------------------------ */
$LANG['tab_general'] = '通用信息';
$LANG['tab_detail'] = '详细描述';
$LANG['tab_mix'] = '其他信息';
$LANG['tab_properties'] = '商品属性';
$LANG['tab_gallery'] = '商品相册';
$LANG['tab_linkgoods'] = '关联商品';
$LANG['tab_groupgoods'] = '配件';
$LANG['tab_article'] = '关联文章';

$LANG['lab_goods_name'] = '商品名称：';
$LANG['lab_goods_sn'] = '商品货号：';
$LANG['lab_goods_cat'] = '商品分类：';
$LANG['lab_other_cat'] = '扩展分类：';
$LANG['lab_goods_brand'] = '商品品牌：';
$LANG['lab_shop_price'] = '本店售价：';
$LANG['lab_market_price'] = '市场售价：';
$LANG['lab_user_price'] = '会员价格：';
$LANG['lab_promote_price'] = '促销价：';
$LANG['lab_promote_date'] = '促销日期：';
$LANG['lab_picture'] = '上传商品图片：';
$LANG['lab_thumb'] = '上传商品缩略图：';
$LANG['auto_thumb'] = '自动生成商品缩略图';
$LANG['lab_keywords'] = '商品关键词：';
$LANG['lab_goods_brief'] = '简单描述：';
$LANG['lab_seller_note'] = '商家备注：';
$LANG['lab_goods_type'] = '商品类型：';
$LANG['lab_picture_url'] = '商品图片外部URL';
$LANG['lab_thumb_url'] = '商品缩略图外部URL';

$LANG['lab_goods_weight'] = '商品重量：';
$LANG['unit_g'] = '克';
$LANG['unit_kg'] = '千克';
$LANG['lab_goods_number'] = '库存数量：';
$LANG['lab_warn_number'] = '警告数量：';
$LANG['lab_integral'] = '积分购买金额：';
$LANG['lab_give_integral'] = '赠送消费积分数：';
$LANG['lab_rank_integral'] = '赠送等级积分数：';
$LANG['lab_intro'] = '加入推荐：';
$LANG['lab_is_on_sale'] = '上架：';
$LANG['lab_is_alone_sale'] = '能作为普通商品销售：';
$LANG['lab_is_free_shipping'] = '是否包邮：';

$LANG['compute_by_mp'] = '按市场价计算';

$LANG['notice_goods_sn'] = '如果您不输入商品货号，系统将自动生成一个唯一的货号。';
$LANG['notice_integral'] = '(此处需填写金额)购买该商品时最多可以使用积分的金额';
$LANG['notice_give_integral'] = '购买该商品时赠送消费积分数,-1表示按商品价格赠送';
$LANG['notice_rank_integral'] = '购买该商品时赠送等级积分数,-1表示按商品价格赠送';
$LANG['notice_seller_note'] = '仅供商家自己看的信息';
$LANG['notice_storage'] = '库存在商品为虚货或商品存在货品时为不可编辑状态，库存数值取决于其虚货数量或货品数量';
$LANG['notice_keywords'] = '用英文逗号分隔';
$LANG['notice_user_price'] = '会员价格为-1时表示会员价格按会员等级折扣率计算。你也可以为每个等级指定一个固定价格';
$LANG['notice_goods_type'] = '请选择商品的所属类型，进而完善此商品的属性';

$LANG['on_sale_desc'] = '打勾表示允许销售，否则不允许销售。';
$LANG['alone_sale'] = '打勾表示能作为普通商品销售，否则只能作为配件或赠品销售。';
$LANG['free_shipping'] = '打勾表示此商品不会产生运费花销，否则按照正常运费计算。';

$LANG['invalid_goods_img'] = '商品图片格式不正确！';
$LANG['invalid_goods_thumb'] = '商品缩略图格式不正确！';
$LANG['invalid_img_url'] = '商品相册中第%s个图片格式不正确!';

$LANG['goods_img_too_big'] = '商品图片文件太大了（最大值：%s），无法上传。';
$LANG['goods_thumb_too_big'] = '商品缩略图文件太大了（最大值：%s），无法上传。';
$LANG['img_url_too_big'] = '商品相册中第%s个图片文件太大了（最大值：%s），无法上传。';

$LANG['integral_market_price'] = '取整数';
$LANG['upload_images'] = '上传图片';
$LANG['spec_price'] = '属性价格';
$LANG['drop_img_confirm'] = '您确实要删除该图片吗？';

$LANG['select_font'] = '字体样式';
$LANG['font_styles'] = array('strong' => '加粗', 'em' => '斜体', 'u' => '下划线', 'strike' => '删除线');

$LANG['rapid_add_cat'] = '添加分类';
$LANG['rapid_add_brand'] = '添加品牌';
$LANG['category_manage'] = '分类管理';
$LANG['brand_manage'] = '品牌管理';
$LANG['hide'] = '隐藏';

$LANG['lab_volume_price']         = '商品优惠价格：';
$LANG['volume_number']            = '优惠数量';
$LANG['volume_price']             = '优惠价格';
$LANG['notice_volume_price']      = '购买数量达到优惠数量时享受的优惠价格';
$LANG['volume_number_continuous'] = '优惠数量重复！';

$LANG['label_suppliers']          = '选择供货商：';
$LANG['suppliers_no']             = '不指定供货商属于本店商品';
$LANG['suppliers_move_to']        = '转移到供货商';
$LANG['lab_to_shopex']         = '转移到网店';

/*------------------------------------------------------ */
//-- 关联商品
/*------------------------------------------------------ */

$LANG['all_goods'] = '可选商品';
$LANG['link_goods'] = '跟该商品关联的商品';
$LANG['single'] = '单向关联';
$LANG['double'] = '双向关联';
$LANG['all_article'] = '可选文章';
$LANG['goods_article'] = '跟该商品关联的文章';
$LANG['top_cat'] = '顶级分类';

/*------------------------------------------------------ */
//-- 组合商品
/*------------------------------------------------------ */

$LANG['group_goods'] = '该商品的配件';
$LANG['price'] = '价格';

/*------------------------------------------------------ */
//-- 商品相册
/*------------------------------------------------------ */

$LANG['img_desc'] = '图片描述';
$LANG['img_url'] = '上传文件';
$LANG['img_file'] = '或者输入外部图片链接地址';

/*------------------------------------------------------ */
//-- 关联文章
/*------------------------------------------------------ */
$LANG['article_title'] = '文章标题';

$LANG['goods_not_exist'] = '该商品不存在';
$LANG['goods_not_in_recycle_bin'] = '该商品尚未放入回收站，不能删除';

$LANG['js_languages']['goods_name_not_null'] = '商品名称不能为空。';
$LANG['js_languages']['goods_cat_not_null'] = '商品分类必须选择。';
$LANG['js_languages']['category_cat_not_null'] = '分类名称不能为空';
$LANG['js_languages']['brand_cat_not_null'] = '品牌名称不能为空';
$LANG['js_languages']['goods_cat_not_leaf'] = '您选择的商品分类不是底级分类，请选择底级分类。';
$LANG['js_languages']['shop_price_not_null'] = '本店售价不能为空。';
$LANG['js_languages']['shop_price_not_number'] = '本店售价不是数值。';

$LANG['js_languages']['select_please'] = '请选择...';
$LANG['js_languages']['button_add'] = '添加';
$LANG['js_languages']['button_del'] = '删除';
$LANG['js_languages']['spec_value_not_null'] = '规格不能为空';
$LANG['js_languages']['spec_price_not_number'] = '加价不是数字';
$LANG['js_languages']['market_price_not_number'] = '市场价格不是数字';
$LANG['js_languages']['goods_number_not_int'] = '商品库存不是整数';
$LANG['js_languages']['warn_number_not_int'] = '库存警告不是整数';
$LANG['js_languages']['promote_not_lt'] = '促销开始日期不能大于结束日期';
$LANG['js_languages']['promote_start_not_null'] = '促销开始时间不能为空';
$LANG['js_languages']['promote_end_not_null'] = '促销结束时间不能为空';

$LANG['js_languages']['drop_img_confirm'] = '您确实要删除该图片吗？';
$LANG['js_languages']['batch_no_on_sale'] = '您确实要将选定的商品下架吗？';
$LANG['js_languages']['batch_trash_confirm'] = '您确实要把选中的商品放入回收站吗？';
$LANG['js_languages']['go_category_page'] = '本页数据将丢失，确认要去商品分类页添加分类吗？';
$LANG['js_languages']['go_brand_page'] = '本页数据将丢失，确认要去商品品牌页添加品牌吗？';

$LANG['js_languages']['volume_num_not_null'] = '请输入优惠数量';
$LANG['js_languages']['volume_num_not_number'] = '优惠数量不是数字';
$LANG['js_languages']['volume_price_not_null'] = '请输入优惠价格';
$LANG['js_languages']['volume_price_not_number'] = '优惠价格不是数字';

$LANG['js_languages']['cancel_color'] = '无样式';

/* 虚拟卡 */
$LANG['card'] = '查看虚拟卡信息';
$LANG['replenish'] = '补货';
$LANG['batch_card_add'] = '批量补货';
$LANG['add_replenish'] = '添加虚拟卡卡密';

$LANG['goods_number_error'] = '商品库存数量错误';

/*------------------------------------------------------ */
//-- 货品
/*------------------------------------------------------ */
$LANG['product'] = '货品';
$LANG['product_info'] = '货品信息';
$LANG['specifications'] = '规格';
$LANG['total'] = '合计：';
$LANG['add_products'] = '添加货品';
$LANG['save_products'] = '保存货品成功';
$LANG['product_id_null'] = '货品id为空';
$LANG['cannot_found_products'] = '未找到指定货品';
$LANG['product_batch_del_success'] = '货品批量删除成功';
$LANG['product_batch_del_failure'] = '货品批量删除失败';
$LANG['batch_product_add'] = '批量添加';
$LANG['batch_product_edit'] = '批量编辑';
$LANG['products_title'] = '商品名称：%s';
$LANG['products_title_2'] = '货号：%s';
$LANG['good_shop_price'] = '（商品价格：%d）';
$LANG['good_goods_sn'] = '（商品货号：%s）';
$LANG['exist_same_goods_sn'] = '货品货号不允许与产品货号重复';
$LANG['exist_same_product_sn'] = '货品货号重复';
$LANG['cannot_add_products'] = '货品添加失败';
$LANG['exist_same_goods_attr'] = '货品规格属性重复';
$LANG['cannot_goods_number'] = '此商品存在货品，不能修改商品库存';
$LANG['not_exist_goods_attr'] = '此商品不存在规格，请为其添加规格';
$LANG['goods_sn_exists'] = '您输入的货号已存在，请换一个';

// end