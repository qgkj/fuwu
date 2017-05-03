<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 08:23:35
         compiled from "C:\ecjia-daojia-29\content\apps\staff\templates\merchant\library\widget_merchant_dashboard_profile.lbi.php" */ ?>
<?php /*%%SmartyHeaderCode:1096659084207e9fa20-40448588%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0880ed40a677ab9497abd056a4d4c2e8593dfb3a' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\content\\apps\\staff\\templates\\merchant\\library\\widget_merchant_dashboard_profile.lbi.php',
      1 => 1487583420,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1096659084207e9fa20-40448588',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'user_info' => 0,
    'ecjia_main_static_url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_59084207ec1f62_28892260',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59084207ec1f62_28892260')) {function content_59084207ec1f62_28892260($_smarty_tpl) {?><?php if (!is_callable('smarty_block_t')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\block.t.php';
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <header class="panel-title">
            <div class="text-center">
                <strong>个人信息</strong>
            </div>
        </header>
    </div>
    <div class="panel-body">
        <div class="text-center" id="author">
			<a href="<?php echo RC_Uri::url('staff/mh_profile/init');?>
">
				<?php if ($_smarty_tpl->tpl_vars['user_info']->value['avatar']=='') {?>
	                <img src="<?php echo $_smarty_tpl->tpl_vars['ecjia_main_static_url']->value;?>
img/ecjia_avatar.jpg" /><br>
	            <?php } else { ?>
	            	<img width ="100" height="100" src="<?php echo RC_Upload::upload_url();?>
/<?php echo $_smarty_tpl->tpl_vars['user_info']->value['avatar'];?>
">
	            <?php }?>
	   		</a>
			<h3><?php echo $_smarty_tpl->tpl_vars['user_info']->value['name'];?>
</h3>
            <?php if ($_smarty_tpl->tpl_vars['user_info']->value['parent_id']==0) {?>
            <small class="label label-warning">店长</small>
            <?php }?>
           	<p><?php if ($_smarty_tpl->tpl_vars['user_info']->value['introduction']=='') {?>主人你好懒，赶紧去个人中心完善资料吧~~<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['user_info']->value['introduction'];?>
<?php }?></p>
            <div class="pull-left">
                 <label class=""><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
上次登录IP：<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</label>
                 <?php echo $_smarty_tpl->tpl_vars['user_info']->value['last_ip'];?>

            </div>
            <div class="pull-left">
                 <label class=""><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
上次登录时间：<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</label>
                 <?php echo $_smarty_tpl->tpl_vars['user_info']->value['last_login'];?>

            </div>
            
        </div>
    </div>

</div>
<?php }} ?>
