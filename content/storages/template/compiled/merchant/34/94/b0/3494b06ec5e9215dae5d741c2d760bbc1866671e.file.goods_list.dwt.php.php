<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 09:10:24
         compiled from "C:\ecjia-daojia-29\content\apps\goods\templates\merchant\goods_list.dwt.php" */ ?>
<?php /*%%SmartyHeaderCode:109259084d001fe050-85212364%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3494b06ec5e9215dae5d741c2d760bbc1866671e' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\content\\apps\\goods\\templates\\merchant\\goods_list.dwt.php',
      1 => 1487583417,
      2 => 'file',
    ),
    '7703001e1fb3c0f519c99b33d9866831283851ca' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\content\\apps\\merchant\\templates\\merchant\\ecjia-merchant.dwt.php',
      1 => 1487583418,
      2 => 'file',
    ),
    '52f8ed6aa01f6b081bb81e9835584af95a4cb579' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\content\\apps\\merchant\\templates\\merchant\\library\\common_header.lbi.php',
      1 => 1487583418,
      2 => 'file',
    ),
    'ae0fd3ee2dbcd492a6d55bb6a23f1d1cfaa18a51' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\content\\apps\\merchant\\templates\\merchant\\library\\common_footer.lbi.php',
      1 => 1487583418,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '109259084d001fe050-85212364',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ur_here' => 0,
    'ecjia_merchant_cptitle' => 0,
    'ecjia_main_static_url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_59084d008d1384_10844318',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59084d008d1384_10844318')) {function content_59084d008d1384_10844318($_smarty_tpl) {?><?php if (!is_callable('smarty_function_hook')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.hook.php';
if (!is_callable('smarty_function_lang')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.lang.php';
if (!is_callable('smarty_function_url')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.url.php';
?><?php if (!is_pjax()) {?>
<!DOCTYPE html>
<html lang="zh" class="pjaxLoadding-busy">
<head>
<meta name="Generator" content="ECJIA 1.20" />
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php if ($_smarty_tpl->tpl_vars['ur_here']->value) {?><?php echo $_smarty_tpl->tpl_vars['ur_here']->value;?>
<?php }?><?php if ($_smarty_tpl->tpl_vars['ecjia_merchant_cptitle']->value) {?> - <?php echo $_smarty_tpl->tpl_vars['ecjia_merchant_cptitle']->value;?>
<?php }?></title>
	<meta name="description" content="<?php echo ecjia::config('');?>
" />
	<meta name="keywords" content="<?php echo ecjia::config('');?>
" />
	<meta name="author" content="ecjia team" />
	<link rel="shortcut icon" href="favicon.ico">
    
    <!--[if lt IE 9]>
      <script src="<?php echo $_smarty_tpl->tpl_vars['ecjia_main_static_url']->value;?>
js/html5shiv.js"></script>
      <script src="<?php echo $_smarty_tpl->tpl_vars['ecjia_main_static_url']->value;?>
js/respond.min.js"></script>
    <![endif]-->
    <?php echo smarty_function_hook(array('id'=>'merchant_print_styles'),$_smarty_tpl);?>

    <?php echo smarty_function_hook(array('id'=>'merchant_print_scripts'),$_smarty_tpl);?>

    <?php echo $_smarty_tpl->getSubTemplate ("library/common_meta.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    
	
    <?php echo smarty_function_hook(array('id'=>'merchant_head'),$_smarty_tpl);?>

</head>
<body>
    
    <div id="wrapper">
        
        <?php /*  Call merged included template "library/common_header.lbi.php" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("library/common_header.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0, '109259084d001fe050-85212364');
content_59084d002df182_61391462($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "library/common_header.lbi.php" */?>
        

        
        <div class="container">
            <div id="main" class="main_content">
                
                <?php echo smarty_function_hook(array('id'=>'merchant_print_main_header'),$_smarty_tpl);?>

                
                

<div class="modal fade" id="movetype">
	<div class="modal-dialog">
    	<div class="modal-content">
			<div class="modal-header">
				<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
				<h4 class="modal-title"><?php echo smarty_function_lang(array('key'=>'goods::goods.move_to_cat'),$_smarty_tpl);?>
</h4>
			</div>
			<div class="modal-body h400">
				<form class="form-horizontal" method="post" name="batchForm">
					<div class="form-group ecjiaf-tac">
						<div>
							<select class="noselect w200 ecjiaf-ib form-control" size="15" name="target_cat">
							<?php if ($_smarty_tpl->tpl_vars['cat_list']->value) {?>
								<?php  $_smarty_tpl->tpl_vars['cat'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cat']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cat_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cat']->key => $_smarty_tpl->tpl_vars['cat']->value) {
$_smarty_tpl->tpl_vars['cat']->_loop = true;
?>
								<option value="<?php echo $_smarty_tpl->tpl_vars['cat']->value['cat_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['cat']->value['level']) {?>style="padding-left:<?php echo $_smarty_tpl->tpl_vars['cat']->value['level']*20;?>
px"<?php }?>><?php echo $_smarty_tpl->tpl_vars['cat']->value['cat_name'];?>
</option>
								<?php } ?>
							<?php } else { ?>
								<option value="0">暂无任何分类</option>
							<?php }?>
							</select>
						</div>
					</div>
					<div class="form-group t_c">
						<a class="btn btn-primary m_l5 disabled" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="<?php echo $_smarty_tpl->tpl_vars['form_action']->value;?>
&type=move_to&" data-msg="<?php echo smarty_function_lang(array('key'=>'goods::goods.move_confirm'),$_smarty_tpl);?>
" data-noSelectMsg="<?php echo smarty_function_lang(array('key'=>'goods::goods.select_move_goods'),$_smarty_tpl);?>
" href="javascript:;" name="move_cat_ture"><?php echo smarty_function_lang(array('key'=>'goods::goods.start_move'),$_smarty_tpl);?>
</a>
					</div>
				</form>
           </div>
		</div>
	</div>
</div>

<div class="page-header">
	<div class="pull-left">
		<h2><?php if ($_smarty_tpl->tpl_vars['ur_here']->value) {?><?php echo $_smarty_tpl->tpl_vars['ur_here']->value;?>
<?php }?></h2>
  	</div>
  	<div class="pull-right">
  		<?php if ($_smarty_tpl->tpl_vars['action_link']->value) {?>
		<a href="<?php echo $_smarty_tpl->tpl_vars['action_link']->value['href'];?>
" class="btn btn-primary data-pjax">
			<i class="fa fa-plus"></i> <?php echo $_smarty_tpl->tpl_vars['action_link']->value['text'];?>

		</a>
		<?php }?>
  	</div>
  	<div class="clearfix"></div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			<div class="panel-body panel-body-small">
				<ul class="nav nav-pills pull-left">
					<li class="<?php if (!$_GET['type']) {?>active<?php }?>">
						<a class="data-pjax" href='<?php echo RC_Uri::url("goods/merchant/init",((string)$_smarty_tpl->tpl_vars['get_url']->value)."&type=''");?>
'><?php echo smarty_function_lang(array('key'=>'goods::goods.intro_type'),$_smarty_tpl);?>
 
							<span class="badge badge-info"><?php echo $_smarty_tpl->tpl_vars['goods_list']->value['filter']['count_goods_num'];?>
</span>
						</a>
					</li>
					
					<li class="<?php if ($_GET['type']==1) {?>active<?php }?>">
						<a class="data-pjax" href='<?php echo RC_Uri::url("goods/merchant/init",((string)$_smarty_tpl->tpl_vars['get_url']->value)."&type=1");?>
'><?php echo smarty_function_lang(array('key'=>'goods::goods.is_on_saled'),$_smarty_tpl);?>

							<span class="badge badge-info use-plugins-num"><?php echo $_smarty_tpl->tpl_vars['goods_list']->value['filter']['count_on_sale'];?>
</span>
						</a>
					</li>
					
					<li class="<?php if ($_GET['type']==2) {?>active<?php }?>">	
						<a class="data-pjax" href='<?php echo RC_Uri::url("goods/merchant/init",((string)$_smarty_tpl->tpl_vars['get_url']->value)."&type=2");?>
'><?php echo smarty_function_lang(array('key'=>'goods::goods.not_on_saled'),$_smarty_tpl);?>

							<span class="badge badge-info unuse-plugins-num"><?php echo $_smarty_tpl->tpl_vars['goods_list']->value['filter']['count_not_sale'];?>
</span>
						</a>
					</li>
				</ul>	
				<div class="clearfix"></div>
			</div>
			
			<div class="panel-body panel-body-small">
				<div class="btn-group f_l">
					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> <?php echo smarty_function_lang(array('key'=>'goods::goods.batch_handle'),$_smarty_tpl);?>
 <span class="caret"></span></button>
					<ul class="dropdown-menu">
		                <li><a class="batch-trash-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="<?php echo $_smarty_tpl->tpl_vars['form_action']->value;?>
&type=trash&is_on_sale=<?php echo $_smarty_tpl->tpl_vars['goods_list']->value['filter']['is_on_sale'];?>
&page=<?php echo $_GET['page'];?>
" data-msg="<?php echo smarty_function_lang(array('key'=>'goods::goods.batch_trash_confirm'),$_smarty_tpl);?>
" data-noSelectMsg="<?php echo smarty_function_lang(array('key'=>'goods::goods.select_trash_goods'),$_smarty_tpl);?>
" href="javascript:;"><i class="fa fa-archive"></i> <?php echo smarty_function_lang(array('key'=>'goods::goods.move_to_trash'),$_smarty_tpl);?>
</a></li>
						<li><a class="batch-sale-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="<?php echo $_smarty_tpl->tpl_vars['form_action']->value;?>
