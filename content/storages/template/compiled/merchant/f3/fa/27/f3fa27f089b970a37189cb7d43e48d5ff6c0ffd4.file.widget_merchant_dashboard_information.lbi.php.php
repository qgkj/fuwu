<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 08:23:35
         compiled from "C:\ecjia-daojia-29\content\apps\staff\templates\merchant\library\widget_merchant_dashboard_information.lbi.php" */ ?>
<?php /*%%SmartyHeaderCode:1976959084207dd5771-80789127%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f3fa27f089b970a37189cb7d43e48d5ff6c0ffd4' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\content\\apps\\staff\\templates\\merchant\\library\\widget_merchant_dashboard_information.lbi.php',
      1 => 1487583420,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1976959084207dd5771-80789127',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'merchant_info' => 0,
    'ecjia_main_static_url' => 0,
    'ecjia_merchant_cpname' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_59084207dec5a7_05492431',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59084207dec5a7_05492431')) {function content_59084207dec5a7_05492431($_smarty_tpl) {?><div class="row">
	<div class="col-lg-12">
		<div class="panel">
	    	<div class="panel-body">
	        	<div class="row">
	            	<div class="col-sm-3">
	            		 <?php if ($_smarty_tpl->tpl_vars['merchant_info']->value['shop_logo']) {?>
	                	 	<img src="<?php echo $_smarty_tpl->tpl_vars['merchant_info']->value['shop_logo'];?>
" width="200" height="200" class="thumbnail" style="margin-left: 20px;margin-bottom: 0;" />
	                	 <?php } else { ?>
	                	 	<img src="<?php echo $_smarty_tpl->tpl_vars['ecjia_main_static_url']->value;?>
img/merchant_logo.jpg"  width="200" height="200" class="thumbnail" style="margin-left: 20px;margin-bottom: 0;" />
	                	 <?php }?>
	            	</div>
	            	<div class="col-sm-5">
		                <h4>
		                    <strong><?php echo $_smarty_tpl->tpl_vars['ecjia_merchant_cpname']->value;?>
</strong>
		                </h4>
	                	<hr style="margin-top: 10px;margin-bottom: 10px;">
	                	<p><?php if ($_smarty_tpl->tpl_vars['merchant_info']->value['shop_description']) {?><?php echo $_smarty_tpl->tpl_vars['merchant_info']->value['shop_description'];?>
<?php } else { ?>店长有点懒哦，赶紧去完善店铺资料吧~~<?php }?></p>
	            	</div>
	            	
	            	<div class="col-sm-4">
		                <h4 class="title-real-estates">
		                    <strong>小店资料</strong>
		                </h4>
	                	<hr style="margin-top: 10px;margin-bottom: 10px;">
            			<div><label>营业时间：</label><?php echo $_smarty_tpl->tpl_vars['merchant_info']->value['shop_trade_time'];?>
</div>
            			<div><label>店铺公告：</label><?php echo $_smarty_tpl->tpl_vars['merchant_info']->value['shop_notice'];?>
</div>
	            	</div>
	        	</div>
	    	</div>
		</div>
	</div>
</div>
<?php }} ?>
