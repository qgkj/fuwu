<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 09:17:09
         compiled from "C:\ecjia-daojia-29\content\apps\merchant\templates\merchant\merchant_info.dwt.php" */ ?>
<?php /*%%SmartyHeaderCode:226959084e955e5389-12538605%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '97edeff85a129183affbd7c1d5bc10d269625d10' => 
    array (
      0 => 'C:\\ecjia-daojia-29\\content\\apps\\merchant\\templates\\merchant\\merchant_info.dwt.php',
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
  'nocache_hash' => '226959084e955e5389-12538605',
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
  'unifunc' => 'content_59084e9596d577_66951202',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_59084e9596d577_66951202')) {function content_59084e9596d577_66951202($_smarty_tpl) {?><?php if (!is_callable('smarty_function_hook')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.hook.php';
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
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("library/common_header.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0, '226959084e955e5389-12538605');
content_59084e95681a16_05626711($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "library/common_header.lbi.php" */?>
        

        
        <div class="container">
            <div id="main" class="main_content">
                
                <?php echo smarty_function_hook(array('id'=>'merchant_print_main_header'),$_smarty_tpl);?>

                
                
<style media="screen" type="text/css">
    label + div.col-lg-6,
    label + div.col-lg-2{
        padding-top: 7px;
    }
    .panel .panel-body{
        padding: 0 15px 15px;
    }
    .table>tbody>tr>td:first{
        border-top: none;
    }
</style>
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
<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-body">
                <section>
                    <h2 class="page-header">店铺信息</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-th-block">
                                <tr>
                                    <td class="active w350" align="right" style="border-top:0px;"><?php echo smarty_function_lang(array('key'=>'merchant::merchant.merchants_type'),$_smarty_tpl);?>
：</td>
                                    <td style="border-top:0px;"><?php if ($_smarty_tpl->tpl_vars['data']->value['validate_type']==1) {?>个人<?php } else { ?>企业<?php }?>入驻</td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right"><?php echo smarty_function_lang(array('key'=>'merchant::merchant.merchants_name'),$_smarty_tpl);?>
：</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['data']->value['merchants_name'];?>
<?php if ($_smarty_tpl->tpl_vars['data']->value['manage_mode']=='self') {?><span class="merchant_tags">自营</span><?php }?></td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right"><?php echo smarty_function_lang(array('key'=>'merchant::merchant.merchant_cat'),$_smarty_tpl);?>
：</td>
                                    <td><?php if ($_smarty_tpl->tpl_vars['data']->value['cat_name']) {?><?php echo $_smarty_tpl->tpl_vars['data']->value['cat_name'];?>
<?php } else { ?><i>< 还未选择 ></i><?php }?></td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right"><?php echo smarty_function_lang(array('key'=>'merchant::merchant.shop_keyword'),$_smarty_tpl);?>
：</td>
                                    <td><?php if ($_smarty_tpl->tpl_vars['data']->value['shop_keyword']) {?><?php echo $_smarty_tpl->tpl_vars['data']->value['shop_keyword'];?>
<?php } else { ?><i>< 还未填写 ></i><?php }?></td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right"><?php echo smarty_function_lang(array('key'=>'merchant::merchant.address'),$_smarty_tpl);?>
：</td>
                                    <td><?php if ($_smarty_tpl->tpl_vars['data']->value['province']||$_smarty_tpl->tpl_vars['data']->value['city']||$_smarty_tpl->tpl_vars['data']->value['district']||$_smarty_tpl->tpl_vars['data']->value['address']) {?>
                                        <?php echo $_smarty_tpl->tpl_vars['data']->value['province'];?>
 <?php echo $_smarty_tpl->tpl_vars['data']->value['city'];?>
 <?php echo $_smarty_tpl->tpl_vars['data']->value['district'];?>
 <?php echo $_smarty_tpl->tpl_vars['data']->value['address'];?>

                                        <?php } else { ?>
                                        <i>< 还未填写 ></i>
                                        <?php }?>
                                    </td>
                                </tr>
                                <?php if ($_smarty_tpl->tpl_vars['data']->value['longitude']&&$_smarty_tpl->tpl_vars['data']->value['latitude']) {?>
                                <tr>
                                    <td class="active w350" align="right"><?php echo smarty_function_lang(array('key'=>'merchant::merchant.merchant_addres'),$_smarty_tpl);?>
：</td>
                                    <td>
                                        <div id="allmap" style="height:320px;"></div>
                                        <div class="help-block">双击放大地图,拖动查看地图其他区域</div>
                                        <div class="help-block">当前经纬度：<?php echo $_smarty_tpl->tpl_vars['data']->value['longitude'];?>
,<?php echo $_smarty_tpl->tpl_vars['data']->value['latitude'];?>
</div>
                                    </td>
                                </tr>
                                <?php }?>
                            </table>
                        </div>
                    </div>
                </section>

                <section>
                    <h2 class="page-header">联系人信息</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-th-block">
                                <tr>
                                    <td class="active w350" align="right" style="border-top:0px;"><?php echo smarty_function_lang(array('key'=>'merchant::merchant.responsible_person'),$_smarty_tpl);?>