&type=on_sale&is_on_sale=<?php echo $_smarty_tpl->tpl_vars['goods_list']->value['filter']['is_on_sale'];?>
&page=<?php echo $_GET['page'];?>
" data-msg="<?php echo smarty_function_lang(array('key'=>'goods::goods.batch_on_sale_confirm'),$_smarty_tpl);?>
" data-noSelectMsg="<?php echo smarty_function_lang(array('key'=>'goods::goods.select_sale_goods'),$_smarty_tpl);?>
" href="javascript:;"><i class="fa fa-arrow-circle-o-up"></i> <?php echo smarty_function_lang(array('key'=>'goods::goods.on_sale'),$_smarty_tpl);?>
</a></li>
						<li><a class="batch-notsale-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="<?php echo $_smarty_tpl->tpl_vars['form_action']->value;?>
&type=not_on_sale&is_on_sale=<?php echo $_smarty_tpl->tpl_vars['goods_list']->value['filter']['is_on_sale'];?>
&page=<?php echo $_GET['page'];?>
" data-msg="<?php echo smarty_function_lang(array('key'=>'goods::goods.batch_not_on_sale_confirm'),$_smarty_tpl);?>
" data-noSelectMsg="<?php echo smarty_function_lang(array('key'=>'goods::goods.select_not_sale_goods'),$_smarty_tpl);?>
" href="javascript:;"><i class="fa fa-arrow-circle-o-down"></i> <?php echo smarty_function_lang(array('key'=>'goods::goods.not_on_sale'),$_smarty_tpl);?>
</a></li>
						<li><a class="batch-best-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="<?php echo $_smarty_tpl->tpl_vars['form_action']->value;?>
&type=best&is_on_sale=<?php echo $_smarty_tpl->tpl_vars['goods_list']->value['filter']['is_on_sale'];?>
&page=<?php echo $_GET['page'];?>
" data-msg="<?php echo smarty_function_lang(array('key'=>'goods::goods.batch_best_confirm'),$_smarty_tpl);?>
" data-noSelectMsg="<?php echo smarty_function_lang(array('key'=>'goods::goods.select_best_goods'),$_smarty_tpl);?>
" href="javascript:;"><i class="fa fa-star"></i> <?php echo smarty_function_lang(array('key'=>'goods::goods.best'),$_smarty_tpl);?>
 </a></li>
						<li><a class="batch-notbest-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="<?php echo $_smarty_tpl->tpl_vars['form_action']->value;?>
&type=not_best&is_on_sale=<?php echo $_smarty_tpl->tpl_vars['goods_list']->value['filter']['is_on_sale'];?>
&page=<?php echo $_GET['page'];?>
" data-msg="<?php echo smarty_function_lang(array('key'=>'goods::goods.batch_not_best_confirm'),$_smarty_tpl);?>
" data-noSelectMsg="<?php echo smarty_function_lang(array('key'=>'goods::goods.select_not_best_goods'),$_smarty_tpl);?>
" href="javascript:;"><i class="fa fa-star-o"></i> <?php echo smarty_function_lang(array('key'=>'goods::goods.not_best'),$_smarty_tpl);?>
</a></li>
						<li><a class="batch-new-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="<?php echo $_smarty_tpl->tpl_vars['form_action']->value;?>
&type=new&is_on_sale=<?php echo $_smarty_tpl->tpl_vars['goods_list']->value['filter']['is_on_sale'];?>
&page=<?php echo $_GET['page'];?>
" data-msg="<?php echo smarty_function_lang(array('key'=>'goods::goods.batch_new_confirm'),$_smarty_tpl);?>
" data-noSelectMsg="<?php echo smarty_function_lang(array('key'=>'goods::goods.select_new_goods'),$_smarty_tpl);?>
" href="javascript:;"><i class="fa fa-flag"></i> <?php echo smarty_function_lang(array('key'=>'goods::goods.new'),$_smarty_tpl);?>
</a></li>
						<li><a class="batch-notnew-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="<?php echo $_smarty_tpl->tpl_vars['form_action']->value;?>
&type=not_new&is_on_sale=<?php echo $_smarty_tpl->tpl_vars['goods_list']->value['filter']['is_on_sale'];?>
&page=<?php echo $_GET['page'];?>
" data-msg="<?php echo smarty_function_lang(array('key'=>'goods::goods.batch_not_new_confirm'),$_smarty_tpl);?>
" data-noSelectMsg="<?php echo smarty_function_lang(array('key'=>'goods::goods.select_not_news_goods'),$_smarty_tpl);?>
" href="javascript:;"><i class="fa fa-flag-o"></i> <?php echo smarty_function_lang(array('key'=>'goods::goods.not_new'),$_smarty_tpl);?>
</a></li>
						<li><a class="batch-hot-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="<?php echo $_smarty_tpl->tpl_vars['form_action']->value;?>
&type=hot&is_on_sale=<?php echo $_smarty_tpl->tpl_vars['goods_list']->value['filter']['is_on_sale'];?>
&page=<?php echo $_GET['page'];?>
" data-msg="<?php echo smarty_function_lang(array('key'=>'goods::goods.batch_hot_confirm'),$_smarty_tpl);?>
" data-noSelectMsg="<?php echo smarty_function_lang(array('key'=>'goods::goods.select_hot_goods'),$_smarty_tpl);?>
" href="javascript:;"><i class="fa fa-thumbs-up"></i> <?php echo smarty_function_lang(array('key'=>'goods::goods.hot'),$_smarty_tpl);?>
</a></li>
						<li><a class="batch-nothot-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="<?php echo $_smarty_tpl->tpl_vars['form_action']->value;?>
&type=not_hot&is_on_sale=<?php echo $_smarty_tpl->tpl_vars['goods_list']->value['filter']['is_on_sale'];?>
&page=<?php echo $_GET['page'];?>
" data-msg="<?php echo smarty_function_lang(array('key'=>'goods::goods.batch_not_hot_confirm'),$_smarty_tpl);?>
" data-noSelectMsg="<?php echo smarty_function_lang(array('key'=>'goods::goods.select_not_hot_goods'),$_smarty_tpl);?>
" href="javascript:;"><i class="fa fa-thumbs-o-up"></i> <?php echo smarty_function_lang(array('key'=>'goods::goods.not_hot'),$_smarty_tpl);?>
</a></li>
						<li><a class="batch-move-btn" data-name="move_cat" data-move="data-operatetype" href="javascript:;"><i class="fa fa-mail-forward"></i> <?php echo smarty_function_lang(array('key'=>'goods::goods.move_to'),$_smarty_tpl);?>
</a></li>
		           	</ul>
				</div>
				
				<form class="form-inline f_l m_l5" action="<?php echo RC_Uri::url('goods/merchant/init');?>
<?php echo $_smarty_tpl->tpl_vars['get_url']->value;?>
" method="post" name="filter_form">
					<div class="screen f_l">
						<div class="form-group">
							<select class="w130" name="review_status">
								<option value="-1">请选择...</option>
								<option value="1" <?php if ($_smarty_tpl->tpl_vars['filter']->value['review_status']==1) {?>selected<?php }?>>未审核</option>
								<option value="2" <?php if ($_smarty_tpl->tpl_vars['filter']->value['review_status']==2) {?>selected<?php }?>>审核未通过</option>
								<option value="3" <?php if ($_smarty_tpl->tpl_vars['filter']->value['review_status']==3) {?>selected<?php }?>>已审核</option>
								<option value="5" <?php if ($_smarty_tpl->tpl_vars['filter']->value['review_status']==5) {?>selected<?php }?>>无需审核</option>
							</select>
						</div>
						<button class="btn btn-primary filter-btn" type="button"><i class="fa fa-search"></i> <?php echo smarty_function_lang(array('key'=>'goods::goods.filter'),$_smarty_tpl);?>
 </button>
					</div>
				</form>
				
				<form class="form-inline f_r" action="<?php echo RC_Uri::url('goods/merchant/init');?>
<?php echo $_smarty_tpl->tpl_vars['get_url']->value;?>
" method="post" name="search_form">
					<div class="screen f_r">
						<div class="form-group">
							<select class="w130" name="cat_id">
								<option value="0"><?php echo smarty_function_lang(array('key'=>'goods::goods.goods_cat'),$_smarty_tpl);?>
