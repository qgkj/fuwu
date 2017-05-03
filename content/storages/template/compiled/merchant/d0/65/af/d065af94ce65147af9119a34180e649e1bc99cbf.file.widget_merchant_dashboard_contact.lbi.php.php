<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 08:23:35
         compiled from "C:\ecjia-daojia-29\content\apps\merchant\templates\merchant\library\widget_merchant_dashboard_contact.lbi.php" */ ?>
<?php /*%%SmartyHeaderCode:607659084207ed1383-05326429%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd065af94ce65147af9119a34180e649e1bc99cbf' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\content\\apps\\merchant\\templates\\merchant\\library\\widget_merchant_dashboard_contact.lbi.php',
      1 => 1487583418,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '607659084207ed1383-05326429',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_59084207ed8d97_48381311',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59084207ed8d97_48381311')) {function content_59084207ed8d97_48381311($_smarty_tpl) {?> 

<section class="panel">
    <div class="task-thumb-details">
        <h1>平台联系方式</h1>
    </div>
    <table class="table table-hover personal-task">
        <tbody>
            <tr>
                <td>
                    <i class="fa fa-phone"></i>
                </td>
                <td><?php echo ecjia::config('service_phone');?>
</td>
            </tr>
            <tr>
                <td>
                    <i class="fa fa-envelope"></i>
                </td>
                <td><?php echo ecjia::config('service_email');?>
</td>
            </tr>
        </tbody>
    </table>
</section>
<?php }} ?>