：</td>
                                    <td style="border-top:0px;">
                                        <?php if ($_smarty_tpl->tpl_vars['data']->value['responsible_person']) {?>
                                        <?php echo $_smarty_tpl->tpl_vars['data']->value['responsible_person'];?>

                                        <?php } else { ?>
                                        <i>< 还未填写 ></i>
                                        <?php }?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right"><?php echo smarty_function_lang(array('key'=>'merchant::merchant.email'),$_smarty_tpl);?>
：</td>
                                    <td>
                                        <?php if ($_smarty_tpl->tpl_vars['data']->value['email']) {?>
                                        <?php echo $_smarty_tpl->tpl_vars['data']->value['email'];?>

                                        <?php } else { ?>
                                        <i>< 还未填写 ></i>
                                        <?php }?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right"><?php echo smarty_function_lang(array('key'=>'merchant::merchant.contact_mobile'),$_smarty_tpl);?>
：</td>
                                    <td>
                                        <?php if ($_smarty_tpl->tpl_vars['data']->value['contact_mobile']) {?>
                                        <?php echo $_smarty_tpl->tpl_vars['data']->value['contact_mobile'];?>

                                        <?php } else { ?>
                                        <i>< 还未填写 ></i>
                                        <?php }?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </section>

                <section>
                    <h2 class="page-header">资质信息</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-th-block">
                                <tr>
                                    <td class="active w350" align="right" style="border-top:0px;"><?php echo smarty_function_lang(array('key'=>'merchant::merchant.identity_type'),$_smarty_tpl);?>
：</td>
                                    <td style="border-top:0px;">
                                        <?php if ($_smarty_tpl->tpl_vars['data']->value['identity_type']==1) {?>身份证<?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['data']->value['identity_type']==2) {?>护照<?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['data']->value['identity_type']==3) {?>港澳身份证<?php }?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right"><?php echo smarty_function_lang(array('key'=>'merchant::merchant.identity_number'),$_smarty_tpl);?>
