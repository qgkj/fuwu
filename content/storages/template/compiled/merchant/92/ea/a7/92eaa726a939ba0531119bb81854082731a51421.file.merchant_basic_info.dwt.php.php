<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 09:17:00
         compiled from "C:\ecjia-daojia-29\content\apps\merchant\templates\merchant\merchant_basic_info.dwt.php" */ ?>
<?php /*%%SmartyHeaderCode:1853059084e8c10c0c4-48050752%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '92eaa726a939ba0531119bb81854082731a51421' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\content\\apps\\merchant\\templates\\merchant\\merchant_basic_info.dwt.php',
      1 => 1487583418,
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
  'nocache_hash' => '1853059084e8c10c0c4-48050752',
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
  'unifunc' => 'content_59084e8c412765_49812161',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59084e8c412765_49812161')) {function content_59084e8c412765_49812161($_smarty_tpl) {?><?php if (!is_callable('smarty_function_hook')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.hook.php';
if (!is_callable('smarty_block_t')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\block.t.php';
if (!is_callable('smarty_function_url')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.url.php';
if (!is_callable('smarty_function_lang')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.lang.php';
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
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("library/common_header.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0, '1853059084e8c10c0c4-48050752');
content_59084e8c1b3e66_33899620($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "library/common_header.lbi.php" */?>
        

        
        <div class="container">
            <div id="main" class="main_content">
                
                <?php echo smarty_function_hook(array('id'=>'merchant_print_main_header'),$_smarty_tpl);?>

                
                
<div class="page-header">
	<div class="pull-left">
		<h2><?php if ($_smarty_tpl->tpl_vars['ur_here']->value) {?><?php echo $_smarty_tpl->tpl_vars['ur_here']->value;?>
<?php }?></h2>
  	</div>
  	<div class="pull-right">
  		<?php if ($_smarty_tpl->tpl_vars['action_link']->value) {?>
		<a href="<?php echo $_smarty_tpl->tpl_vars['action_link']->value['href'];?>
" class="btn btn-primary data-pjax">
			<i class="fa fa-reply"></i> <?php echo $_smarty_tpl->tpl_vars['action_link']->value['text'];?>

		</a>
		<?php }?>
  	</div>
  	<div class="clearfix"></div>
</div>
<style media="screen" type="text/css">
label + div.col-lg-6, label + div.col-lg-2 {
    padding-top: 3px;
    color: #333;
}
</style>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal" name="theForm" action="<?php echo $_smarty_tpl->tpl_vars['form_action']->value;?>
"  method="post" enctype="multipart/form-data" data-toggle='from'>
                  	    <div class="form-group">
                            <label class="control-label col-lg-2"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
店铺名称：<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</label>
                            <div class="col-lg-6">
                                <h4><?php echo $_smarty_tpl->tpl_vars['data']->value['merchants_name'];?>
</h4>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
店铺导航背景图：<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</label>
                            <div class="col-lg-6">
                                <div class="fileupload fileupload-<?php if ($_smarty_tpl->tpl_vars['data']->value['shop_nav_background']) {?>exists<?php } else { ?>new<?php }?>" data-provides="fileupload">
                                    <?php if ($_smarty_tpl->tpl_vars['data']->value['shop_nav_background']) {?>
                                    <div class="fileupload-<?php if ($_smarty_tpl->tpl_vars['data']->value['shop_nav_background']) {?>exists<?php } else { ?>new<?php }?> thumbnail" style="max-width: 60px;">
                                        <img src="<?php echo $_smarty_tpl->tpl_vars['data']->value['shop_nav_background'];?>
" alt="店铺导航背景图" style="width:50px; height:50px;"/>
                                    </div>
                                    <?php }?>
                                    <div class="fileupload-preview fileupload-<?php if ($_smarty_tpl->tpl_vars['data']->value['shop_nav_background']) {?>new<?php } else { ?>exists<?php }?> thumbnail" style="max-width: 60px;max-height: 60px;line-height: 10px;"></div>
                                    <span class="btn btn-primary btn-file btn-sm">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i>浏览</span>
                                        <span class="fileupload-exists"> 修改</span>
                                        <input type="file" class="default" name="shop_nav_background" />
                                    </span>
                                    <a class="btn btn-danger btn-sm fileupload-exists" <?php if ($_smarty_tpl->tpl_vars['data']->value['shop_nav_background']) {?>data-toggle="ajaxremove"<?php } else { ?>data-dismiss="fileupload"<?php }?> href="<?php echo smarty_function_url(array('path'=>'merchant/merchant/drop_file','args'=>"code=shop_nav_background"),$_smarty_tpl);?>
