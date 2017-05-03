<?php
  
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ECJIA 商品批量上传、修改语言文件
 */
return array(
	'select_method' => '选择商品的方式：',
	'by_cat' 		=> '根据商品分类、品牌',
	'by_sn' 		=> '根据商品货号',
	'select_cat' 	=> '选择商品分类：',
	'select_brand' 	=> '选择商品品牌：',
	'goods_list' 	=> '商品列表：',
	'src_list' 		=> '待选列表：',
	'dest_list' 	=> '选定列表：',
	'input_sn' 		=> '输入商品货号：',
	'edit_method' 	=> '编辑方式：',
	'edit_each' 	=> '逐个编辑',
	'edit_all' 		=> '统一编辑',
	'go_edit' 		=> '进入编辑',
		
	'notice_edit' 	=> '会员价格为-1表示会员价格将根据会员等级折扣比例计算',
	'goods_class' 	=> '商品类别',
		
	'g_class' => array(
		G_REAL => '实体商品',
		G_CARD => '虚拟卡',
	),
		
	'goods_sn' 		=> '货号',
	'goods_name'	=> '商品名称',
	'market_price' 	=> '市场价格',
	'shop_price' 	=> '本店价格',
	'integral' 		=> '积分购买',
	'give_integral' => '赠送积分',
	'goods_number' 	=> '库存',
	'brand' 		=> '品牌',
	'batch_edit_ok' => '批量修改成功',
	
	'export_format' 	=> '数据格式',
	'export_ecshop' 	=> 'ECSJia支持数据格式',
	'export_taobao' 	=> '淘宝助理支持数据格式',
	'export_taobao46' 	=> '淘宝助理4.6支持数据格式',
	'export_paipai' 	=> '拍拍助理支持数据格式',
	'export_paipai3' 	=> '拍拍助理3.0支持数据格式',
	'goods_cat' 		=> '所属分类：',
	'csv_file' 			=> '上传批量csv文件：',
	'notice_file' 		=> '（CSV文件中一次上传商品数量最好不要超过1000，CSV文件大小最好不要超过500K.）',
	'file_charset' 		=> '文件编码：',
	'download_file' 	=> '下载批量CSV文件（%s）',
	
	'use_help' => '使用说明：' .
			'<ol>' .
			'<li>根据使用习惯，下载相应语言的csv文件，例如中国内地用户下载简体中文语言的文件，港台用户下载繁体语言的文件；</li>' .
			'<li>填写csv文件，可以使用excel或文本编辑器打开csv文件；<br />' .
			'碰到“是否精品”之类，填写数字0或者1，0代表“否”，1代表“是”；<br />' .
			'商品图片和商品缩略图请填写带路径的图片文件名，其中路径是相对于 [根目录]/images/ 的路径，例如图片路径为[根目录]/images/200610/abc.jpg，只要填写 200610/abc.jpg 即可；<br />' .
			'<font style="color:#FE596A,">如果是淘宝助理格式请确保cvs编码为在网站的编码，如编码不正确，可以用编辑软件转换编码。</font></li>' .
			'<li>将填写的商品图片和商品缩略图上传到相应目录，例如：[根目录]/images/200610/；<br />'.
			'<font style="color:#FE596A,">请首先上传商品图片和商品缩略图再上传csv文件，否则图片无法处理。</font></li>' .
			'<li>选择所上传商品的分类以及文件编码，上传csv文件</li>' .
			'</ol>',
			
	'js_languages' => array(
		'please_select_goods' 	=> '请您选择商品',
		'please_input_sn' 		=> '请您输入商品货号',
		'goods_cat_not_leaf' 	=> '请选择底级分类',
		'please_select_cat' 	=> '请您选择所属分类',
		'please_upload_file' 	=> '请您上传批量csv文件',
	),
		
	// 批量上传商品的字段
	'upload_goods' => array(
		'goods_name' 	=> '商品名称',
		'goods_sn' 		=> '商品货号',
		'brand_name' 	=> '商品品牌',   // 需要转换成brand_id
		'market_price' 	=> '市场售价',
		'shop_price' 	=> '本店售价',
		'integral' 		=> '积分购买额度',
		'original_img' 	=> '商品原始图',
		'goods_img' 	=> '商品图片',
		'goods_thumb' 	=> '商品缩略图',
		'keywords' 		=> '商品关键词',
		'goods_brief' 	=> '简单描述',
		'goods_desc' 	=> '详细描述',
		'goods_weight' 	=> '商品重量（kg）',
		'goods_number' 	=> '库存数量',
		'warn_number' 	=> '库存警告数量',
		'is_best' 		=> '是否精品',
		'is_new' 		=> '是否新品',
		'is_hot' 		=> '是否热销',
		'is_on_sale' 	=> '是否上架',
		'is_alone_sale' => '能否作为普通商品销售',
		'is_real' 		=> '是否实体商品',
	),
	
	'batch_upload_ok' 		=> '批量上传成功',
	'goods_upload_confirm' 	=> '批量上传确认',
	'batch_choose_goods'	=> '批量选择商品',
	'batch_edit_goods'		=> '批量修改商品',
	'not_exist_goods'		=> '不存在的商品',
	'back_last_page'		=> '返回上一页',
	'batch_edit_ok'			=> '批量修改商品成功！',
	'select_please'			=> '请选择',
	'uniform_goods_name'	=> '统一修改的商品名称：',
	'all_category'			=> '所有分类',
	'all_brand'				=> '所有品牌',
	'filter_goods_info'		=> '筛选搜索到的商品信息',
	'no_content'			=> '暂无内容',
	'choost_goods_list'		=> '选定商品列表',
	'one_per_line'			=> '（每行一个）',
);

// end