：</td>
                                    <td><?php if ($_smarty_tpl->tpl_vars['data']->value['identity_number']) {?><?php echo $_smarty_tpl->tpl_vars['data']->value['identity_number'];?>
<?php } else { ?><i>< 还未填写 ></i><?php }?></td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right"><?php echo smarty_function_lang(array('key'=>'merchant::merchant.identity_pic_front'),$_smarty_tpl);?>
：</td>
                                    <td><?php if ($_smarty_tpl->tpl_vars['data']->value['identity_pic_front']) {?><img class="merchant-info-img w200 h120" src="<?php echo $_smarty_tpl->tpl_vars['data']->value['identity_pic_front'];?>
" alt="证件正面"/><?php } else { ?><i>< 还未上传 ></i><?php }?></td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right"><?php echo smarty_function_lang(array('key'=>'merchant::merchant.identity_pic_back'),$_smarty_tpl);?>
：</td>
                                    <td><?php if ($_smarty_tpl->tpl_vars['data']->value['identity_pic_back']) {?><img class="merchant-info-img w200 h120" src="<?php echo $_smarty_tpl->tpl_vars['data']->value['identity_pic_back'];?>
" alt="证件反面"/><?php } else { ?><i>< 还未上传 ></i><?php }?></td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right"><?php echo smarty_function_lang(array('key'=>'merchant::merchant.personhand_identity_pic'),$_smarty_tpl);?>
：</td>
                                    <td><?php if ($_smarty_tpl->tpl_vars['data']->value['personhand_identity_pic']) {?><img class="merchant-info-img w200 h120" src="<?php echo $_smarty_tpl->tpl_vars['data']->value['personhand_identity_pic'];?>
" alt="手持证件拍照"/><?php } else { ?><i>< 还未上传 ></i><?php }?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </section>

                <?php if ($_smarty_tpl->tpl_vars['data']->value['validate_type']==2) {?>
                <section>
                    <h2 class="page-header">公司信息</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-th-block">
                                <tr>
                                    <td class="active w350" align="right" style="border-top:0px;"><?php echo smarty_function_lang(array('key'=>'merchant::merchant.company_name'),$_smarty_tpl);?>
：</td>
                                    <td style="border-top:0px;"><?php echo $_smarty_tpl->tpl_vars['data']->value['company_name'];?>
</td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right"><?php echo smarty_function_lang(array('key'=>'merchant::merchant.business_licence'),$_smarty_tpl);?>
：</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['data']->value['business_licence'];?>
</td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right"><?php echo smarty_function_lang(array('key'=>'merchant::merchant.business_licence_pic'),$_smarty_tpl);?>
：</td>
                                    <td><?php if ($_smarty_tpl->tpl_vars['data']->value['business_licence_pic']) {?><img class="merchant-info-img w200 h120" src="<?php echo $_smarty_tpl->tpl_vars['data']->value['business_licence_pic'];?>
" alt="营业执照"/><?php }?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </section>
                <?php }?>

            </div>
        </div>

        <div class="form-group ">
            <div class="col-lg-6 col-md-offset-4">
                <a class="btn btn-info data-pjax" href="<?php echo smarty_function_url(array('path'=>"merchant/mh_franchisee/request_edit"),$_smarty_tpl);?>
">申请修改</a>
            </div>
        </div>
    </div>
</div>

                <?php echo smarty_function_hook(array('id'=>'merchant_print_main_bottom'),$_smarty_tpl);?>

            </div>
        </div>
        

        
        <?php /*  Call merged included template "library/common_footer.lbi.php" */
$_tpl_stack[] = $_smarty_tpl;
 $_smarty_tpl = $_smarty_tpl->setupInlineSubTemplate("library/common_footer.lbi.php", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0, '226959084e955e5389-12538605');
content_59084e957c2130_77303958($_smarty_tpl);
$_smarty_tpl = array_pop($_tpl_stack); 
/*  End of included template "library/common_footer.lbi.php" */?>
        
    </div>
    
	
	
    <?php echo smarty_function_hook(array('id'=>'merchant_print_footer_scripts'),$_smarty_tpl);?>

    
    
    
<script type="text/javascript" src="https://api.map.baidu.com/api?v=2.0&ak=P4C6rokKFWHjXELjOnogw3zbxC0VYubo"></script>
<script type="text/javascript">
    // 百度地图API功能
    var step='<?php echo $_smarty_tpl->tpl_vars['step']->value;?>
';
    var lng='<?php echo $_smarty_tpl->tpl_vars['data']->value['longitude'];?>
';
    var lat='<?php echo $_smarty_tpl->tpl_vars['data']->value['latitude'];?>
';
    if(lng && lat){
        var map = new BMap.Map("allmap");
        var point = new BMap.Point(lng, lat); // 创建点坐标
        map.centerAndZoom(point,15);

        var marker = new BMap.Marker(point);  // 创建标注
        map.addOverlay(marker);               // 将标注添加到地图中

    }
</script>

    
    <?php echo smarty_function_hook(array('id'=>'merchant_footer'),$_smarty_tpl);?>

    <div class="pjaxLoadding"><i class="peg"></i></div>
</body>
</html>
<?php } else { ?>
	
	<?php echo smarty_function_hook(array('id'=>'merchant_pjax_head'),$_smarty_tpl);?>

	<?php echo smarty_function_hook(array('id'=>'merchant_print_main_header'),$_smarty_tpl);?>

	
<style media="screen" type="text/css">
    label + div.col-lg-6,
    label + div.col-lg-2{
        padding-top: 7px;
    }
    .panel .panel-body{
        padding: 0 15px 15px;
    }
    .table>tbody>tr>td:first{
        border-top: none;
    }
</style>
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
<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-body">
                <section>
                    <h2 class="page-header">店铺信息</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-th-block">
                                <tr>
                                    <td class="active w350" align="right" style="border-top:0px;"><?php echo smarty_function_lang(array('key'=>'merchant::merchant.merchants_type'),$_smarty_tpl);?>
：</td>
                                    <td style="border-top:0px;"><?php if ($_smarty_tpl->tpl_vars['data']->value['validate_type']==1) {?>个人<?php } else { ?>企业<?php }?>入驻</td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right"><?php echo smarty_function_lang(array('key'=>'merchant::merchant.merchants_name'),$_smarty_tpl);?>
：</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['data']->value['merchants_name'];?>
<?php if ($_smarty_tpl->tpl_vars['data']->value['manage_mode']=='self') {?><span class="merchant_tags">自营</span><?php }?></td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right"><?php echo smarty_function_lang(array('key'=>'merchant::merchant.merchant_cat'),$_smarty_tpl);?>
：</td>
                                    <td><?php if ($_smarty_tpl->tpl_vars['data']->value['cat_name']) {?><?php echo $_smarty_tpl->tpl_vars['data']->value['cat_name'];?>
<?php } else { ?><i>< 还未选择 ></i><?php }?></td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right"><?php echo smarty_function_lang(array('key'=>'merchant::merchant.shop_keyword'),$_smarty_tpl);?>
：</td>
                                    <td><?php if ($_smarty_tpl->tpl_vars['data']->value['shop_keyword']) {?><?php echo $_smarty_tpl->tpl_vars['data']->value['shop_keyword'];?>
<?php } else { ?><i>< 还未填写 ></i><?php }?></td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right"><?php echo smarty_function_lang(array('key'=>'merchant::merchant.address'),$_smarty_tpl);?>
：</td>
                                    <td><?php if ($_smarty_tpl->tpl_vars['data']->value['province']||$_smarty_tpl->tpl_vars['data']->value['city']||$_smarty_tpl->tpl_vars['data']->value['district']||$_smarty_tpl->tpl_vars['data']->value['address']) {?>
                                        <?php echo $_smarty_tpl->tpl_vars['data']->value['province'];?>
 <?php echo $_smarty_tpl->tpl_vars['data']->value['city'];?>
 <?php echo $_smarty_tpl->tpl_vars['data']->value['district'];?>
 <?php echo $_smarty_tpl->tpl_vars['data']->value['address'];?>

                                        <?php } else { ?>
                                        <i>< 还未填写 ></i>
                                        <?php }?>
                                    </td>
                                </tr>
                                <?php if ($_smarty_tpl->tpl_vars['data']->value['longitude']&&$_smarty_tpl->tpl_vars['data']->value['latitude']) {?>
                                <tr>
                                    <td class="active w350" align="right"><?php echo smarty_function_lang(array('key'=>'merchant::merchant.merchant_addres'),$_smarty_tpl);?>
：</td>
                                    <td>
                                        <div id="allmap" style="height:320px;"></div>
                                        <div class="help-block">双击放大地图,拖动查看地图其他区域</div>
                                        <div class="help-block">当前经纬度：<?php echo $_smarty_tpl->tpl_vars['data']->value['longitude'];?>
,<?php echo $_smarty_tpl->tpl_vars['data']->value['latitude'];?>
</div>
                                    </td>
                                </tr>
                                <?php }?>
                            </table>
                        </div>
                    </div>
                </section>

                <section>
                    <h2 class="page-header">联系人信息</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-th-block">
                                <tr>
                                    <td class="active w350" align="right" style="border-top:0px;"><?php echo smarty_function_lang(array('key'=>'merchant::merchant.responsible_person'),$_smarty_tpl);?>
：</td>
                                    <td style="border-top:0px;">
                                        <?php if ($_smarty_tpl->tpl_vars['data']->value['responsible_person']) {?>
                                        <?php echo $_smarty_tpl->tpl_vars['data']->value['responsible_person'];?>

                                        <?php } else { ?>
                                        <i>< 还未填写 ></i>
                                        <?php }?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right"><?php echo smarty_function_lang(array('key'=>'merchant::merchant.email'),$_smarty_tpl);?>
：</td>
                                    <td>
                                        <?php if ($_smarty_tpl->tpl_vars['data']->value['email']) {?>
                                        <?php echo $_smarty_tpl->tpl_vars['data']->value['email'];?>

                                        <?php } else { ?>
                                        <i>< 还未填写 ></i>
                                        <?php }?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right"><?php echo smarty_function_lang(array('key'=>'merchant::merchant.contact_mobile'),$_smarty_tpl);?>
：</td>
                                    <td>
                                        <?php if ($_smarty_tpl->tpl_vars['data']->value['contact_mobile']) {?>
                                        <?php echo $_smarty_tpl->tpl_vars['data']->value['contact_mobile'];?>

                                        <?php } else { ?>
                                        <i>< 还未填写 ></i>
                                        <?php }?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </section>

                <section>
                    <h2 class="page-header">资质信息</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-th-block">
                                <tr>
                                    <td class="active w350" align="right" style="border-top:0px;"><?php echo smarty_function_lang(array('key'=>'merchant::merchant.identity_type'),$_smarty_tpl);?>
：</td>
                                    <td style="border-top:0px;">
                                        <?php if ($_smarty_tpl->tpl_vars['data']->value['identity_type']==1) {?>身份证<?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['data']->value['identity_type']==2) {?>护照<?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['data']->value['identity_type']==3) {?>港澳身份证<?php }?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right"><?php echo smarty_function_lang(array('key'=>'merchant::merchant.identity_number'),$_smarty_tpl);?>
：</td>
                                    <td><?php if ($_smarty_tpl->tpl_vars['data']->value['identity_number']) {?><?php echo $_smarty_tpl->tpl_vars['data']->value['identity_number'];?>
<?php } else { ?><i>< 还未填写 ></i><?php }?></td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right"><?php echo smarty_function_lang(array('key'=>'merchant::merchant.identity_pic_front'),$_smarty_tpl);?>
：</td>
                                    <td><?php if ($_smarty_tpl->tpl_vars['data']->value['identity_pic_front']) {?><img class="merchant-info-img w200 h120" src="<?php echo $_smarty_tpl->tpl_vars['data']->value['identity_pic_front'];?>
" alt="证件正面"/><?php } else { ?><i>< 还未上传 ></i><?php }?></td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right"><?php echo smarty_function_lang(array('key'=>'merchant::merchant.identity_pic_back'),$_smarty_tpl);?>
：</td>
                                    <td><?php if ($_smarty_tpl->tpl_vars['data']->value['identity_pic_back']) {?><img class="merchant-info-img w200 h120" src="<?php echo $_smarty_tpl->tpl_vars['data']->value['identity_pic_back'];?>
" alt="证件反面"/><?php } else { ?><i>< 还未上传 ></i><?php }?></td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right"><?php echo smarty_function_lang(array('key'=>'merchant::merchant.personhand_identity_pic'),$_smarty_tpl);?>
：</td>
                                    <td><?php if ($_smarty_tpl->tpl_vars['data']->value['personhand_identity_pic']) {?><img class="merchant-info-img w200 h120" src="<?php echo $_smarty_tpl->tpl_vars['data']->value['personhand_identity_pic'];?>
" alt="手持证件拍照"/><?php } else { ?><i>< 还未上传 ></i><?php }?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </section>

                <?php if ($_smarty_tpl->tpl_vars['data']->value['validate_type']==2) {?>
                <section>
                    <h2 class="page-header">公司信息</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-th-block">
                                <tr>
                                    <td class="active w350" align="right" style="border-top:0px;"><?php echo smarty_function_lang(array('key'=>'merchant::merchant.company_name'),$_smarty_tpl);?>
：</td>
                                    <td style="border-top:0px;"><?php echo $_smarty_tpl->tpl_vars['data']->value['company_name'];?>
</td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right"><?php echo smarty_function_lang(array('key'=>'merchant::merchant.business_licence'),$_smarty_tpl);?>
：</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['data']->value['business_licence'];?>
</td>
                                </tr>
                                <tr>
                                    <td class="active w350" align="right"><?php echo smarty_function_lang(array('key'=>'merchant::merchant.business_licence_pic'),$_smarty_tpl);?>
：</td>
                                    <td><?php if ($_smarty_tpl->tpl_vars['data']->value['business_licence_pic']) {?><img class="merchant-info-img w200 h120" src="<?php echo $_smarty_tpl->tpl_vars['data']->value['business_licence_pic'];?>
" alt="营业执照"/><?php }?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </section>
                <?php }?>

            </div>
        </div>

        <div class="form-group ">
            <div class="col-lg-6 col-md-offset-4">
                <a class="btn btn-info data-pjax" href="<?php echo smarty_function_url(array('path'=>"merchant/mh_franchisee/request_edit"),$_smarty_tpl);?>
">申请修改</a>
            </div>
        </div>
    </div>
</div>

	<?php echo smarty_function_hook(array('id'=>'merchant_print_main_bottom'),$_smarty_tpl);?>

	
<script type="text/javascript" src="https://api.map.baidu.com/api?v=2.0&ak=P4C6rokKFWHjXELjOnogw3zbxC0VYubo"></script>
<script type="text/javascript">
    // 百度地图API功能
    var step='<?php echo $_smarty_tpl->tpl_vars['step']->value;?>
';
    var lng='<?php echo $_smarty_tpl->tpl_vars['data']->value['longitude'];?>
';
    var lat='<?php echo $_smarty_tpl->tpl_vars['data']->value['latitude'];?>
';
    if(lng && lat){
        var map = new BMap.Map("allmap");
        var point = new BMap.Point(lng, lat); // 创建点坐标
        map.centerAndZoom(point,15);

        var marker = new BMap.Marker(point);  // 创建标注
        map.addOverlay(marker);               // 将标注添加到地图中

    }
</script>

	<?php echo smarty_function_hook(array('id'=>'merchant_pjax_footer'),$_smarty_tpl);?>

<?php }?>
<?php }} ?>
<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 09:17:09
         compiled from "C:\ecjia-daojia-29\content\apps\merchant\templates\merchant\library\common_header.lbi.php" */ ?>
<?php if ($_valid && !is_callable('content_59084e95681a16_05626711')) {function content_59084e95681a16_05626711($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.url.php';
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
<?php /* Smarty version Smarty-3.1.18, created on 2017-05-02 09:17:09
         compiled from "C:\ecjia-daojia-29\content\apps\merchant\templates\merchant\library\common_footer.lbi.php" */ ?>
<?php if ($_valid && !is_callable('content_59084e957c2130_77303958')) {function content_59084e957c2130_77303958($_smarty_tpl) {?><?php if (!is_callable('smarty_function_url')) include 'C:\\ecjia-daojia-29\\content\\system\\smarty\\function.url.php';
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