" >删除</a>
                                </div>
                                <span class="help-block">推荐图片的尺寸为：2000x1500px，大小不超过2M</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
店铺LOGO：<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</label>
                            <div class="col-lg-6">
                                <div class="fileupload fileupload-<?php if ($_smarty_tpl->tpl_vars['data']->value['shop_logo']) {?>exists<?php } else { ?>new<?php }?>" data-provides="fileupload">
                                    <?php if ($_smarty_tpl->tpl_vars['data']->value['shop_logo']) {?>
                                    <div class="fileupload-<?php if ($_smarty_tpl->tpl_vars['data']->value['shop_logo']) {?>exists<?php } else { ?>new<?php }?> thumbnail" style="max-width: 60px;">
                                        <img src="<?php echo $_smarty_tpl->tpl_vars['data']->value['shop_logo'];?>
" alt="店铺LOGO" style="width:50px; height:50px;"/>
                                    </div>
                                    <?php }?>
                                    <div class="fileupload-preview fileupload-<?php if ($_smarty_tpl->tpl_vars['data']->value['shop_logo']) {?>new<?php } else { ?>exists<?php }?> thumbnail" style="max-width: 60px;max-height: 60px;line-height: 10px;"></div>
                                    <span class="btn btn-primary btn-file btn-sm">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i>浏览</span>
                                        <span class="fileupload-exists"> 修改</span>
                                        <input type="file" class="default" name="shop_logo" />
                                    </span>
                                    <a class="btn btn-danger btn-sm fileupload-exists" <?php if ($_smarty_tpl->tpl_vars['data']->value['shop_logo']) {?>data-toggle="ajaxremove"<?php } else { ?>data-dismiss="fileupload"<?php }?> href="<?php echo smarty_function_url(array('path'=>'merchant/merchant/drop_file','args'=>"code=shop_logo"),$_smarty_tpl);?>
" >删除</a>
                                	<span class="input-must"><?php echo smarty_function_lang(array('key'=>'system::system.require_field'),$_smarty_tpl);?>
</span>
                                </div>
                                <span class="help-block">推荐图片的尺寸为：512x512px.</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
APP Banner图：<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</label>
                            <div class="col-lg-6">
                                <div class="fileupload fileupload-<?php if ($_smarty_tpl->tpl_vars['data']->value['shop_banner_pic']) {?>exists<?php } else { ?>new<?php }?>" data-provides="fileupload">
                                    <?php if ($_smarty_tpl->tpl_vars['data']->value['shop_banner_pic']) {?>
                                    <div class="fileupload-<?php if ($_smarty_tpl->tpl_vars['data']->value['shop_banner_pic']) {?>exists<?php } else { ?>new<?php }?> thumbnail" style="max-width: 60px;">
                                        <img src="<?php echo $_smarty_tpl->tpl_vars['data']->value['shop_banner_pic'];?>
" alt="banner图" style="width:50px; height:50px;"/>
                                    </div>
                                    <?php }?>
                                    <div class="fileupload-preview fileupload-<?php if ($_smarty_tpl->tpl_vars['data']->value['shop_banner_pic']) {?>new<?php } else { ?>exists<?php }?> thumbnail" style="max-width: 60px;max-height: 60px;line-height: 10px;"></div>
                                    <span class="btn btn-primary btn-file btn-sm">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> 浏览</span>
                                        <span class="fileupload-exists"> 修改</span>
                                        <input type="file" class="default" name="shop_banner_pic" />
                                    </span>
                                    <a class="btn btn-danger btn-sm fileupload-exists" <?php if ($_smarty_tpl->tpl_vars['data']->value['shop_banner_pic']) {?>data-toggle="ajaxremove"<?php } else { ?>data-dismiss="fileupload"<?php }?> href="<?php echo smarty_function_url(array('path'=>'merchant/merchant/drop_file','args'=>"code=shop_banner_pic"),$_smarty_tpl);?>
" >删除</a>
                                </div>
                                <span class="help-block">推荐图片的尺寸为：3:1（600x200px）</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
营业时间：<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</label>
                            <div class="col-lg-6">
                                <div class="range">
                                    <input class="range-slider" name="shop_trade_time" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['shop_time_value'];?>
"/>
                                </div>
                                <span class="help-block">拖拽选取营业时间段</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
