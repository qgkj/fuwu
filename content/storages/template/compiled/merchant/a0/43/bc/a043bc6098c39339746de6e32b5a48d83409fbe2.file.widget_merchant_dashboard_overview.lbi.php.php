<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 08:23:35
         compiled from "C:\ecjia-daojia-29\content\apps\staff\templates\merchant\library\widget_merchant_dashboard_overview.lbi.php" */ ?>
<?php /*%%SmartyHeaderCode:2756559084207e29620-78522356%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a043bc6098c39339746de6e32b5a48d83409fbe2' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\content\\apps\\staff\\templates\\merchant\\library\\widget_merchant_dashboard_overview.lbi.php',
      1 => 1487583420,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2756559084207e29620-78522356',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'order_money' => 0,
    'month_start_time' => 0,
    'month_end_time' => 0,
    'order_number' => 0,
    'order_unconfirmed' => 0,
    'today_start_time' => 0,
    'today_end_time' => 0,
    'unconfirmed' => 0,
    'order_await_ship' => 0,
    'wait_ship' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_59084207e4f878_43806403',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59084207e4f878_43806403')) {function content_59084207e4f878_43806403($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.url.php';
?>
<div class="row state-overview">
    <div class="col-lg-6 col-sm-6">
        <section class="panel">
            <div class="symbol terques">
                <i class="fa fa-money"></i>
            </div>
            <div class="value">
                <h1 class="count"><?php echo $_smarty_tpl->tpl_vars['order_money']->value;?>
</h1>
                <p><a target="__blank" href='<?php echo smarty_function_url(array('path'=>"orders/mh_order_stats/init",'args'=>"start_date=".((string)$_smarty_tpl->tpl_vars['month_start_time']->value)."&end_date=".((string)$_smarty_tpl->tpl_vars['month_end_time']->value)),$_smarty_tpl);?>
'>本月订单总额</a></p>
            </div>
        </section>
    </div>
    <div class="col-lg-6 col-sm-6">
        <section class="panel">
            <div class="symbol red">
                <i class="fa fa-list-alt"></i>
            </div>
            <div class="value">
                <h1 class="count2"><?php echo $_smarty_tpl->tpl_vars['order_number']->value;?>
</h1>
                <p><a target="__blank" href='<?php echo smarty_function_url(array('path'=>"orders/mh_order_stats/init",'args'=>"start_date=".((string)$_smarty_tpl->tpl_vars['month_start_time']->value)."&end_date=".((string)$_smarty_tpl->tpl_vars['month_end_time']->value)),$_smarty_tpl);?>
'>本月订单数量</a></p>
            </div>
        </section>
    </div>
    <div class="col-lg-6 col-sm-6">
        <section class="panel">
            <div class="symbol yellow">
                <i class="fa fa-gavel"></i>
            </div>
            <div class="value">
                <h1 class="count3"><?php echo $_smarty_tpl->tpl_vars['order_unconfirmed']->value;?>
</h1>
                <p><a target="__blank" href='<?php echo smarty_function_url(array('path'=>"orders/merchant/init",'args'=>"start_time=".((string)$_smarty_tpl->tpl_vars['today_start_time']->value)."&end_time=".((string)$_smarty_tpl->tpl_vars['today_end_time']->value)."&composite_status=".((string)$_smarty_tpl->tpl_vars['unconfirmed']->value)),$_smarty_tpl);?>
'>今日待确认订单</a></p>
            </div>
        </section>
    </div>
    <div class="col-lg-6 col-sm-6">
        <section class="panel">
            <div class="symbol purple">
                <i class="fa fa-truck"></i>
            </div>
            <div class="value">
                <h1 class="count4"><?php echo $_smarty_tpl->tpl_vars['order_await_ship']->value;?>
</h1>
                <p><a target="__blank" href='<?php echo smarty_function_url(array('path'=>"orders/merchant/init",'args'=>"start_time=".((string)$_smarty_tpl->tpl_vars['today_start_time']->value)."&end_time=".((string)$_smarty_tpl->tpl_vars['today_end_time']->value)."&composite_status=".((string)$_smarty_tpl->tpl_vars['wait_ship']->value)),$_smarty_tpl);?>
'>今日待发货订单</a></p>
            </div>
        </section>
    </div>
</div>
<?php }} ?>