</option>
								<?php  $_smarty_tpl->tpl_vars['cat'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cat']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cat_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cat']->key => $_smarty_tpl->tpl_vars['cat']->value) {
$_smarty_tpl->tpl_vars['cat']->_loop = true;
?>
								<option value="<?php echo $_smarty_tpl->tpl_vars['cat']->value['cat_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['cat']->value['cat_id']==$_GET['cat_id']) {?>selected<?php }?> <?php if ($_smarty_tpl->tpl_vars['cat']->value['level']) {?>style="padding-left:<?php echo $_smarty_tpl->tpl_vars['cat']->value['level']*20;?>
px"<?php }?>><?php echo $_smarty_tpl->tpl_vars['cat']->value['cat_name'];?>
</option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group">
							<select class="w130" name="intro_type">
								<option value="0"><?php echo smarty_function_lang(array('key'=>'goods::goods.intro_type'),$_smarty_tpl);?>
</option>
								<?php  $_smarty_tpl->tpl_vars['list'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['list']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['intro_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['list']->key => $_smarty_tpl->tpl_vars['list']->value) {
$_smarty_tpl->tpl_vars['list']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['list']->key;
?>
								<option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['key']->value==$_GET['intro_type']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['list']->value;?>
</option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group">
							<input type="text" class="form-control" name="keywords" value="<?php echo $_GET['keywords'];?>
" placeholder="<?php echo smarty_function_lang(array('key'=>'goods::goods.enter_goods_keywords'),$_smarty_tpl);?>
">
						</div>
						<button class="btn btn-primary screen-btn" type="button"><i class="fa fa-search"></i> 搜索 </button>
					</div>
				</form>
			</div>
			
			<div class="panel-body panel-body-small">
				<section class="panel">
					<table class="table table-striped table-hover table-hide-edit ecjiaf-tlf">
						<thead>
							<tr data-sorthref="<?php echo RC_Uri::url('goods/merchant/init');?>
<?php echo $_smarty_tpl->tpl_vars['get_url']->value;?>
">
								<th class="table_checkbox check-list w30">
									<div class="check-item">
										<input id="checkall" type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/>
										<label for="checkall"></label>
									</div>
								</th>
								<th class="w100 text-center"><?php echo smarty_function_lang(array('key'=>'goods::goods.thumb'),$_smarty_tpl);?>
</th>
								<th data-toggle="sortby" data-sortby="goods_id"><?php echo smarty_function_lang(array('key'=>'goods::goods.goods_name'),$_smarty_tpl);?>
</th>
								<th class="w110 sorting " data-toggle="sortby" data-sortby="goods_sn"><?php echo smarty_function_lang(array('key'=>'goods::goods.goods_sn'),$_smarty_tpl);?>
</th>
								<th class="w100 sorting text-center" data-toggle="sortby" data-sortby="shop_price"><?php echo smarty_function_lang(array('key'=>'goods::goods.shop_price'),$_smarty_tpl);?>
</th>
								<th class="w70 text-center"> <?php echo smarty_function_lang(array('key'=>'goods::goods.is_on_sale'),$_smarty_tpl);?>
 </th>
								<th class="w70 text-center"> <?php echo smarty_function_lang(array('key'=>'goods::goods.is_best'),$_smarty_tpl);?>
 </th>
								<th class="w70 text-center"> <?php echo smarty_function_lang(array('key'=>'goods::goods.is_new'),$_smarty_tpl);?>
 </th>
								<th class="w70 text-center"> <?php echo smarty_function_lang(array('key'=>'goods::goods.is_hot'),$_smarty_tpl);?>
 </th>
								<?php if ($_smarty_tpl->tpl_vars['use_storage']->value) {?>
								<th class="w70 text-center" data-toggle="sortby" data-sortby="goods_number"> <?php echo smarty_function_lang(array('key'=>'goods::goods.goods_number'),$_smarty_tpl);?>
 </th>
								<?php }?> 
								<th class="w70 sorting text-center" data-toggle="sortby" data-sortby="store_sort_order">排序</th>
							</tr>
						</thead>
						<tbody>
							<?php  $_smarty_tpl->tpl_vars['goods'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['goods']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['goods_list']->value['goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['goods']->key => $_smarty_tpl->tpl_vars['goods']->value) {
$_smarty_tpl->tpl_vars['goods']->_loop = true;
?>
							<tr>
								<td class="check-list">
									<div class="check-item">
										<input id="check_<?php echo $_smarty_tpl->tpl_vars['goods']->value['goods_id'];?>
" class="checkbox" type="checkbox" name="checkboxes[]" value="<?php echo $_smarty_tpl->tpl_vars['goods']->value['goods_id'];?>
"/>
										<label for="check_<?php echo $_smarty_tpl->tpl_vars['goods']->value['goods_id'];?>
"></label>
									</div>
								</td>						
								<td>
									<a href='<?php echo smarty_function_url(array('path'=>"goods/merchant/edit",'args'=>"goods_id=".((string)$_smarty_tpl->tpl_vars['goods']->value['goods_id'])),$_smarty_tpl);?>
'>
										<img class="w80 h80" alt="<?php echo $_smarty_tpl->tpl_vars['goods']->value['goods_name'];?>
" src="<?php echo $_smarty_tpl->tpl_vars['goods']->value['goods_thumb'];?>
">
									</a>
								</td>
								<td class="hide-edit-area <?php if ($_smarty_tpl->tpl_vars['goods']->value['is_promote']) {?>ecjiafc-red<?php }?>">
									<span class="cursor_pointer ecjiaf-pre ecjiaf-wsn" data-text="textarea" data-trigger="editable" data-url="<?php echo RC_Uri::url('goods/merchant/edit_goods_name');?>
" data-name="goods_edit_name" data-pk="<?php echo $_smarty_tpl->tpl_vars['goods']->value['goods_id'];?>
" data-title="请输入商品名称"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['goods']->value['goods_name'], ENT_QUOTES, 'UTF-8', true);?>
</span>
									<br/>
									<div class="edit-list">
										<a class="data-pjax" href='<?php echo smarty_function_url(array('path'=>"goods/merchant/edit",'args'=>"goods_id=".((string)$_smarty_tpl->tpl_vars['goods']->value['goods_id'])),$_smarty_tpl);?>
'><?php echo smarty_function_lang(array('key'=>'system::system.edit'),$_smarty_tpl);?>
</a>&nbsp;|&nbsp;
										<a class="data-pjax" href='<?php echo smarty_function_url(array('path'=>"goods/merchant/edit_goods_desc",'args'=>"goods_id=".((string)$_smarty_tpl->tpl_vars['goods']->value['goods_id'])),$_smarty_tpl);?>
'><?php echo smarty_function_lang(array('key'=>'goods::goods.tab_detail'),$_smarty_tpl);?>
</a>&nbsp;|&nbsp;
										<a class="data-pjax" href='<?php echo smarty_function_url(array('path'=>"goods/merchant/edit_goods_attr",'args'=>"goods_id=".((string)$_smarty_tpl->tpl_vars['goods']->value['goods_id'])),$_smarty_tpl);?>
'><?php echo smarty_function_lang(array('key'=>'goods::goods.tab_properties'),$_smarty_tpl);?>
</a>&nbsp;|&nbsp;
										<a class="data-pjax" href='<?php echo smarty_function_url(array('path'=>"goods/mh_gallery/init",'args'=>"goods_id=".((string)$_smarty_tpl->tpl_vars['goods']->value['goods_id'])),$_smarty_tpl);?>
'><?php echo smarty_function_lang(array('key'=>'goods::goods.tab_gallery'),$_smarty_tpl);?>
</a>&nbsp;|&nbsp;
										<a class="data-pjax" href='<?php echo smarty_function_url(array('path'=>"goods/merchant/edit_link_goods",'args'=>"goods_id=".((string)$_smarty_tpl->tpl_vars['goods']->value['goods_id'])),$_smarty_tpl);?>
'><?php echo smarty_function_lang(array('key'=>'goods::goods.tab_linkgoods'),$_smarty_tpl);?>
</a>&nbsp;|&nbsp;
<!-- 										<a class="data-pjax" href='<?php echo smarty_function_url(array('path'=>"goods/merchant/edit_link_parts",'args'=>"goods_id=".((string)$_smarty_tpl->tpl_vars['goods']->value['goods_id'])),$_smarty_tpl);?>
'><?php echo smarty_function_lang(array('key'=>'goods::goods.tab_groupgoods'),$_smarty_tpl);?>
</a>&nbsp;|&nbsp; -->
<!-- 										<a class="data-pjax" href='<?php echo smarty_function_url(array('path'=>"goods/merchant/edit_link_article",'args'=>"goods_id=".((string)$_smarty_tpl->tpl_vars['goods']->value['goods_id'])),$_smarty_tpl);?>
'><?php echo smarty_function_lang(array('key'=>'goods::goods.tab_article'),$_smarty_tpl);?>
</a>&nbsp;|&nbsp; -->
										<a target="_blank" href='<?php echo smarty_function_url(array('path'=>"goods/merchant/preview",'args'=>"id=".((string)$_smarty_tpl->tpl_vars['goods']->value['goods_id'])),$_smarty_tpl);?>
'><?php echo smarty_function_lang(array('key'=>'goods::goods.preview'),$_smarty_tpl);?>
</a>&nbsp;|&nbsp;
										<?php if ($_smarty_tpl->tpl_vars['specifications']->value[$_smarty_tpl->tpl_vars['goods']->value['goods_type']]!='') {?><a target="_blank" href='<?php echo smarty_function_url(array('path'=>"goods/merchant/product_list",'args'=>"goods_id=".((string)$_smarty_tpl->tpl_vars['goods']->value['goods_id'])),$_smarty_tpl);?>
'><?php echo smarty_function_lang(array('key'=>'goods::goods.product_list'),$_smarty_tpl);?>
</a>&nbsp;|&nbsp;<?php }?>
										<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="<?php echo smarty_function_lang(array('key'=>'goods::goods.trash_goods_confirm'),$_smarty_tpl);?>
" href='<?php echo smarty_function_url(array('path'=>"goods/merchant/remove",'args'=>"id=".((string)$_smarty_tpl->tpl_vars['goods']->value['goods_id'])),$_smarty_tpl);?>
'><?php echo smarty_function_lang(array('key'=>'system::system.drop'),$_smarty_tpl);?>
</a>
									</div>
								</td>	
								
								<td>
									<span class="cursor_pointer" data-trigger="editable" data-url="<?php echo RC_Uri::url('goods/merchant/edit_goods_sn');?>
" data-name="goods_edit_goods_sn" data-pk="<?php echo $_smarty_tpl->tpl_vars['goods']->value['goods_id'];?>
" data-title="请输入商品货号">
										<?php echo $_smarty_tpl->tpl_vars['goods']->value['goods_sn'];?>
 
									</span>
								</td>
								<td align="center">
									<span class="cursor_pointer" data-trigger="editable" data-url="<?php echo RC_Uri::url('goods/merchant/edit_goods_price');?>
" data-name="goods_price" data-pk="<?php echo $_smarty_tpl->tpl_vars['goods']->value['goods_id'];?>
" data-title="请输入商品价格"> 
										<?php echo $_smarty_tpl->tpl_vars['goods']->value['shop_price'];?>

									</span> 
								</td>
								<td align="center">
									<i class="cursor_pointer fa <?php if ($_smarty_tpl->tpl_vars['goods']->value['is_on_sale']) {?>fa-check <?php } else { ?>fa-times<?php }?>" data-trigger="toggle_on_sale" data-url="<?php echo RC_Uri::url('goods/merchant/toggle_on_sale');?>
" refresh-url="<?php echo RC_Uri::url('goods/merchant/init');?>
<?php echo $_smarty_tpl->tpl_vars['get_url']->value;?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['goods']->value['goods_id'];?>
"></i>
								</td>
								<td align="center">
									<i class="cursor_pointer fa <?php if ($_smarty_tpl->tpl_vars['goods']->value['store_best']) {?>fa-check <?php } else { ?>fa-times<?php }?>" data-trigger="toggleState" data-url="<?php echo RC_Uri::url('goods/merchant/toggle_best');?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['goods']->value['goods_id'];?>
"></i>
								</td>
								<td align="center">
									<i class="cursor_pointer fa <?php if ($_smarty_tpl->tpl_vars['goods']->value['store_new']) {?>fa-check <?php } else { ?>fa-times<?php }?>" data-trigger="toggleState" data-url="<?php echo RC_Uri::url('goods/merchant/toggle_new');?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['goods']->value['goods_id'];?>
"></i>
								</td>
								<td align="center">
									<i class="cursor_pointer fa <?php if ($_smarty_tpl->tpl_vars['goods']->value['store_hot']) {?>fa-check <?php } else { ?>fa-times<?php }?>" data-trigger="toggleState" data-url="<?php echo RC_Uri::url('goods/merchant/toggle_hot');?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['goods']->value['goods_id'];?>
"></i>
								</td>
								<?php if ($_smarty_tpl->tpl_vars['use_storage']->value) {?>
								<td align="center">
									<span class="cursor_pointer" data-trigger="editable" data-url="<?php echo RC_Uri::url('goods/merchant/edit_goods_number');?>
" data-name="goods_number" data-pk="<?php echo $_smarty_tpl->tpl_vars['goods']->value['goods_id'];?>
" data-title="请输入库存数量">
										<?php echo $_smarty_tpl->tpl_vars['goods']->value['goods_number'];?>

									</span>
								</td>
								<?php }?>
								<td align="center">
									<span class="cursor_pointer" data-trigger="editable" data-placement="left" data-url="<?php echo RC_Uri::url('goods/merchant/edit_sort_order');?>
" data-name="sort_order" data-pk="<?php echo $_smarty_tpl->tpl_vars['goods']->value['goods_id'];?>
" data-title="请输入排序序号"> 
										<?php echo $_smarty_tpl->tpl_vars['goods']->value['store_sort_order'];?>

									</span>
								</td>
							</tr>
							<?php }
if (!$_smarty_tpl->tpl_vars['goods']->_loop) {
?>
							<tr>
								<td class="no-records" colspan="11"><?php echo smarty_function_lang(array('key'=>'system::system.no_records'),$_smarty_tpl);?>
</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</section>
				<?php echo $_smarty_tpl->tpl_vars['goods_list']->value['page'];?>

			</div>
		</div>
	</div>
</div>

                <?php echo smarty_function_hook(array('id'=>'merchant_print_main_bottom'),$_smarty_tpl);?>

            </div>
        </div>
        

        
        <?php /*  Call merged included template "library/common_footer.lbi.php" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("library/common_footer.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0, '109259084d001fe050-85212364');
content_59084d005e1b14_65747656($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "library/common_footer.lbi.php" */?>
        
    </div>
    
	
	
    <?php echo smarty_function_hook(array('id'=>'merchant_print_footer_scripts'),$_smarty_tpl);?>

    
    
    
<script type="text/javascript">
	ecjia.merchant.goods_list.init();
</script>

    
    <?php echo smarty_function_hook(array('id'=>'merchant_footer'),$_smarty_tpl);?>

    <div class="pjaxLoadding"><i class="peg"></i></div>
</body>
</html>
<?php } else { ?>
	
	<?php echo smarty_function_hook(array('id'=>'merchant_pjax_head'),$_smarty_tpl);?>

	<?php echo smarty_function_hook(array('id'=>'merchant_print_main_header'),$_smarty_tpl);?>

	

<div class="modal fade" id="movetype">
	<div class="modal-dialog">
    	<div class="modal-content">
			<div class="modal-header">
				<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
				<h4 class="modal-title"><?php echo smarty_function_lang(array('key'=>'goods::goods.move_to_cat'),$_smarty_tpl);?>
</h4>
			</div>
			<div class="modal-body h400">
				<form class="form-horizontal" method="post" name="batchForm">
					<div class="form-group ecjiaf-tac">
						<div>
							<select class="noselect w200 ecjiaf-ib form-control" size="15" name="target_cat">
							<?php if ($_smarty_tpl->tpl_vars['cat_list']->value) {?>
								<?php  $_smarty_tpl->tpl_vars['cat'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cat']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cat_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cat']->key => $_smarty_tpl->tpl_vars['cat']->value) {
$_smarty_tpl->tpl_vars['cat']->_loop = true;
?>
								<option value="<?php echo $_smarty_tpl->tpl_vars['cat']->value['cat_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['cat']->value['level']) {?>style="padding-left:<?php echo $_smarty_tpl->tpl_vars['cat']->value['level']*20;?>
px"<?php }?>><?php echo $_smarty_tpl->tpl_vars['cat']->value['cat_name'];?>
</option>
								<?php } ?>
							<?php } else { ?>
								<option value="0">暂无任何分类</option>
							<?php }?>
							</select>
						</div>
					</div>
					<div class="form-group t_c">
						<a class="btn btn-primary m_l5 disabled" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="<?php echo $_smarty_tpl->tpl_vars['form_action']->value;?>
&type=move_to&" data-msg="<?php echo smarty_function_lang(array('key'=>'goods::goods.move_confirm'),$_smarty_tpl);?>
" data-noSelectMsg="<?php echo smarty_function_lang(array('key'=>'goods::goods.select_move_goods'),$_smarty_tpl);?>
" href="javascript:;" name="move_cat_ture"><?php echo smarty_function_lang(array('key'=>'goods::goods.start_move'),$_smarty_tpl);?>
</a>
					</div>
				</form>
           </div>
		</div>
	</div>
</div>

<div class="page-header">
	<div class="pull-left">
		<h2><?php if ($_smarty_tpl->tpl_vars['ur_here']->value) {?><?php echo $_smarty_tpl->tpl_vars['ur_here']->value;?>
<?php }?></h2>
  	</div>
  	<div class="pull-right">
  		<?php if ($_smarty_tpl->tpl_vars['action_link']->value) {?>
		<a href="<?php echo $_smarty_tpl->tpl_vars['action_link']->value['href'];?>
" class="btn btn-primary data-pjax">
			<i class="fa fa-plus"></i> <?php echo $_smarty_tpl->tpl_vars['action_link']->value['text'];?>

		</a>
		<?php }?>
  	</div>
  	<div class="clearfix"></div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			<div class="panel-body panel-body-small">
				<ul class="nav nav-pills pull-left">
					<li class="<?php if (!$_GET['type']) {?>active<?php }?>">
						<a class="data-pjax" href='<?php echo RC_Uri::url("goods/merchant/init",((string)$_smarty_tpl->tpl_vars['get_url']->value)."&type=''");?>
'><?php echo smarty_function_lang(array('key'=>'goods::goods.intro_type'),$_smarty_tpl);?>
 
							<span class="badge badge-info"><?php echo $_smarty_tpl->tpl_vars['goods_list']->value['filter']['count_goods_num'];?>
</span>
						</a>
					</li>
					
					<li class="<?php if ($_GET['type']==1) {?>active<?php }?>">
						<a class="data-pjax" href='<?php echo RC_Uri::url("goods/merchant/init",((string)$_smarty_tpl->tpl_vars['get_url']->value)."&type=1");?>
'><?php echo smarty_function_lang(array('key'=>'goods::goods.is_on_saled'),$_smarty_tpl);?>

							<span class="badge badge-info use-plugins-num"><?php echo $_smarty_tpl->tpl_vars['goods_list']->value['filter']['count_on_sale'];?>
</span>
						</a>
					</li>
					
					<li class="<?php if ($_GET['type']==2) {?>active<?php }?>">	
						<a class="data-pjax" href='<?php echo RC_Uri::url("goods/merchant/init",((string)$_smarty_tpl->tpl_vars['get_url']->value)."&type=2");?>
'><?php echo smarty_function_lang(array('key'=>'goods::goods.not_on_saled'),$_smarty_tpl);?>

							<span class="badge badge-info unuse-plugins-num"><?php echo $_smarty_tpl->tpl_vars['goods_list']->value['filter']['count_not_sale'];?>
</span>
						</a>
					</li>
				</ul>	
				<div class="clearfix"></div>
			</div>
			
			<div class="panel-body panel-body-small">
				<div class="btn-group f_l">
					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> <?php echo smarty_function_lang(array('key'=>'goods::goods.batch_handle'),$_smarty_tpl);?>
 <span class="caret"></span></button>
					<ul class="dropdown-menu">
		                <li><a class="batch-trash-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="<?php echo $_smarty_tpl->tpl_vars['form_action']->value;?>
&type=trash&is_on_sale=<?php echo $_smarty_tpl->tpl_vars['goods_list']->value['filter']['is_on_sale'];?>
&page=<?php echo $_GET['page'];?>
" data-msg="<?php echo smarty_function_lang(array('key'=>'goods::goods.batch_trash_confirm'),$_smarty_tpl);?>
" data-noSelectMsg="<?php echo smarty_function_lang(array('key'=>'goods::goods.select_trash_goods'),$_smarty_tpl);?>
" href="javascript:;"><i class="fa fa-archive"></i> <?php echo smarty_function_lang(array('key'=>'goods::goods.move_to_trash'),$_smarty_tpl);?>
</a></li>
						<li><a class="batch-sale-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="<?php echo $_smarty_tpl->tpl_vars['form_action']->value;?>
&type=on_sale&is_on_sale=<?php echo $_smarty_tpl->tpl_vars['goods_list']->value['filter']['is_on_sale'];?>
&page=<?php echo $_GET['page'];?>
" data-msg="<?php echo smarty_function_lang(array('key'=>'goods::goods.batch_on_sale_confirm'),$_smarty_tpl);?>
" data-noSelectMsg="<?php echo smarty_function_lang(array('key'=>'goods::goods.select_sale_goods'),$_smarty_tpl);?>
" href="javascript:;"><i class="fa fa-arrow-circle-o-up"></i> <?php echo smarty_function_lang(array('key'=>'goods::goods.on_sale'),$_smarty_tpl);?>
</a></li>
						<li><a class="batch-notsale-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="<?php echo $_smarty_tpl->tpl_vars['form_action']->value;?>
&type=not_on_sale&is_on_sale=<?php echo $_smarty_tpl->tpl_vars['goods_list']->value['filter']['is_on_sale'];?>
&page=<?php echo $_GET['page'];?>
" data-msg="<?php echo smarty_function_lang(array('key'=>'goods::goods.batch_not_on_sale_confirm'),$_smarty_tpl);?>
" data-noSelectMsg="<?php echo smarty_function_lang(array('key'=>'goods::goods.select_not_sale_goods'),$_smarty_tpl);?>
" href="javascript:;"><i class="fa fa-arrow-circle-o-down"></i> <?php echo smarty_function_lang(array('key'=>'goods::goods.not_on_sale'),$_smarty_tpl);?>
</a></li>
						<li><a class="batch-best-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="<?php echo $_smarty_tpl->tpl_vars['form_action']->value;?>
&type=best&is_on_sale=<?php echo $_smarty_tpl->tpl_vars['goods_list']->value['filter']['is_on_sale'];?>
&page=<?php echo $_GET['page'];?>
" data-msg="<?php echo smarty_function_lang(array('key'=>'goods::goods.batch_best_confirm'),$_smarty_tpl);?>
" data-noSelectMsg="<?php echo smarty_function_lang(array('key'=>'goods::goods.select_best_goods'),$_smarty_tpl);?>
" href="javascript:;"><i class="fa fa-star"></i> <?php echo smarty_function_lang(array('key'=>'goods::goods.best'),$_smarty_tpl);?>
 </a></li>
						<li><a class="batch-notbest-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="<?php echo $_smarty_tpl->tpl_vars['form_action']->value;?>
&type=not_best&is_on_sale=<?php echo $_smarty_tpl->tpl_vars['goods_list']->value['filter']['is_on_sale'];?>
&page=<?php echo $_GET['page'];?>
" data-msg="<?php echo smarty_function_lang(array('key'=>'goods::goods.batch_not_best_confirm'),$_smarty_tpl);?>
" data-noSelectMsg="<?php echo smarty_function_lang(array('key'=>'goods::goods.select_not_best_goods'),$_smarty_tpl);?>
" href="javascript:;"><i class="fa fa-star-o"></i> <?php echo smarty_function_lang(array('key'=>'goods::goods.not_best'),$_smarty_tpl);?>
</a></li>
						<li><a class="batch-new-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="<?php echo $_smarty_tpl->tpl_vars['form_action']->value;?>
&type=new&is_on_sale=<?php echo $_smarty_tpl->tpl_vars['goods_list']->value['filter']['is_on_sale'];?>
&page=<?php echo $_GET['page'];?>
" data-msg="<?php echo smarty_function_lang(array('key'=>'goods::goods.batch_new_confirm'),$_smarty_tpl);?>
" data-noSelectMsg="<?php echo smarty_function_lang(array('key'=>'goods::goods.select_new_goods'),$_smarty_tpl);?>
" href="javascript:;"><i class="fa fa-flag"></i> <?php echo smarty_function_lang(array('key'=>'goods::goods.new'),$_smarty_tpl);?>
</a></li>
						<li><a class="batch-notnew-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="<?php echo $_smarty_tpl->tpl_vars['form_action']->value;?>
&type=not_new&is_on_sale=<?php echo $_smarty_tpl->tpl_vars['goods_list']->value['filter']['is_on_sale'];?>
&page=<?php echo $_GET['page'];?>
" data-msg="<?php echo smarty_function_lang(array('key'=>'goods::goods.batch_not_new_confirm'),$_smarty_tpl);?>
" data-noSelectMsg="<?php echo smarty_function_lang(array('key'=>'goods::goods.select_not_news_goods'),$_smarty_tpl);?>
" href="javascript:;"><i class="fa fa-flag-o"></i> <?php echo smarty_function_lang(array('key'=>'goods::goods.not_new'),$_smarty_tpl);?>
</a></li>
						<li><a class="batch-hot-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="<?php echo $_smarty_tpl->tpl_vars['form_action']->value;?>
&type=hot&is_on_sale=<?php echo $_smarty_tpl->tpl_vars['goods_list']->value['filter']['is_on_sale'];?>
&page=<?php echo $_GET['page'];?>
" data-msg="<?php echo smarty_function_lang(array('key'=>'goods::goods.batch_hot_confirm'),$_smarty_tpl);?>
" data-noSelectMsg="<?php echo smarty_function_lang(array('key'=>'goods::goods.select_hot_goods'),$_smarty_tpl);?>
" href="javascript:;"><i class="fa fa-thumbs-up"></i> <?php echo smarty_function_lang(array('key'=>'goods::goods.hot'),$_smarty_tpl);?>
</a></li>
						<li><a class="batch-nothot-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="<?php echo $_smarty_tpl->tpl_vars['form_action']->value;?>
&type=not_hot&is_on_sale=<?php echo $_smarty_tpl->tpl_vars['goods_list']->value['filter']['is_on_sale'];?>
&page=<?php echo $_GET['page'];?>
" data-msg="<?php echo smarty_function_lang(array('key'=>'goods::goods.batch_not_hot_confirm'),$_smarty_tpl);?>
" data-noSelectMsg="<?php echo smarty_function_lang(array('key'=>'goods::goods.select_not_hot_goods'),$_smarty_tpl);?>
" href="javascript:;"><i class="fa fa-thumbs-o-up"></i> <?php echo smarty_function_lang(array('key'=>'goods::goods.not_hot'),$_smarty_tpl);?>
</a></li>
						<li><a class="batch-move-btn" data-name="move_cat" data-move="data-operatetype" href="javascript:;"><i class="fa fa-mail-forward"></i> <?php echo smarty_function_lang(array('key'=>'goods::goods.move_to'),$_smarty_tpl);?>
</a></li>
		           	</ul>
				</div>
				
				<form class="form-inline f_l m_l5" action="<?php echo RC_Uri::url('goods/merchant/init');?>
<?php echo $_smarty_tpl->tpl_vars['get_url']->value;?>
" method="post" name="filter_form">
					<div class="screen f_l">
						<div class="form-group">
							<select class="w130" name="review_status">
								<option value="-1">请选择...</option>
								<option value="1" <?php if ($_smarty_tpl->tpl_vars['filter']->value['review_status']==1) {?>selected<?php }?>>未审核</option>
								<option value="2" <?php if ($_smarty_tpl->tpl_vars['filter']->value['review_status']==2) {?>selected<?php }?>>审核未通过</option>
								<option value="3" <?php if ($_smarty_tpl->tpl_vars['filter']->value['review_status']==3) {?>selected<?php }?>>已审核</option>
								<option value="5" <?php if ($_smarty_tpl->tpl_vars['filter']->value['review_status']==5) {?>selected<?php }?>>无需审核</option>
							</select>
						</div>
						<button class="btn btn-primary filter-btn" type="button"><i class="fa fa-search"></i> <?php echo smarty_function_lang(array('key'=>'goods::goods.filter'),$_smarty_tpl);?>
 </button>
					</div>
				</form>
				
				<form class="form-inline f_r" action="<?php echo RC_Uri::url('goods/merchant/init');?>
<?php echo $_smarty_tpl->tpl_vars['get_url']->value;?>
" method="post" name="search_form">
					<div class="screen f_r">
						<div class="form-group">
							<select class="w130" name="cat_id">
								<option value="0"><?php echo smarty_function_lang(array('key'=>'goods::goods.goods_cat'),$_smarty_tpl);?>
</option>
								<?php  $_smarty_tpl->tpl_vars['cat'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cat']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cat_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cat']->key => $_smarty_tpl->tpl_vars['cat']->value) {
$_smarty_tpl->tpl_vars['cat']->_loop = true;
?>
								<option value="<?php echo $_smarty_tpl->tpl_vars['cat']->value['cat_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['cat']->value['cat_id']==$_GET['cat_id']) {?>selected<?php }?> <?php if ($_smarty_tpl->tpl_vars['cat']->value['level']) {?>style="padding-left:<?php echo $_smarty_tpl->tpl_vars['cat']->value['level']*20;?>
px"<?php }?>><?php echo $_smarty_tpl->tpl_vars['cat']->value['cat_name'];?>
</option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group">
							<select class="w130" name="intro_type">
								<option value="0"><?php echo smarty_function_lang(array('key'=>'goods::goods.intro_type'),$_smarty_tpl);?>
</option>
								<?php  $_smarty_tpl->tpl_vars['list'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['list']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['intro_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['list']->key => $_smarty_tpl->tpl_vars['list']->value) {
$_smarty_tpl->tpl_vars['list']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['list']->key;
?>
								<option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['key']->value==$_GET['intro_type']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['list']->value;?>
</option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group">
							<input type="text" class="form-control" name="keywords" value="<?php echo $_GET['keywords'];?>
" placeholder="<?php echo smarty_function_lang(array('key'=>'goods::goods.enter_goods_keywords'),$_smarty_tpl);?>
">
						</div>
						<button class="btn btn-primary screen-btn" type="button"><i class="fa fa-search"></i> 搜索 </button>
					</div>
				</form>
			</div>
			
			<div class="panel-body panel-body-small">
				<section class="panel">
					<table class="table table-striped table-hover table-hide-edit ecjiaf-tlf">
						<thead>
							<tr data-sorthref="<?php echo RC_Uri::url('goods/merchant/init');?>
<?php echo $_smarty_tpl->tpl_vars['get_url']->value;?>
">
								<th class="table_checkbox check-list w30">
									<div class="check-item">
										<input id="checkall" type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/>
										<label for="checkall"></label>
									</div>
								</th>
								<th class="w100 text-center"><?php echo smarty_function_lang(array('key'=>'goods::goods.thumb'),$_smarty_tpl);?>
</th>
								<th data-toggle="sortby" data-sortby="goods_id"><?php echo smarty_function_lang(array('key'=>'goods::goods.goods_name'),$_smarty_tpl);?>
</th>
								<th class="w110 sorting " data-toggle="sortby" data-sortby="goods_sn"><?php echo smarty_function_lang(array('key'=>'goods::goods.goods_sn'),$_smarty_tpl);?>
</th>
								<th class="w100 sorting text-center" data-toggle="sortby" data-sortby="shop_price"><?php echo smarty_function_lang(array('key'=>'goods::goods.shop_price'),$_smarty_tpl);?>
</th>
								<th class="w70 text-center"> <?php echo smarty_function_lang(array('key'=>'goods::goods.is_on_sale'),$_smarty_tpl);?>
 </th>
								<th class="w70 text-center"> <?php echo smarty_function_lang(array('key'=>'goods::goods.is_best'),$_smarty_tpl);?>
 </th>
								<th class="w70 text-center"> <?php echo smarty_function_lang(array('key'=>'goods::goods.is_new'),$_smarty_tpl);?>
 </th>
								<th class="w70 text-center"> <?php echo smarty_function_lang(array('key'=>'goods::goods.is_hot'),$_smarty_tpl);?>
 </th>
								<?php if ($_smarty_tpl->tpl_vars['use_storage']->value) {?>
								<th class="w70 text-center" data-toggle="sortby" data-sortby="goods_number"> <?php echo smarty_function_lang(array('key'=>'goods::goods.goods_number'),$_smarty_tpl);?>
 </th>
								<?php }?> 
								<th class="w70 sorting text-center" data-toggle="sortby" data-sortby="store_sort_order">排序</th>
							</tr>
						</thead>
						<tbody>
							<?php  $_smarty_tpl->tpl_vars['goods'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['goods']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['goods_list']->value['goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['goods']->key => $_smarty_tpl->tpl_vars['goods']->value) {
$_smarty_tpl->tpl_vars['goods']->_loop = true;
?>
							<tr>
								<td class="check-list">
									<div class="check-item">
										<input id="check_<?php echo $_smarty_tpl->tpl_vars['goods']->value['goods_id'];?>
" class="checkbox" type="checkbox" name="checkboxes[]" value="<?php echo $_smarty_tpl->tpl_vars['goods']->value['goods_id'];?>
"/>
										<label for="check_<?php echo $_smarty_tpl->tpl_vars['goods']->value['goods_id'];?>
"></label>
									</div>
								</td>						
								<td>
									<a href='<?php echo smarty_function_url(array('path'=>"goods/merchant/edit",'args'=>"goods_id=".((string)$_smarty_tpl->tpl_vars['goods']->value['goods_id'])),$_smarty_tpl);?>
'>
										<img class="w80 h80" alt="<?php echo $_smarty_tpl->tpl_vars['goods']->value['goods_name'];?>
" src="<?php echo $_smarty_tpl->tpl_vars['goods']->value['goods_thumb'];?>
">
									</a>
								</td>
								<td class="hide-edit-area <?php if ($_smarty_tpl->tpl_vars['goods']->value['is_promote']) {?>ecjiafc-red<?php }?>">
									<span class="cursor_pointer ecjiaf-pre ecjiaf-wsn" data-text="textarea" data-trigger="editable" data-url="<?php echo RC_Uri::url('goods/merchant/edit_goods_name');?>
" data-name="goods_edit_name" data-pk="<?php echo $_smarty_tpl->tpl_vars['goods']->value['goods_id'];?>
" data-title="请输入商品名称"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['goods']->value['goods_name'], ENT_QUOTES, 'UTF-8', true);?>
</span>
									<br/>
									<div class="edit-list">
										<a class="data-pjax" href='<?php echo smarty_function_url(array('path'=>"goods/merchant/edit",'args'=>"goods_id=".((string)$_smarty_tpl->tpl_vars['goods']->value['goods_id'])),$_smarty_tpl);?>
'><?php echo smarty_function_lang(array('key'=>'system::system.edit'),$_smarty_tpl);?>
</a>&nbsp;|&nbsp;
										<a class="data-pjax" href='<?php echo smarty_function_url(array('path'=>"goods/merchant/edit_goods_desc",'args'=>"goods_id=".((string)$_smarty_tpl->tpl_vars['goods']->value['goods_id'])),$_smarty_tpl);?>
'><?php echo smarty_function_lang(array('key'=>'goods::goods.tab_detail'),$_smarty_tpl);?>
</a>&nbsp;|&nbsp;
										<a class="data-pjax" href='<?php echo smarty_function_url(array('path'=>"goods/merchant/edit_goods_attr",'args'=>"goods_id=".((string)$_smarty_tpl->tpl_vars['goods']->value['goods_id'])),$_smarty_tpl);?>
'><?php echo smarty_function_lang(array('key'=>'goods::goods.tab_properties'),$_smarty_tpl);?>
</a>&nbsp;|&nbsp;
										<a class="data-pjax" href='<?php echo smarty_function_url(array('path'=>"goods/mh_gallery/init",'args'=>"goods_id=".((string)$_smarty_tpl->tpl_vars['goods']->value['goods_id'])),$_smarty_tpl);?>
'><?php echo smarty_function_lang(array('key'=>'goods::goods.tab_gallery'),$_smarty_tpl);?>
</a>&nbsp;|&nbsp;
										<a class="data-pjax" href='<?php echo smarty_function_url(array('path'=>"goods/merchant/edit_link_goods",'args'=>"goods_id=".((string)$_smarty_tpl->tpl_vars['goods']->value['goods_id'])),$_smarty_tpl);?>
'><?php echo smarty_function_lang(array('key'=>'goods::goods.tab_linkgoods'),$_smarty_tpl);?>
</a>&nbsp;|&nbsp;
<!-- 										<a class="data-pjax" href='<?php echo smarty_function_url(array('path'=>"goods/merchant/edit_link_parts",'args'=>"goods_id=".((string)$_smarty_tpl->tpl_vars['goods']->value['goods_id'])),$_smarty_tpl);?>
'><?php echo smarty_function_lang(array('key'=>'goods::goods.tab_groupgoods'),$_smarty_tpl);?>
</a>&nbsp;|&nbsp; -->
<!-- 										<a class="data-pjax" href='<?php echo smarty_function_url(array('path'=>"goods/merchant/edit_link_article",'args'=>"goods_id=".((string)$_smarty_tpl->tpl_vars['goods']->value['goods_id'])),$_smarty_tpl);?>
'><?php echo smarty_function_lang(array('key'=>'goods::goods.tab_article'),$_smarty_tpl);?>
</a>&nbsp;|&nbsp; -->
										<a target="_blank" href='<?php echo smarty_function_url(array('path'=>"goods/merchant/preview",'args'=>"id=".((string)$_smarty_tpl->tpl_vars['goods']->value['goods_id'])),$_smarty_tpl);?>
'><?php echo smarty_function_lang(array('key'=>'goods::goods.preview'),$_smarty_tpl);?>
</a>&nbsp;|&nbsp;
										<?php if ($_smarty_tpl->tpl_vars['specifications']->value[$_smarty_tpl->tpl_vars['goods']->value['goods_type']]!='') {?><a target="_blank" href='<?php echo smarty_function_url(array('path'=>"goods/merchant/product_list",'args'=>"goods_id=".((string)$_smarty_tpl->tpl_vars['goods']->value['goods_id'])),$_smarty_tpl);?>
'><?php echo smarty_function_lang(array('key'=>'goods::goods.product_list'),$_smarty_tpl);?>
</a>&nbsp;|&nbsp;<?php }?>
										<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="<?php echo smarty_function_lang(array('key'=>'goods::goods.trash_goods_confirm'),$_smarty_tpl);?>
" href='<?php echo smarty_function_url(array('path'=>"goods/merchant/remove",'args'=>"id=".((string)$_smarty_tpl->tpl_vars['goods']->value['goods_id'])),$_smarty_tpl);?>
'><?php echo smarty_function_lang(array('key'=>'system::system.drop'),$_smarty_tpl);?>
</a>
									</div>
								</td>	
								
								<td>
									<span class="cursor_pointer" data-trigger="editable" data-url="<?php echo RC_Uri::url('goods/merchant/edit_goods_sn');?>
" data-name="goods_edit_goods_sn" data-pk="<?php echo $_smarty_tpl->tpl_vars['goods']->value['goods_id'];?>
" data-title="请输入商品货号">
										<?php echo $_smarty_tpl->tpl_vars['goods']->value['goods_sn'];?>
 
									</span>
								</td>
								<td align="center">
									<span class="cursor_pointer" data-trigger="editable" data-url="<?php echo RC_Uri::url('goods/merchant/edit_goods_price');?>
" data-name="goods_price" data-pk="<?php echo $_smarty_tpl->tpl_vars['goods']->value['goods_id'];?>
" data-title="请输入商品价格"> 
										<?php echo $_smarty_tpl->tpl_vars['goods']->value['shop_price'];?>

									</span> 
								</td>
								<td align="center">
									<i class="cursor_pointer fa <?php if ($_smarty_tpl->tpl_vars['goods']->value['is_on_sale']) {?>fa-check <?php } else { ?>fa-times<?php }?>" data-trigger="toggle_on_sale" data-url="<?php echo RC_Uri::url('goods/merchant/toggle_on_sale');?>
" refresh-url="<?php echo RC_Uri::url('goods/merchant/init');?>
<?php echo $_smarty_tpl->tpl_vars['get_url']->value;?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['goods']->value['goods_id'];?>
"></i>
								</td>
								<td align="center">
									<i class="cursor_pointer fa <?php if ($_smarty_tpl->tpl_vars['goods']->value['store_best']) {?>fa-check <?php } else { ?>fa-times<?php }?>" data-trigger="toggleState" data-url="<?php echo RC_Uri::url('goods/merchant/toggle_best');?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['goods']->value['goods_id'];?>
"></i>
								</td>
								<td align="center">
									<i class="cursor_pointer fa <?php if ($_smarty_tpl->tpl_vars['goods']->value['store_new']) {?>fa-check <?php } else { ?>fa-times<?php }?>" data-trigger="toggleState" data-url="<?php echo RC_Uri::url('goods/merchant/toggle_new');?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['goods']->value['goods_id'];?>
"></i>
								</td>
								<td align="center">
									<i class="cursor_pointer fa <?php if ($_smarty_tpl->tpl_vars['goods']->value['store_hot']) {?>fa-check <?php } else { ?>fa-times<?php }?>" data-trigger="toggleState" data-url="<?php echo RC_Uri::url('goods/merchant/toggle_hot');?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['goods']->value['goods_id'];?>
"></i>
								</td>
								<?php if ($_smarty_tpl->tpl_vars['use_storage']->value) {?>
								<td align="center">
									<span class="cursor_pointer" data-trigger="editable" data-url="<?php echo RC_Uri::url('goods/merchant/edit_goods_number');?>
" data-name="goods_number" data-pk="<?php echo $_smarty_tpl->tpl_vars['goods']->value['goods_id'];?>
" data-title="请输入库存数量">
										<?php echo $_smarty_tpl->tpl_vars['goods']->value['goods_number'];?>

									</span>
								</td>
								<?php }?>
								<td align="center">
									<span class="cursor_pointer" data-trigger="editable" data-placement="left" data-url="<?php echo RC_Uri::url('goods/merchant/edit_sort_order');?>
" data-name="sort_order" data-pk="<?php echo $_smarty_tpl->tpl_vars['goods']->value['goods_id'];?>
" data-title="请输入排序序号"> 
										<?php echo $_smarty_tpl->tpl_vars['goods']->value['store_sort_order'];?>

									</span>
								</td>
							</tr>
							<?php }
if (!$_smarty_tpl->tpl_vars['goods']->_loop) {
?>
							<tr>
								<td class="no-records" colspan="11"><?php echo smarty_function_lang(array('key'=>'system::system.no_records'),$_smarty_tpl);?>
</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</section>
				<?php echo $_smarty_tpl->tpl_vars['goods_list']->value['page'];?>

			</div>
		</div>
	</div>
</div>

	<?php echo smarty_function_hook(array('id'=>'merchant_print_main_bottom'),$_smarty_tpl);?>

	
<script type="text/javascript">
	ecjia.merchant.goods_list.init();
</script>

	<?php echo smarty_function_hook(array('id'=>'merchant_pjax_footer'),$_smarty_tpl);?>

<?php }?>
<?php }} ?>
<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 09:10:24
         compiled from "C:\ecjia-daojia-29\content\apps\merchant\templates\merchant\library\common_header.lbi.php" */ ?>
<?php if ($_valid && !is_callable('content_59084d002df182_61391462')) {function content_59084d002df182_61391462($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.url.php';
if (!is_callable('smarty_block_t')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\block.t.php';
if (!is_callable('smarty_function_hook')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.hook.php';
?><?php if (!$_SESSION['staff_id']) {?>
<div class="header-top">
    
    <nav class="navbar navbar-inverse navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="container">
            
            <div class="navbar-header">
                <a class="navbar-brand" href="<?php echo RC_Uri::url('franchisee/merchant/init');?>
"><i class="fa fa-cubes"></i> <strong><?php echo ecjia::config('shop_name');?>
 - 商家入驻</strong></a>
            </div>
            
            <ul class="nav navbar-nav navbar-left top-menu">
                
                
            </ul>
            <ul class="nav navbar-nav navbar-right top-menu">
            	<a class="ecjiafc-white l_h30" href='<?php echo RC_Uri::home_url();?>
'><i class="fa fa-reply"></i> 返回网站首页</a>
            </ul>
        </div>
    </nav>
    
</div>

<div id="header" <?php if ($_smarty_tpl->tpl_vars['background_url']->value) {?>style="background: url(<?php echo $_smarty_tpl->tpl_vars['background_url']->value;?>
) no-repeat center center fixed;"<?php }?>>
    <div class="overlay">
        <nav class="navbar" role="navigation">
            <div class="container">
                
                <div class="navbar-header">
                    <button type="button" class="btn-block btn-drop navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <strong>MENU</strong>
                    </button>
                </div>
            
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav m_t40">
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>

<?php } else { ?>
<div class="header-top">
    
    <nav class="navbar navbar-inverse navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="container">
            
            <div class="navbar-header">
                <a class="navbar-brand" href="<?php echo smarty_function_url(array('path'=>'merchant/dashboard/init'),$_smarty_tpl);?>
"><i class="fa fa-cubes"></i> <strong><?php echo $_smarty_tpl->tpl_vars['ecjia_merchant_cpname']->value;?>
</strong></a>
            </div>
            
            <ul class="nav navbar-nav navbar-left top-menu">
                
                <li id="header_notification_bar" class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="javascript:;">
                        <i class="fa fa-bell-o"></i>
                        <?php if ($_smarty_tpl->tpl_vars['ecjia_merchant_notice_count']->value!=0) {?>
                        <span class="badge bg-warning"><?php echo $_smarty_tpl->tpl_vars['ecjia_merchant_notice_count']->value;?>
</span>
                        <?php }?>
                    </a>
                    <ul class="dropdown-menu extended notification">
                        <div class="notify-arrow notify-arrow-yellow"></div>
                        <li>
                            <p class="yellow">您有 <?php echo $_smarty_tpl->tpl_vars['ecjia_merchant_notice_count']->value;?>
 条新通知</p>
                        </li>
                  		<div class="mh300 ecjiaf-oa">
                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['ecjia_merchant_notice_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                        <li>
                            <a href='<?php echo smarty_function_url(array('path'=>"notification/mh_notification/init",'args'=>"status=not_read"),$_smarty_tpl);?>
'>
                                <div class="f_l">
	                                <span class="label label-info">
	                                	<?php if ($_smarty_tpl->tpl_vars['val']->value['type']=='order_reminder') {?>
	                                	<i class="fa fa-bullhorn"></i>
	                                	<?php } elseif ($_smarty_tpl->tpl_vars['val']->value['type']=='push_event') {?>
	                                	<i class="fa fa-comment"></i>
	                                	<?php } else { ?>
	                                	<i class="fa fa-bullhorn"></i>
	                                	<?php }?>
	                                </span>
                                </div>
                                <div class="f_l mw160">
                                	<?php echo $_smarty_tpl->tpl_vars['val']->value['content'];?>

                                </div>
                            </a>
                        </li>
                        <?php }
if (!$_smarty_tpl->tpl_vars['val']->_loop) {
?>
                      	<li>
                            <a href='javascript:;'>
                                <span class="label label-info">
                                	<i class="fa fa-bullhorn"></i>
                                </span>
                                <span class="m_l5">暂无新通知</span>
                                <span class="small italic"></span>
                            </a>
                        </li>
                 		<?php } ?>
                        </div>
                        <li <?php if ($_smarty_tpl->tpl_vars['ecjia_merchant_notice_count']->value>0) {?>class="ecjiaf-bt"<?php }?>>
                            <a href="<?php echo smarty_function_url(array('path'=>'notification/mh_notification/init'),$_smarty_tpl);?>
">查看所有通知</a>
                        </li>
                    </ul>
                </li>
                
            </ul>
            <ul class="nav navbar-nav navbar-right top-menu">
                <li class="dropdown">
                    <input type="text" class="form-control input-sm search_query" placeholder="Search" data-toggle="dropdown">
                   	<ul class="dropdown-menu search-nav">
                   		<li class="search_query_none"><a href="javascript:;"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
请先输入搜索信息<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a></li>
						<?php echo smarty_function_hook(array('id'=>'merchant_sidebar_collapse_search'),$_smarty_tpl);?>

                   	</ul>
                </li>
                
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="index.html#">
                    	<?php if ($_smarty_tpl->tpl_vars['ecjia_staff_logo']->value) {?>
                        <img alt="" width="30" height="30" src="<?php echo RC_Upload::upload_url();?>
/<?php echo $_smarty_tpl->tpl_vars['ecjia_staff_logo']->value;?>
">
                        <?php } else { ?>
                        <img alt="" width="30" height="30" src="<?php echo $_smarty_tpl->tpl_vars['ecjia_main_static_url']->value;?>
img/ecjia_avatar.jpg">
                        <?php }?>
                        <span class="username"><?php echo $_SESSION['staff_name'];?>
</span>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <div class="log-arrow-up"></div>
                        <li><a href="<?php echo smarty_function_url(array('path'=>'staff/mh_profile/init'),$_smarty_tpl);?>
"><i class="fa fa-cog"></i> 个人设置</a></li>
                        <li><a href="<?php echo smarty_function_url(array('path'=>'notification/mh_notification/init'),$_smarty_tpl);?>
"><i class="fa fa-bell-o"></i> 通知</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo smarty_function_url(array('path'=>'staff/privilege/logout'),$_smarty_tpl);?>
"><i class="fa fa-key"></i> 退出</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    
</div>

<div id="header" 
<?php if ($_smarty_tpl->tpl_vars['background_url']->value) {?>
style="background: url(<?php echo $_smarty_tpl->tpl_vars['background_url']->value;?>
) no-repeat center center fixed;	
-webkit-background-size: cover;
-moz-background-size: cover;
-ms-background-size: cover;
-o-background-size: cover;
background-size: cover;
border-bottom: 15px solid #f2f2f2;"
<?php }?>>
    <div class="overlay">
        <nav class="navbar" role="navigation">
            <div class="container">
                
                <div class="navbar-header">
                    <button type="button" class="btn-block btn-drop navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <strong>MENU</strong>
                    </button>
                </div>
            
                
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <?php echo smarty_function_hook(array('id'=>'merchant_print_header_nav'),$_smarty_tpl);?>

                </div>
            </div>
        </nav>
    </div>
</div>

<?php }?><?php }} ?>
<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 09:10:24
         compiled from "C:\ecjia-daojia-29\content\apps\merchant\templates\merchant\library\common_footer.lbi.php" */ ?>
<?php if ($_valid && !is_callable('content_59084d005e1b14_65747656')) {function content_59084d005e1b14_65747656($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.url.php';
if (!is_callable('smarty_function_hook')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.hook.php';
?> 

<!-- <footer> -->
<!--     <div class="container"> -->
        
<!--     </div> -->
<!-- </footer> -->
<div class="footer-bottom">
    <div class="container">
        <div class="footer-bottom-widget">
            <div class="row">
                <div class="col-sm-6">
                    <p>
	                    <span class="sosmed-footer">
	                    	<?php if (ecjia::config('shop_weibo_url')) {?>
	                        <a target="__blank" href="<?php echo ecjia::config('shop_weibo_url');?>
"><i class="fa fa-weibo" title="新浪微博"></i></a>
	                        <?php }?>
	                        
	                    	<?php if (ecjia::config('qq')) {?>
	                    	<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo ecjia::config('qq');?>
&site=<?php echo $_smarty_tpl->tpl_vars['http_host']->value;?>
&menu=yes"><i class="fa fa-qq" title="腾讯QQ"></i></a>
	                        <?php }?>
	                        
	                        <?php if (ecjia::config('shop_wechat_qrcode')) {?>
	                        <a href="javascript:;" style="color:#333333;"><i class="fa fa-weixin" data-toggle="popover" data-placement="top" data-id="shop_wechat_qrcode" title="打开手机微信扫一扫"></i></a>
	                        <?php }?>
	                        
	                        <?php if (ecjia::config('skype')) {?>
	                        <a target="__blank" href="<?php echo ecjia::config('skype');?>
"><i class="fa fa-skype" title="Skype"></i></a>
	                        <?php }?>
	                        
	                        <?php if (ecjia::config('mobile_iphone_qrcode')) {?>
	                        <a href="javascript:;" style="color:#333333;"><i class="fa fa-apple" data-toggle="popover" data-placement="top" data-id="mobile_iphone_qrcode" title="打开手机扫描二维码下载"></i></a>
	                        <?php }?>
	                        
	                        <?php if (ecjia::config('mobile_android_qrcode')) {?>
	                        <a href="javascript:;" style="color:#333333;"><i class="fa fa-android" data-toggle="popover" data-placement="top" data-id="mobile_android_qrcode" title="打开手机扫描二维码下载"></i></a>
	                    	<?php }?>
	                    </span>
	                    
	                    <?php if (ecjia::config('shop_wechat_qrcode')) {?>
	                    <div class="hide" id="content_shop_wechat_qrcode">
                        	<div class="t_c"><img class="w100 h100" src="<?php echo RC_Upload::upload_url(ecjia::config('shop_wechat_qrcode'));?>
"></div>
                        </div>
                        <?php }?>
                        
                        <?php if (ecjia::config('mobile_iphone_qrcode')) {?>
                        <div class="hide" id="content_mobile_iphone_qrcode">
                        	<div class="t_c"><img class="w100 h100" src="<?php echo RC_Upload::upload_url(ecjia::config('mobile_iphone_qrcode'));?>
"></div>
                        </div>
                        <?php }?>
                        
                        <?php if (ecjia::config('mobile_android_qrcode')) {?>
                        <div class="hide" id="content_mobile_android_qrcode">
                        	<div class="t_c"><img class="w100 h100" src="<?php echo RC_Upload::upload_url(ecjia::config('mobile_android_qrcode'));?>
"></div>
                        </div>
                        <?php }?>
                    </p>
                </div>
                <div class="col-sm-6">
                    <p class="footer-bottom-links">
                    Copyright &copy; 2017 <?php echo ecjia::config('shop_name');?>
 <?php if (ecjia::config('icp_number',2)) {?><a href="http://www.miibeian.gov.cn" target="_blank"><?php echo ecjia::config('icp_number');?>
</a><?php }?>
                    </p>
                    <p class="footer-bottom-links">
                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['ecjia_merchant_shopinfo_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                        <a class="data-pjax" href='<?php echo smarty_function_url(array('path'=>"merchant/merchant/shopinfo",'args'=>"id=".((string)$_smarty_tpl->tpl_vars['val']->value['article_id'])),$_smarty_tpl);?>
'><?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
</a>
                        <?php } ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$("[data-toggle='popover']").popover({
	trigger: 'hover',
	html: true,
	content: function() {
        var id = $(this).attr('data-id');
        return $("#content_" + id).html();
	}
});
</script>

<?php if (ecjia::config('stats_code')) {?>
<?php echo stripslashes(ecjia::config('stats_code'));?>

<?php }?>


<div class="container">
<?php echo smarty_function_hook(array('id'=>'admin_print_main_bottom'),$_smarty_tpl);?>

</div>
<?php }} ?>