客服电话：<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</label>
                            <div class="col-lg-6">
                                <input class="form-control" name="shop_kf_mobile" type="text" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['shop_kf_mobile'];?>
"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="ccomment" class="control-label col-lg-2"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
店铺公告：<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</label>
                            <div class="col-lg-6">
                                <textarea class="form-control" name="shop_notice"><?php echo $_smarty_tpl->tpl_vars['data']->value['shop_notice'];?>
</textarea>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="control-label col-lg-2"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
店铺简介：<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</label>
                            <div class="col-lg-6">
                                <textarea class="form-control" name="shop_description"><?php echo $_smarty_tpl->tpl_vars['data']->value['shop_description'];?>
</textarea>
                            </div>
                        </div>
                        
                        <div class="form-group ">
                            <label class="control-label col-lg-2"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
自动派单：<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</label>
                            <div class="col-lg-6">
                                <input id="open" type="radio" name="express_assign_auto" value="1" <?php if ($_smarty_tpl->tpl_vars['data']->value['express_assign_auto']==1) {?> checked="true" <?php }?>  />
                                <label for="open">开启</label>
                                <input id="close" type="radio" name="express_assign_auto" value="0" <?php if ($_smarty_tpl->tpl_vars['data']->value['express_assign_auto']==0) {?> checked="true" <?php }?>  />
                                <label for="close">关闭</label>
                                <span class="help-block">（订单使用o2o配送方式时。当发货未选择配送员时，系统将自动优先分派配送单，再进入抢单模式，否则进入抢单模式）</span>
                            </div>
                            
                        </div>

                        <div class="form-group ">
                            <div class="col-lg-6 col-md-offset-2">
                                <input class="btn btn-info" type="submit" name="name" value="提交信息">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>

                <?php echo smarty_function_hook(array('id'=>'merchant_print_main_bottom'),$_smarty_tpl);?>

            </div>
        </div>
        

        
        <?php /*  Call merged included template "library/common_footer.lbi.php" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("library/common_footer.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0, '1853059084e8c10c0c4-48050752');
content_59084e8c3039b0_36647497($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "library/common_footer.lbi.php" */?>
        
    </div>
    
	
	
    <?php echo smarty_function_hook(array('id'=>'merchant_print_footer_scripts'),$_smarty_tpl);?>

    
    
    
<script type="text/javascript">
	ecjia.merchant.merchant_info.init();
	ecjia.merchant.merchant_info.range();
</script>

    
    <?php echo smarty_function_hook(array('id'=>'merchant_footer'),$_smarty_tpl);?>

    <div class="pjaxLoadding"><i class="peg"></i></div>
</body>
</html>
<?php } else { ?>
	
	<?php echo smarty_function_hook(array('id'=>'merchant_pjax_head'),$_smarty_tpl);?>

	<?php echo smarty_function_hook(array('id'=>'merchant_print_main_header'),$_smarty_tpl);?>

	
<div class="page-header">
	<div class="pull-left">
		<h2><?php if ($_smarty_tpl->tpl_vars['ur_here']->value) {?><?php echo $_smarty_tpl->tpl_vars['ur_here']->value;?>
<?php }?></h2>
  	</div>
  	<div class="pull-right">
  		<?php if ($_smarty_tpl->tpl_vars['action_link']->value) {?>
		<a href="<?php echo $_smarty_tpl->tpl_vars['action_link']->value['href'];?>
" class="btn btn-primary data-pjax">
			<i class="fa fa-reply"></i> <?php echo $_smarty_tpl->tpl_vars['action_link']->value['text'];?>

		</a>
		<?php }?>
  	</div>
  	<div class="clearfix"></div>
</div>
<style media="screen" type="text/css">
label + div.col-lg-6, label + div.col-lg-2 {
    padding-top: 3px;
    color: #333;
}
</style>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <div class="panel-body">
                <div class="form">
                    <form class="cmxform form-horizontal" name="theForm" action="<?php echo $_smarty_tpl->tpl_vars['form_action']->value;?>
"  method="post" enctype="multipart/form-data" data-toggle='from'>
                  	    <div class="form-group">
                            <label class="control-label col-lg-2"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
店铺名称：<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</label>
                            <div class="col-lg-6">
                                <h4><?php echo $_smarty_tpl->tpl_vars['data']->value['merchants_name'];?>
</h4>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
店铺导航背景图：<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</label>
                            <div class="col-lg-6">
                                <div class="fileupload fileupload-<?php if ($_smarty_tpl->tpl_vars['data']->value['shop_nav_background']) {?>exists<?php } else { ?>new<?php }?>" data-provides="fileupload">
                                    <?php if ($_smarty_tpl->tpl_vars['data']->value['shop_nav_background']) {?>
                                    <div class="fileupload-<?php if ($_smarty_tpl->tpl_vars['data']->value['shop_nav_background']) {?>exists<?php } else { ?>new<?php }?> thumbnail" style="max-width: 60px;">
                                        <img src="<?php echo $_smarty_tpl->tpl_vars['data']->value['shop_nav_background'];?>
" alt="店铺导航背景图" style="width:50px; height:50px;"/>
                                    </div>
                                    <?php }?>
                                    <div class="fileupload-preview fileupload-<?php if ($_smarty_tpl->tpl_vars['data']->value['shop_nav_background']) {?>new<?php } else { ?>exists<?php }?> thumbnail" style="max-width: 60px;max-height: 60px;line-height: 10px;"></div>
                                    <span class="btn btn-primary btn-file btn-sm">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i>浏览</span>
                                        <span class="fileupload-exists"> 修改</span>
                                        <input type="file" class="default" name="shop_nav_background" />
                                    </span>
                                    <a class="btn btn-danger btn-sm fileupload-exists" <?php if ($_smarty_tpl->tpl_vars['data']->value['shop_nav_background']) {?>data-toggle="ajaxremove"<?php } else { ?>data-dismiss="fileupload"<?php }?> href="<?php echo smarty_function_url(array('path'=>'merchant/merchant/drop_file','args'=>"code=shop_nav_background"),$_smarty_tpl);?>
" >删除</a>
                                </div>
                                <span class="help-block">推荐图片的尺寸为：2000x1500px，大小不超过2M</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
店铺LOGO：<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</label>
                            <div class="col-lg-6">
                                <div class="fileupload fileupload-<?php if ($_smarty_tpl->tpl_vars['data']->value['shop_logo']) {?>exists<?php } else { ?>new<?php }?>" data-provides="fileupload">
                                    <?php if ($_smarty_tpl->tpl_vars['data']->value['shop_logo']) {?>
                                    <div class="fileupload-<?php if ($_smarty_tpl->tpl_vars['data']->value['shop_logo']) {?>exists<?php } else { ?>new<?php }?> thumbnail" style="max-width: 60px;">
                                        <img src="<?php echo $_smarty_tpl->tpl_vars['data']->value['shop_logo'];?>
" alt="店铺LOGO" style="width:50px; height:50px;"/>
                                    </div>
                                    <?php }?>
                                    <div class="fileupload-preview fileupload-<?php if ($_smarty_tpl->tpl_vars['data']->value['shop_logo']) {?>new<?php } else { ?>exists<?php }?> thumbnail" style="max-width: 60px;max-height: 60px;line-height: 10px;"></div>
                                    <span class="btn btn-primary btn-file btn-sm">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i>浏览</span>
                                        <span class="fileupload-exists"> 修改</span>
                                        <input type="file" class="default" name="shop_logo" />
                                    </span>
                                    <a class="btn btn-danger btn-sm fileupload-exists" <?php if ($_smarty_tpl->tpl_vars['data']->value['shop_logo']) {?>data-toggle="ajaxremove"<?php } else { ?>data-dismiss="fileupload"<?php }?> href="<?php echo smarty_function_url(array('path'=>'merchant/merchant/drop_file','args'=>"code=shop_logo"),$_smarty_tpl);?>
" >删除</a>
                                	<span class="input-must"><?php echo smarty_function_lang(array('key'=>'system::system.require_field'),$_smarty_tpl);?>
</span>
                                </div>
                                <span class="help-block">推荐图片的尺寸为：512x512px.</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
APP Banner图：<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</label>
                            <div class="col-lg-6">
                                <div class="fileupload fileupload-<?php if ($_smarty_tpl->tpl_vars['data']->value['shop_banner_pic']) {?>exists<?php } else { ?>new<?php }?>" data-provides="fileupload">
                                    <?php if ($_smarty_tpl->tpl_vars['data']->value['shop_banner_pic']) {?>
                                    <div class="fileupload-<?php if ($_smarty_tpl->tpl_vars['data']->value['shop_banner_pic']) {?>exists<?php } else { ?>new<?php }?> thumbnail" style="max-width: 60px;">
                                        <img src="<?php echo $_smarty_tpl->tpl_vars['data']->value['shop_banner_pic'];?>
" alt="banner图" style="width:50px; height:50px;"/>
                                    </div>
                                    <?php }?>
                                    <div class="fileupload-preview fileupload-<?php if ($_smarty_tpl->tpl_vars['data']->value['shop_banner_pic']) {?>new<?php } else { ?>exists<?php }?> thumbnail" style="max-width: 60px;max-height: 60px;line-height: 10px;"></div>
                                    <span class="btn btn-primary btn-file btn-sm">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> 浏览</span>
                                        <span class="fileupload-exists"> 修改</span>
                                        <input type="file" class="default" name="shop_banner_pic" />
                                    </span>
                                    <a class="btn btn-danger btn-sm fileupload-exists" <?php if ($_smarty_tpl->tpl_vars['data']->value['shop_banner_pic']) {?>data-toggle="ajaxremove"<?php } else { ?>data-dismiss="fileupload"<?php }?> href="<?php echo smarty_function_url(array('path'=>'merchant/merchant/drop_file','args'=>"code=shop_banner_pic"),$_smarty_tpl);?>
" >删除</a>
                                </div>
                                <span class="help-block">推荐图片的尺寸为：3:1（600x200px）</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
营业时间：<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</label>
                            <div class="col-lg-6">
                                <div class="range">
                                    <input class="range-slider" name="shop_trade_time" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['shop_time_value'];?>
"/>
                                </div>
                                <span class="help-block">拖拽选取营业时间段</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-lg-2"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
客服电话：<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</label>
                            <div class="col-lg-6">
                                <input class="form-control" name="shop_kf_mobile" type="text" value="<?php echo $_smarty_tpl->tpl_vars['data']->value['shop_kf_mobile'];?>
"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="ccomment" class="control-label col-lg-2"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
店铺公告：<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</label>
                            <div class="col-lg-6">
                                <textarea class="form-control" name="shop_notice"><?php echo $_smarty_tpl->tpl_vars['data']->value['shop_notice'];?>
</textarea>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="control-label col-lg-2"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
店铺简介：<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</label>
                            <div class="col-lg-6">
                                <textarea class="form-control" name="shop_description"><?php echo $_smarty_tpl->tpl_vars['data']->value['shop_description'];?>
</textarea>
                            </div>
                        </div>
                        
                        <div class="form-group ">
                            <label class="control-label col-lg-2"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
自动派单：<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</label>
                            <div class="col-lg-6">
                                <input id="open" type="radio" name="express_assign_auto" value="1" <?php if ($_smarty_tpl->tpl_vars['data']->value['express_assign_auto']==1) {?> checked="true" <?php }?>  />
                                <label for="open">开启</label>
                                <input id="close" type="radio" name="express_assign_auto" value="0" <?php if ($_smarty_tpl->tpl_vars['data']->value['express_assign_auto']==0) {?> checked="true" <?php }?>  />
                                <label for="close">关闭</label>
                                <span class="help-block">（订单使用o2o配送方式时。当发货未选择配送员时，系统将自动优先分派配送单，再进入抢单模式，否则进入抢单模式）</span>
                            </div>
                            
                        </div>

                        <div class="form-group ">
                            <div class="col-lg-6 col-md-offset-2">
                                <input class="btn btn-info" type="submit" name="name" value="提交信息">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>

	<?php echo smarty_function_hook(array('id'=>'merchant_print_main_bottom'),$_smarty_tpl);?>

	
<script type="text/javascript">
	ecjia.merchant.merchant_info.init();
	ecjia.merchant.merchant_info.range();
</script>

	<?php echo smarty_function_hook(array('id'=>'merchant_pjax_footer'),$_smarty_tpl);?>

<?php }?>
<?php }} ?>
<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 09:17:00
         compiled from "C:\ecjia-daojia-29\content\apps\merchant\templates\merchant\library\common_header.lbi.php" */ ?>
<?php if ($_valid && !is_callable('content_59084e8c1b3e66_33899620')) {function content_59084e8c1b3e66_33899620($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.url.php';
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
<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 09:17:00
         compiled from "C:\ecjia-daojia-29\content\apps\merchant\templates\merchant\library\common_footer.lbi.php" */ ?>
<?php if ($_valid && !is_callable('content_59084e8c3039b0_36647497')) {function content_59084e8c3039b0_36647497($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.url.php';
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
